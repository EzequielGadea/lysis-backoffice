<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\EventCreateRequest;
use App\Http\Requests\Events\EventUpdateRequest;
use App\Http\Requests\Events\CheckIdRequest;
use App\Models\Common\League;
use App\Models\Common\ResultType;
use App\Models\Events\Event;
use App\Models\Players\PlayerLocal;
use App\Models\Players\PlayerVisitor;
use App\Models\Teams\TeamLocal;
use App\Models\Results\ByMark;
use App\Models\Results\ByPoint;
use App\Models\Results\BySet;
use App\Models\Results\MarkName;
use App\Models\Teams\TeamVisitor;
use App\Models\Whereabouts\Venue;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function create(EventCreateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $event = Event::create([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                    'league_id' => $request->post('leagueId')
                ]);
                if($request->post('isIndividual')) {
                    $this->createIndividualEvent($request, $event->id);
                } else {
                    $this->createTeamEvent($request, $event->id);
                }

                $this->createResult($request, $event->id);
                
            });
            return back()->with('statusCreate', 'Event registered successfully.');
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Unable to create event right now.');
        }     
    }

    public function update(EventUpdateRequest $request)
    {
        $event = Event::find($request->post('eventId'));

        try {
            DB::transaction(function () use ($request, $event){
                $event->update([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                    'league_id' => $request->post('leagueId')
                ]);

                if($event->isIndividual()){
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

    public function delete(CheckIdRequest $request)
    {
        Event::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Event deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(CheckIdRequest $request)
    {
        Event::withTrashed()
            ->find($request->post('id'))
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

    public function edit($id)
    {
        $validation = $this->validateId($id);
        if($validation !== true)
            return back();

        return view('eventUpdate', [
            'event' => Event::find($id),
            'leagues' => League::all(),
            'venues' => Venue::all(),
            'resultTypes' => ResultType::all(),
            'markNames' => MarkName::all(),
        ]);
    }

    private function createResult($request, $eventId)
    {
        $results = array(
            '1' => array($this, 'createByMarksResult'),
            '2' => array($this, 'createByPointsResult'),
            '3' => array($this, 'createBySetsResult')
        );

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
        BySet::create([
            'event_id' => $eventId,
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

    private function validateId($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:events'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
