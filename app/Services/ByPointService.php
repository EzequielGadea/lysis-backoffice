<?php

namespace App\Services;

use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\ByPointEventPlayerTeam;
use App\Models\Results\ByPointPlayerLocal;
use App\Models\Results\ByPointPlayerVisitor;

class ByPointService
{
    public function create($request, $event)
    {
        if ($event->isIndividual()) {
            if ($event->isPlayerLocal($request->post('playerId')))
                return $this->createPlayerLocalByPoint($event->result, $request);
            if ($event->isPlayerVisitor($request->post('playerId')))
                return $this->createPlayerVisitorByPoint($event->result, $request);
        }

        $playerTeam = $this->getPlayerTeam($request->post('playerId'), $request->post('teamId'));
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);
        return $this->createTeamByPoint($event->result, $eventPlayerTeam, $request);
    }

    private function createPlayerLocalByPoint($result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        ByPointPlayerLocal::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function createPlayerVisitorByPoint($result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        ByPointPlayerVisitor::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function createTeamByPoint($result, $player, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        return ByPointEventPlayerTeam::create([
            'by_point_id' => $result->id,
            'event_player_team_id' => $player->id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function getEventPlayerTeam($playerTeam, $event)
    {
        $eventPlayerTeam = EventPlayerTeam::where('player_id', $playerTeam->player_id)
            ->latest('contract_start');
        if ($eventPlayerTeam == null)
            EventPlayerTeam::create([
                'team_id' => $playerTeam->team_id,
                'contract_start' => $playerTeam->contract_start,
                'event_id' => $event->id,
            ]);
        return $eventPlayerTeam;
    }

    private function getPlayerTeam($playerId, $teamId)
    {
        return PlayerTeam::where([
            'player_id' => $playerId,
            'team_id' => $teamId
        ]);
    }
    
    private function getPointOwner($isInFavor)
    {
        if ($isInFavor) return 'points_in_favor';
        if (! $isInFavor) return 'points_against';
    }
}
