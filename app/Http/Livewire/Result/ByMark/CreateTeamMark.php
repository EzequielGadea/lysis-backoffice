<?php

namespace App\Http\Livewire\Result\ByMark;

use App\Models\Players\PlayerTeam;
use App\Models\Results\ByMark;
use App\Models\Teams\Team;
use Livewire\Component;

class CreateTeamMark extends Component
{
    public $result;
    public $markName;

    public $teams;
    public $players;

    public $team;

    public function mount()
    {
        $this->teams = ByMark::find($this->result)->event->opponents();
        $this->players = collect();
    }

    public function render()
    {
        return view('livewire.result.by-mark.create-team-mark');
    }

    public function updatedTeam()
    {
        $this->players = PlayerTeam::where('team_id', $this->team)
            ->latest('contract_start')
            ->get()
            ->map(function ($item) {
                return $item->player;
            });
        $this->teams = ByMark::find($this->result)->event->opponents();
    }
}
