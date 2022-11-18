<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use App\Models\Players\PlayerTeam;
use Livewire\Component;

class SelectTeamPlayer extends Component
{
    public $eventId;
    public $teams;
    public $players;
    public $team;

    public function mount()
    {
        $this->teams = Event::find($this->eventId)->opponents();
        $this->players = collect();
    }

    public function render()
    {
        return view('livewire.select-team-player');
    }

    public function updatedTeam($value)
    {
        $this->players = PlayerTeam::where('team_id', $value)
            ->latest('contract_start')
            ->get()
            ->map(function ($item) {
                return $item->player;
            });
        $this->teams = Event::find($this->eventId)->opponents();
    }
}
