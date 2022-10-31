<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Players\Player;
use App\Models\Players\PlayerLocal;
use App\Models\Players\PlayerTeam;
use App\Models\Players\PlayerVisitor;
use App\Models\Results\ByMark;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByMarkPlayerVisitor;
use App\Models\Results\ByPoint;
use App\Models\Results\ByPointEventPlayerTeam;
use App\Models\Results\ByPointPlayerLocal;
use App\Models\Results\ByPointPlayerVisitor;
use App\Models\Results\BySet;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function create(ResultRequest $request, Event $event)
    {
        
    }

    private function createBySets(Event $event, $request)
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

    private function createPlayerLocalBySet(BySet $result, $request)
    {
        
    }

    private function createByPoints($request, Event $event)
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

    private function createPlayerLocalByPoint(ByPoint $result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        ByPointPlayerLocal::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function createPlayerVisitorByPoint(ByPoint $result, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        ByPointPlayerVisitor::create([
            'by_point_id' => $result->id,
            'event_id' => $result->event_id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function createTeamByPoint(ByPoint $result, EventPlayerTeam $player, $request)
    {
        $pointOwner = $this->getPointOwner($request->post('isInFavor'));
        return ByPointEventPlayerTeam::create([
            'by_point_id' => $result->id,
            'event_player_team_id' => $player->id,
            'minute' => $request->post('minute'),
            $pointOwner => $request->post('points'),
        ]);
    }

    private function getPointOwner(bool $isInFavor)
    {
        if ($isInFavor) return 'points_in_favor';
        if (! $isInFavor) return 'points_against';
    }

    private function createByMark(Event $event, $request)
    {
        if ($event->isIndividual()) {
            if ($event->isPlayerLocal($request->post('playerId')))
                return $this->createPlayerLocalByMark($event->result, $event->playerLocal, $request->post('markValue'));
            if ($event->isPlayerVisitor($request->post('playerId')))
                return $this->createPlayerVisitorByMark($event->result, $event->playerVisitor, $request->post('markValue'));
        }

        $playerTeam = $this->getPlayerTeam($request->post('playerId'), $request->post('teamId'));
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);
        return $this->createTeamByMark($eventPlayerTeam, $event->result, $request->post('markValue'));
    }

    private function createPlayerVisitorByMark(ByMark $result, PlayerVisitor $playerVisitor, $markValue)
    {
        return ByMarkPlayerVisitor::create([
            'by_mark_id' => $result->id,
            'event_id' => $playerVisitor->event_id,
            'mark_value' => $markValue
        ]);
    }

    private function createPlayerLocalByMark(ByMark $result, PlayerLocal $playerLocal, $markValue)
    {
        return ByMarkPlayerLocal::create([
            'by_mark_id' => $result->id,
            'event_id' => $playerLocal->event_id,
            'mark_value' => $markValue
        ]);
    }

    private function createTeamByMark(EventPlayerTeam $eventPlayerTeam, ByMark $result, $markValue)
    {
        return ByMarkEventPlayerTeam::create([
            'event_player_team_id' => $eventPlayerTeam->id,
            'by_mark_id' => $result->id,
            'mark_value' => $markValue
        ]);
    }

    private function getEventPlayerTeam(PlayerTeam $playerTeam, Event $event)
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
