<?php

namespace App\Services;

use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\EventPlayerTeamSet;
use App\Models\Results\PlayerLocalSet;
use App\Models\Results\PlayerVisitorSet;

class BySetService
{
    public function create($request, $event)
    {
        if ($event->isIndividual()) {
            if ($event->isPlayerLocal($request->post('playerId')))
                return $this->createPlayerLocalBySet($event->result, $request);
            if($event->isPlayerVisitor($request->post('playerId')))
                return $this->createPlayerVisitorBySet($event->result, $request);
        }

        $playerTeam = $this->getPlayerTeam($request->post('playerId'), $request->post('teamId'));
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);
        return $this->createTeamBySets($event->result, $eventPlayerTeam, $request);
    }

    private function createPlayerLocalBySet($result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        return PlayerLocalSet::create([
            'set_id' => $result->sets->firstWhere('number', $request->post('set'))->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function createPlayerVisitorBySet($result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        return PlayerVisitorSet::create([
            'set_id' => $result->sets->firstWhere('number', $request->post('set'))->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points')
        ]);
    }

    private function createTeamBySets($eventPlayerTeam, $result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        return EventPlayerTeamSet::create([
            'set_id' => $result->sets->firstWhere('number', $request->post('set')->id),
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points')
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
