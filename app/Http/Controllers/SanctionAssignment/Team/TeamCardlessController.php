<?php

namespace App\Http\Controllers\SanctionAssignment\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctions\Assignment\Team\CardlessSanctionCreateRequest;
use App\Http\Requests\Sanctions\Assignment\Team\CardlessSanctionUpdateRequest;
use App\Models\Players\PlayerTeam;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Events\EventPlayerTeamSanctionCardless;
use App\Models\Events\EventPlayerTeamSanctionCardlessSet;
use App\Models\Sanctions\SanctionCardless;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamCardlessController extends Controller
{
    public function create(CardlessSanctionCreateRequest $request, Event $event)
    {
        try {
            DB::transaction(function () use ($request, $event) {
                $playerTeam = $this->getPlayerTeam($request);
                $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $event);

                $sanction = EventPlayerTeamSanctionCardless::create([
                    'sanction_cardless_id' => $request->post('sanction'),
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
        return view('sanctions.cardless.team.index', [
            'event' => $event,
            'sanctions' => SanctionCardless::all(),
        ]);
    }

    public function edit(EventPlayerTeamSanctionCardless $sanction)
    {
        return view('sanctions.cardless.team.edit', [
            'sanction' => $sanction,
            'sanctions' => SanctionCardless::all(),
        ]);
    }

    public function update(CardlessSanctionUpdateRequest $request, EventPlayerTeamSanctionCardless $sanction)
    {
        $sanction->update([
            'sanction_cardless_id' => $request->post('sanction'),
            'minute' => $request->post('minute'),
        ]);
        if ($sanction->eventPlayerTeam->event->isBySet()) {
            $sanction->inSet->update([
                'set_id' => $request->post('set'),
            ]);
        }

        return back()->with([
            'statusUpdate' => 'Sanction updated successfully.',
            'isRedirected' => 'true',
        ]);
    }

    public function delete(EventPlayerTeamSanctionCardless $sanction)
    {
        if ($sanction->eventPlayerTeam->event->isBySet()) $sanction->inSet->delete();
        $sanction->delete();
        return back()->with([
            'statusDelete' => 'Sanction deleted successfully.',
            'deletedId' => $sanction->id,
        ]);
    }

    public function restore(EventPlayerTeamSanctionCardless $sanction)
    {
        if ($sanction->eventPlayerTeam->event->isBySet()) $sanction->inSet()->withTrashed()->restore();
        $sanction->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    private function createInSet($sanction, $request)
    {
        return EventPlayerTeamSanctionCardlessSet::create([
            'event_player_team_sanction_cardless_id' => $sanction->id,
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
