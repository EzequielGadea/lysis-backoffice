<?php

namespace App\Services;

use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByMarkPlayerVisitor;

class ByMarkService
{    
    private $updateMethods;

    public function __construct()
    {
        $this->updateMethods = [
            'visitor' => 'ByMarkPlayerVisitor::update()',
            'local' => 'ByMarkPlayerLocal::update()',
            'teams' => 'ByMarkEventPlayerTeam::update()'
        ];
    }

    public function create($request, $event)
    {
        if ($event->isIndividual()) {
            if ($event->isPlayerLocal($request->post('playerId')))
                return $this->createPlayerLocalMark($event->result(), $event->playerLocal, $request->post('markValue'));
            if ($event->isPlayerVisitor($request->post('playerId')))
                return $this->createPlayerVisitorMark($event->result(), $event->playerVisitor, $request->post('markValue'));
        }

        $playerTeam = $this->getPlayerTeam($request->post('playerId'), $request->post('teamId'));
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);
        return $this->createTeamMark($eventPlayerTeam, $event->result(), $request->post('markValue'));
    }

    private function createPlayerVisitorMark($result, $playerVisitor, $markValue)
    {
        return ByMarkPlayerVisitor::create([
            'by_mark_id' => $result->id,
            'event_id' => $playerVisitor->event_id,
            'mark_value' => $markValue
        ]);
    }

    private function createPlayerLocalMark($result, $playerLocal, $markValue)
    {
        return ByMarkPlayerLocal::create([
            'by_mark_id' => $result->id,
            'event_id' => $playerLocal->event_id,
            'mark_value' => $markValue
        ]);
    }

    private function createTeamMark($eventPlayerTeam, $result, $markValue)
    {
        return ByMarkEventPlayerTeam::create([
            'event_player_team_id' => $eventPlayerTeam->id,
            'by_mark_id' => $result->id,
            'mark_value' => $markValue
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
}
