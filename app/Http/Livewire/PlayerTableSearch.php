<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Players\Player;

class PlayerTableSearch extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.player-table-search', [
            'players' => Player::where('name','like', "$search%" ?? '')
        ]);
    }
}
