<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Common\League;
use App\Models\Common\ResultType;
use App\Models\Events\Event;
use App\Models\Players\PlayerLocal;
use App\Models\Players\PlayerVisitor;
use App\Models\Results\ByMark;
use App\Models\Results\ByPoint;
use App\Models\Results\BySet;
use App\Models\Results\MarkName;
use App\Models\Teams\TeamLocal;
use App\Models\Teams\TeamVisitor;
use App\Models\Whereabouts\Venue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function create(EventRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $event = Event::create([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                    'league_id' => $request->post('leagueId')
                ]);
                if ($request->post('isIndividual')) {
                    $this->createIndividualEvent($request, $event->id);
                } else {
                    $this->createTeamEvent($request, $event->id);
                }
                $this->createResult($request, $event->id);
            });
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Unable to create event right now.');
        }     
        return back()->with('statusCreate', 'Event registered successfully.');
    }

    public function update(EventRequest $request, Event $event)
    {
        try {
            DB::transaction(function () use ($request, $event) {
                $event->update([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                    'league_id' => $request->post('leagueId')
                ]);
    
                if ($event->isIndividual()) {
                    $this->updatePlayers($event, [
                        'localId' => $request->post('playerLocalId'), 
                        'visitorId' => $request->post('playerVisitorId')
                    ]);
                } else {
                    $this->updateTeams($event, [
                        'localId' => $request->post('teamLocalId'), 
                        'visitorId' => $request->post('teamVisitorId')
                    ]);
                }
                if ($request->post('resultTypeId') == $event->result()->type->id) {
                    if($event->result()->type->id !== 2)
                        $this->updateResult($event, $request);
                } else {
                    $this->deleteResult($event);
                    $this->createResult($request, $event->id);
                }
            });
        } catch (QueryException $e) {
            return back()->with([
                'statusUpdate' => 'Unable to update event right now.',
                'isRedirected' => 'true'
            ]);
        }
        return back()->with([
            'statusUpdate' => 'Event updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Event $event)
    {
        $event->delete();
        return back()->with([
            'statusDelete' => 'Event deleted successfully.',
            'deletedId' => $event->id
        ]);
    }

    public function restore(Request $request)
    {
        Event::withTrashed()
            ->findOrFail($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Event restored successfully.');
    }

    public function show()
    {
        return view('eventManagement', [
            'events' => Event::all(),
            'leagues' => League::all(),
            'venues' => Venue::all(),
            'resultTypes' => ResultType::all(),
            'markNames' => MarkName::all(),
        ]);
    }

    public function edit(Event $event)
    {
        return view('eventUpdate', [
            'event' => $event,
            'leagues' => League::all(),
            'venues' => Venue::all(),
            'resultTypes' => ResultType::all(),
            'markNames' => MarkName::all(),
        ]);
    }

    private function createResult($request, $eventId)
    {
        $results = [
            '1' => [$this, 'createByMarksResult'],
            '2' => [$this, 'createByPointsResult'],
            '3' => [$this, 'createBySetsResult'],
        ];
        call_user_func_array(
            $results[$request->post('resultTypeId')], 
            [$request, $eventId]
        );
    }

    private function deleteResult(Event $event)
    {
        $event->result()->delete();
    }

    private function updateResult(Event $event, $request)
    {
        $results = [
            '1' => [$this, 'updateByMarksResult'],
            '3' => [$this, 'updateBySetsResult'],
        ];
        call_user_func_array(
            $results[$event->result()->type->id],
            [$event->result(), $request]
        );
    }

    private function updateByMarksResult(ByMark $result, $request)
    {
        $result->update([
            'mark_name_id' => $request->post('markNameId')
        ]);
    }

    private function updateBySetsResult(BySet $result, $request)
    {
        $result->update([
            'set_amount' => $request->post('setAmount')
        ]);
    }

    private function createByMarksResult($request, $eventId) 
    {
        ByMark::create([
            'event_id' => $eventId,
            'mark_name_id' => $request->post('markNameId'),
            'result_type_id' => $request->post('resultTypeId')
        ]);
    }

    private function createByPointsResult($request, $eventId) 
    {
        ByPoint::create([
            'event_id' => $eventId,
            'result_type_id' => $request->post('resultTypeId')
        ]);
    }

    private function createBySetsResult($request, $eventId)
    {
        BySet::create([
            'event_id' => $eventId,
            'set_amount' => $request->post('setAmount'),
            'result_type_id' => $request->post('resultTypeId')
        ]);
    }

    private function createIndividualEvent($request, $eventId)
    {
        PlayerVisitor::create([
            'event_id' => $eventId,
            'player_id' => $request->post('playerVisitorId')
        ]);
        PlayerLocal::create([
            'event_id' => $eventId,
            'player_id' => $request->post('playerLocalId')
        ]);
    }

    private function createTeamEvent($request, $eventId)
    {
        TeamVisitor::create([
            'event_id' => $eventId,
            'team_id' => $request->post('teamVisitorId')
        ]);
        TeamLocal::create([
            'event_id' => $eventId,
            'team_id' => $request->post('teamLocalId')
        ]);
    }

    private function updatePlayers($event, $players)
    {
        $event->playerLocal->update([
            'player_id' => $players['localId']
        ]);
        $event->playerVisitor->update([
            'player_id' => $players['visitorId']
        ]);
    }

    private function updateTeams($event, $teams)
    {
        $event->teamLocal->update([
            'team_id' => $teams['localId']
        ]);
        $event->teamVisitor->update([
            'team_id' => $teams['visitorId']
        ]);
    }
}
