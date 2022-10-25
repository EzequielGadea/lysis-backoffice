<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teams\Team;

class EventUpdateTeams extends Component
{
    public $event;

    public $chosenLocal;

    public $chosenVisitor;

    public function render()
    {
        return view('livewire.event-update-teams', [
            'visitors' => Team::all()->except([
                $this->event->teamVisitor->team->id,
                $this->event->teamLocal->team->id,
                $this->chosenLocal
            ]),
            'locals' => Team::all()->except([
                $this->event->teamLocal->team->id,
                $this->event->teamVisitor->team->id,
                $this->chosenVisitor
            ]),
            'visitor' => $this->event->teamVisitor->team,
            'local' => $this->event->teamLocal->team
        ]);
    }
}
