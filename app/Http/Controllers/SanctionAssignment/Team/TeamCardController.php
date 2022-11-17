<?php

namespace App\Http\Controllers\SanctionAssignment\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Team\CardSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Team\CardSanctionUpdateRequest;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Events\EventPlayerTeamSanctionCard;
use App\Models\Events\EventPlayerTeamSanctionCardSet;
use App\Models\Players\PlayerTeam;
use App\Models\Sanctions\SanctionCard;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamCardController extends Controller
{
    public function create(CardSanctionCreateRequest $request, Event $event)
    {
        try {
            DB::transaction(function () use ($request, $event) {
                $playerTeam = $this->getPlayerTeam($request);
                $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);
                
                $sanction = EventPlayerTeamSanctionCard::create([
                    'sanction_card_id' => $request->post('sanction'),
                    'event_player_team_id' => $eventPlayerTeam->id,
                    'minute' => $request->post('minute'),
                ]);
                if ($event->isBySet()) $this->createInSet($sanction, $request);
            });
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Unable to create sanction.');
        }

        return back()->with('statusCreate', 'Sanction created successfully.');
    }

    public function index(Event $event)
    {
        return view('sanctions.cards.team.index', [
            'event' => $event,
            'sanctions' => SanctionCard::all(),
        ]);
    }

    public function edit(EventPlayerTeamSanctionCard $sanction)
    {
        return view('sanctions.cards.team.edit', [
            'sanction' => $sanction,
            'sanctions' => SanctionCard::all(),
        ]);
    }

    public function update(CardSanctionUpdateRequest $request, EventPlayerTeamSanctionCard $sanction)
    {
        $sanction->update([
            'sanction_card_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
        if ($sanction->eventPlayerTeam->event->isBySet()) {
            $sanction->inSet->update([
                'set_id' => $request->post('set'),
            ]);
        }

        return back()->with([
            'statusUpdate' => 'Sanction udpated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function delete(EventPlayerTeamSanctionCard $sanction)
    {
        if ($sanction->eventPlayerTeam->event->isBySet()) $sanction->inSet->delete();
        $sanction->delete();
        return back()->with([
            'statusDelete' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
        ]);
    }

    public function restore(EventPlayerTeamSanctionCard $sanction)
    {
        if ($sanction->eventPlayerTeam->event->isBySet()) $sanction->inSet()->withTrashed()->restore();
        $sanction->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    private function createInSet($sanction, $request)
    {
        return EventPlayerTeamSanctionCardSet::create([
            'event_player_team_sanction_card_id' => $sanction->id,
            'set_id' => $request->post('set'),
        ]);
    }

    private function getPlayerTeam($request)
    {
        return PlayerTeam::where([
            ['player_id', $request->post('player')],
            ['team_id', $request->post('team')],
        ])
            ->latest('contract_start')
            ->first();
    }

    private function getEventPlayerTeam($playerTeam, $event)
    {
        return EventPlayerTeam::firstOrCreate([
            'player_team_id' => $playerTeam->id,
            'event_id' => $event->id,
        ]);
    }
}
