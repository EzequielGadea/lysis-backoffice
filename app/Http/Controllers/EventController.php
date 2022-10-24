<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Events\Event;
use App\Models\Common\League;
use App\Models\Whereabouts\Venue;
use App\Models\Players\PlayerVisitor;
use App\Models\Players\PlayerLocal;
use App\Models\Teams\TeamVisitor;
use App\Models\Teams\TeamLocal;
use App\Http\Requests\EventController\EventCreateRequest;
use App\Http\Requests\EventController\EventUpdateRequest;
use App\Http\Requests\EventController\CheckIdRequest;

class EventController extends Controller
{
    public function create(EventCreateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $event = Event::create([
                    'start_date' => $request->post('startDate'),
                    'venue_id' => $request->post('venueId'),
                ]);
                if($request->post('leagueId'))
                    $event->league()->attach($request->post('leagueId'));

                /**
                 * PERDON PROFE USE UN ELSE :(
                 */
                if($request->post('isIndividual')) {
                    $this->createIndividualEvent($request, $event->id);
                } else {
                    $this->createTeamEvent($request, $event->id);
                }    
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
                    'venue_id' => $request->post('venueId')
                ]);
                if($event->hasLeague())
                    $event->league()->updateExistingPivot($event->id, [
                        'league_id' => $request->post('leagueId')
                    ]);
                if($event->isIndividual()){
                    $event->playerLocal->update([
                        'player_id' => $request->post('playerLocalId')
                    ]);
                    $event->playerVisitor->update([
                        'player_id' => $request->post('playerVisitorId')
                    ]);
                    return back()->with('statusUpdate', 'Individual event updated successfully.');
                }
                $event->teamLocal->update([
                    'team_id' => $request->post('localTeamId')
                ]);
                $event->teamVisitor->update([
                    'team_id' => $request->post('visitorTeamId')
                ]);
                return back()->with('statusUpdate', 'Team event updated successfully.');
            });
        } catch (QueryException $e) {
            return back()->with('statusUpdate', 'Unable to update event right now.');
        }
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
            'venues' => Venue::all()
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
            'venues' => Venue::all()
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
