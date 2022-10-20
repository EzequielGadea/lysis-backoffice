<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Players\Player;
use Illuminate\Support\Facades\DB;

class PlayerTableSearch extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.player-table-search', [
            'players' => Player::where(DB::raw("CONCAT(players.name, ' ', players.surname )"),'like', "%$this->search%")->get()
        ]);
    }
}
