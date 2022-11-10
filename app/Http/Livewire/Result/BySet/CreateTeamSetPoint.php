<?php

namespace App\Http\Livewire\Result\BySet;

use App\Models\Players\PlayerTeam;
use App\Models\Results\BySet;
use App\Models\Teams\Team;
use Livewire\Component;

class CreateTeamSetPoint extends Component
{
    public $result;
    public $teams;
    public $players;
    public $team;

    public function mount()
    {
        $this->teams = BySet::find($this->result->id)->event->opponents();
        $this->players = collect();
    }

    public function render()
    {
        return view('livewire.result.by-set.create-team-set-point');
    }

    public function updatedTeam()
    {
        $this->players = PlayerTeam::where('team_id', $this->team)
            ->latest('contract_start')
            ->get()
            ->map(function ($item) {
                return $item->player;
            });
        $this->teams = BySet::find($this->result->id)->event->opponents();
    }
}
