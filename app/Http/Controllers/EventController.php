<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Events\Event;
use App\Models\Players\PlayerVisitor;
use App\Models\Players\PlayerLocal;
use App\Models\Teams\TeamVisitor;
use App\Models\Teams\TeamLocal;
use App\Http\Requests\EventController\EventCreateRequest;
use App\Http\Requests\EventController\EventUpdateRequest;

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
                $event->league()->attach($request->post('leagueId'));

                if($request->post('isIndividual')) {
                    $this->createIndividualEvent($request, $event->id);
                    return back()->with('statusCreate', 'Event registered successfully.');
                }
                
                $this->createTeamEvent($request, $event->id);
                return back()->with('statusCreate', 'Event registered successfully.');
            });
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
                if($event->isIndividual());
            });
        } catch (QueryException $e) {
            return back()->with('statusUpdate', 'Unable to update event right now.');
        }
    }

    public function show()
    {
        return view('eventManagement')->with('events', Event::all());
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
