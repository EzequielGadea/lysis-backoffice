<?php

namespace App\Http\Controllers;

use App\Http\Requests\Result\BySet\Team\CreatePointRequest;
use App\Http\Requests\Result\BySet\Team\UpdatePointRequest;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\BySet;
use App\Models\Results\EventPlayerTeamSet;

class TeamSetController extends Controller
{
    public function create(BySet $result, CreatePointRequest $request)
    {
        $playerTeam = PlayerTeam::where([
            ['player_id', $request->post('player')],
            ['team_id', $request->post('team')]
        ])->latest('contract_start')->first();
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $result->event);
        $this->createPoint($request, $eventPlayerTeam);
        return back()->with('statusCreate', 'Point created successfully.');
    }

    public function update(EventPlayerTeamSet $point, UpdatePointRequest $request)
    {
        if ($point->points_in_favor !== 0) $pointOwner = 'points_in_favor';
        if ($point->points_against !== 0) $pointOwner = 'points_against';
        $point->update([
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points')
        ]);
        return back()->with([
            'statusUpdate' => 'Point updated successfully.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit(EventPlayerTeamSet $point)
    {
        return view('results.bySet.team.edit', [
            'point' => $point
        ]);
    }

    public function index(Event $event)
    {
        return view('results.bySet.team.management', [
            'event' => $event,
        ]);
    }

    public function delete(EventPlayerTeamSet $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'deletedId' => $point->id
        ]);
    }

    public function restore(EventPlayerTeamSet $point)
    {
        $point->restore();
        return back()->with('statusRestore', 'Point restored successfully.');
    }

    private function createPoint($request, $eventPlayerTeam)
    {
        $pointOwner = $request->post('isInFavor') ? 'points_in_favor' : 'points_against';
        return EventPlayerTeamSet::create([
            'set_id' => $request->post('set'),
            'event_player_team_id' => $eventPlayerTeam->id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function getEventPlayerTeam($playerTeam, $event)
    {
        $eventPlayerTeam = EventPlayerTeam::firstWhere([
            ['player_team_id', $playerTeam->id],
            ['event_id', $event->id]
        ]);
        if ($eventPlayerTeam == null)
            $eventPlayerTeam = EventPlayerTeam::create([
                'event_id' => $event->id,
                'player_team_id' => $playerTeam->id
            ]);
        return $eventPlayerTeam;
    }
}
