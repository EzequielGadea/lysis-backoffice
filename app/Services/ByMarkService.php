<?php

namespace App\Services;

use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByMarkPlayerVisitor;

class ByMarkService
{
    // private $request;

    // private $event;

    // public function __construct($request, $event)
    // {
    //     $this->request = $request;
    //     $this->event = $event;
    // }
    
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

    public function edit($event)
    {
        return view('result-update', [
            'event' => $event
        ]);
    }

    public function update($playerMark, $request)
    {
        if ($this->event->isIndividual()) {
            if ($this->event->isPlayerLocal($this->request->post('playerId')))
                return $this->updatePlayerLocalMark($playerMark, $request);
            if ($this->event->isPlayerVisitor($this->request->post('playerId')))
                return $this->updatePlayerVisitorMark($playerMark, $request);
        }
        return $this->updateTeamByMark($playerMark, $request);
    }

    public function delete($point)
    {
        return $point->delete();
    }

    public function restore($request)
    {
        if ($this->event->isIndividual()) {
            if ($this->event->isPlayerLocal($this->request->post('playerId')))
                return $this->restorePlayerLocalMark($request->post('deletedId'));
            if ($this->event->isPlayerVisitor($this->request->post('playerId')))
                return $this->restorePlayerVisitorMark($request->post('deletedId'));
        }
        return $this->restoreTeamByMark($request->post('deletedId'));
    }

    private function restorePlayerVisitorMark($id)
    {
        return ByMarkPlayerVisitor::withTrashed()
            ->findOrFail($id)
            ->restore();
    }

    private function restorePlayerLocalMark($id)
    {
        return ByMarkPlayerLocal::withTrashed()
            ->findOrFail($id)
            ->restore();
    }

    private function restoreTeamByMark($id)
    {
        return ByMarkEventPlayerTeam::withTrashed()
            ->findOrFail($id)
            ->restore();
    }

    private function updatePlayerLocalMark($playerLocalMark, $request)
    {
        return $playerLocalMark->update([
            'mark_value' => $request->post('markValue')
        ]);
    }

    private function updatePlayerVisitorMark($playerVisitorMark, $request)
    {
        return $playerVisitorMark->update([
            'mark_value' => $request->post('markValue')
        ]);
    }

    private function updateTeamByMark($eventPlayerMark, $request)
    {
        return $eventPlayerMark->update([
            'mark_value' => $request->post('markValue')
        ]);
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
