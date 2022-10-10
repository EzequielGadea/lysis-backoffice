<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Players\Player;
use App\Models\Teams\Team;
use App\Models\Players\Position;

class PlayerTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_team';

    protected $fillable = [
        'contract_start',
        'shirt_number'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
