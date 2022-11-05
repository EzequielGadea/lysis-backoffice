<?php

namespace App\Http\Controllers;

use App\Http\Requests\Results\ByPoints\Team\CreatePointRequest;
use App\Http\Requests\Results\ByPoints\Team\UpdatePointRequest;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\ByPoint;
use App\Models\Results\ByPointEventPlayerTeam;
use Illuminate\Database\QueryException;

class TeamPointController extends Controller
{
    public function create(ByPoint $result, CreatePointRequest $request)
    {
        $eventPlayerTeam = $this->getEventPlayerTeam($request->post('player'), $request->post('team'), $result->event->id);
        $this->createPoint($eventPlayerTeam, $request, $result);
        return back()->with('statusCreate', 'Point created successfully.');
    }

    public function index(Event $event)
    {
        return view('results.by-points.management', [
            'event' => $event
        ]);
    }

    public function edit(ByPointEventPlayerTeam $point)
    {
        return view('results.by-points.edit', [
            'point' => $point
        ]);
    }

    public function update(ByPointEventPlayerTeam $point, UpdatePointRequest $request)
    {
        try {
            $point->update([
                'minute' => $request->post('minute'),
                $this->checkPointOwner($point) => $request->post('points'),
            ]);
        } catch (QueryException $e) {
            return back()->with('statusUpdate', 'Error. Check if the player has already scored at that minute.');
        }
        return back()->with([
            'statusUpdate' => 'Point updated successfully, you will soon be redirected.',
            'isRedirected' => 'true',
        ]);
    }

    public function delete(ByPointEventPlayerTeam $point)
    {
        $point->delete();
        return back()->with([
            'statusDelete' => 'Point deleted successfully.',
            'deletedId' => $point->id
        ]);
    }

    public function restore(ByPointEventPlayerTeam $point)
    {
        $point->restore();
        return back()->with('statusRestore', 'Point restored successfully.');
    }

    private function checkPointOwner($point)
    {
        if ($point->points_in_favor !== 0) return 'points_in_favor';
        if ($point->points_against !== 0) return 'points_against';
    }

    private function createPoint($eventPlayerTeam, $request, $result)
    {
        return ByPointEventPlayerTeam::create([
            'by_point_id' => $result->id,
            'event_player_team_id' => $eventPlayerTeam->id,
            'minute' => $request->post('minute'),
            $this->getPointOwner($request->post('isInFavor')) => $request->post('points'),
        ]);
    }

    private function getPointOwner($isInFavor)
    {
        return $isInFavor ? 'points_in_favor' : 'points_against';
    }

    private function getEventPlayerTeam($playerId, $teamId, $eventId)
    {
        $playerTeam = $this->getPlayerTeam($playerId, $teamId);

        $eventPlayerTeam = EventPlayerTeam::where([
            ['player_team_id', $playerTeam->id],
            ['event_id', $eventId],
        ]);
        if ($eventPlayerTeam == null)
            $eventPlayerTeam = EventPlayerTeam::create([
                'event_id' => $eventId,
                'player_team_id' => $playerTeam->id,
            ]);

        return $eventPlayerTeam;
    }

    private function getPlayerTeam($playerId, $teamId)
    {
        return PlayerTeam::where([
            ['player_id', $playerId],
            ['team_id', $teamId],
        ]);
    }
}
