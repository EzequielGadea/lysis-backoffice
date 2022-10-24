<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Events\Event;
use App\Models\Players\Player;

class EventUpdateIndividual extends Component
{
    public $event;

    public $chosenLocal;

    public $chosenVisitor;

    public function render()
    {
        return view('livewire.event-update-individual', [
            'visitors' => Player::all()->except([
                $this->event->playerVisitor->player->id,
                $this->event->playerLocal->player->id,
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
}
