<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Common\League;
use App\Models\Common\ResultType;
use App\Models\Events\Event;
use App\Models\Players\PlayerLocal;
use App\Models\Players\PlayerVisitor;
use App\Models\Results\ByMark;
use App\Models\Results\ByPoint;
use App\Models\Results\BySet;
use App\Models\Results\MarkName;
use App\Models\Results\Set;
use App\Models\Teams\TeamLocal;
use App\Models\Teams\TeamVisitor;
use App\Models\Whereabouts\Venue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function create(CreateEventRequest $request)
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

    public function update(UpdateEventRequest $request, Event $event)
    {
        try {
            DB::transaction(function () use ($request, $event) {
                $event->update([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                    'league_id' => $request->post('leagueId')
                ]);
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
        $result = BySet::create([
            'event_id' => $eventId,
            'set_amount' => $request->post('setAmount'),
            'result_type_id' => $request->post('resultTypeId')
        ]);
        for ($i=1; $i < $request->post('setAmount') + 1; $i++) { 
            Set::create([
                'by_set_id' => $result->id,
                'number' => $i
            ]);
        }
        return $result;
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
}
