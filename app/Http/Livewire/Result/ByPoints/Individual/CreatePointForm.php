<?php

namespace App\Http\Livewire\Result\ByPoints\Individual;

use App\Models\Players\PlayerTeam;
use Livewire\Component;

class CreatePointForm extends Component
{
    public $result;
    public $teams;
    public $players;
    public $team;
    public $player;
    public $minute;
    public $points;
    public $isInFavor;

    public function mount()
    {
        $this->teams = $this->result->event->opponents();
        $this->team = old('team');
        $this->players = $this->fetchPlayers($this->team);
        $this->minute = old('minute');
        $this->points = old('points');
        $this->player = old('player');
        $this->isInFavor = old('isInFavor');
    }

    public function render()
    {
        return view('livewire.result.by-points.individual.create-point-form');
    }

    public function updatedTeam()
    {
        $this->players = PlayerTeam::where('team_id', $this->team)
            ->latest('contract_start')
            ->get()
            ->map(function ($item) {
                return $item->player;
            });
    }

    public function fetchPlayers($team)
    {
        return PlayerTeam::where('team_id', $team)
            ->latest('contract_start')
            ->get()
            ->map(function ($item) {
                return $item->player;
            });
    }
}
