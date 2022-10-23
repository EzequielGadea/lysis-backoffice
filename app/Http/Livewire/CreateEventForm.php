<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Players\Player;
use App\Models\Teams\Team;

class CreateEventForm extends Component
{
    public $isIndividual;

    public $chosenLocalPlayer;

    public $chosenVisitorPlayer;

    public $chosenLocalTeam;

    public $chosenVisitorTeam;

    public function render()
    {
        if($this->isIndividual)    
            return view('livewire.create-event-form', [
                'localPlayers' => Player::all()->except($this->chosenVisitorPlayer),
                'visitorPlayers' => Player::all()->except($this->chosenLocalPlayer)
            ]);

        return view('livewire.create-event-form', [
            'localTeams' => Team::all()->except($this->chosenVisitorTeam),
            'visitorTeams' => Team::all()->except($this->chosenLocalTeam)
        ]);
    }
}
