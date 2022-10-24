<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EventUpdateTeams extends Component
{
    public $event;

    public $chosenLocal;

    public $chosenVisitor;

    public function rensder()
    {
        return view('livewire.event-update-individual', [
            'visitors' => Player::all()->except([
                $this->event->teamVisitor->player->id,
                $this->event->teamLocal->player->id,
                $this->chosenLocal
            ]),
            'locals' => Player::all()->except([
                $this->event->playerLocal->player->id,
                $this->event->playerVisitor->player->id,
                $this->chosenVisitor
            ]),
            'visitor' => $this->event->playerVisitor->player,
            'local' => $this->event->playerLocal->player
        ]);
    }

    public function render()
    {
        return view('livewire.event-update-teams');
    }
}
