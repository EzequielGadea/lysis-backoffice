<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMark\CreateTeamMarkRequest;
use App\Http\Requests\TeamMark\UpdateTeamMarkRequest;
use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\ByMark;
use App\Models\Results\ByMarkEventPlayerTeam;

class TeamMarkController extends Controller
{
    public function create(CreateTeamMarkRequest $request, ByMark $result)
    {
        $playerTeam = PlayerTeam::where([
            ['player_id', $request->post('player')],
            ['team_id', $request->post('team')]
        ])->latest('contract_start')->first();
        $eventPlayerTeam = $this->getEventPlayerTeam($playerTeam, $result->event);
        ByMarkEventPlayerTeam::create([
            'event_player_team_id' => $eventPlayerTeam->id,
            'by_mark_id' => $result->id,
            'mark_value' => $request->post('markValue')
        ]);
        return back()->with('statusCreate', 'Mark created successfully.');
    }

    public function update(ByMarkEventPlayerTeam $mark, UpdateTeamMarkRequest $request)
    {
        $mark->update($request->validated());
        return back()->with([
            'statusUpdate' => 'Mark updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function index(Event $event)
    {
        return view('results.byMark.team.management', [
            'event' => $event,
        ]);
    }

    public function edit(ByMarkEventPlayerTeam $mark)
    {
        return view('results.byMark.team.update', [
            'mark' => $mark
        ]);
    }

    public function delete(ByMarkEventPlayerTeam $mark)
    {
        $mark->delete();
        return back()->with([
            'statusDelete' => 'Mark deleted successfully.',
            'deletedId' => $mark->id
        ]);
    }

    public function restore(ByMarkEventPlayerTeam $mark)
    {
        $mark->restore();
        return back()->with('statusRestore', 'Mark restored successfully.');
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
