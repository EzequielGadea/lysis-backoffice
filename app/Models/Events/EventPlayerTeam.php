<?php

namespace App\Models\Events;

use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeamSanctionCard;
use App\Models\Events\EventPlayerTeamSanctionCardless;
use App\Models\Players\Player;
use App\Models\Players\PlayerTeam;
use App\Models\Players\Position;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByPointEventPlayerTeam;
use App\Models\Results\EventPlayerTeamSet;
use App\Models\Teams\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventPlayerTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team';

    protected $fillable = [
        'contract_start'
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function playerTeam()
    {
        return $this->belongsTo(PlayerTeam::class);
    }

    public function player()
    {
        return $this->hasOneThrough(Player::class, PlayerTeam::class);
    }

    public function team()
    {
        return $this->hasOneThrough(Team::class, PlayerTeam::class);
    }

    public function marks()
    {
        return $this->hasMany(ByMarkEventPlayerTeam::class);
    }

    public function points()
    {
        return $this->hasMany(ByPointEventPlayerTeam::class);
    }

    public function pointsInSets()
    {
        return $this->hasMany(EventPlayerTeamSet::class);
    }

    public function position()
    {
        return $this->hasOneThrough(Position::class, PlayerTeam::class);
    }

    public function cardlessSanctions()
    {
        return $this->hasMany(EventPlayerTeamSanctionCardless::class);
    }

    public function cardSanctions()
    {
        return $this->hasMany(EventPlayerTeamSanctionCard::class);
    }
}
