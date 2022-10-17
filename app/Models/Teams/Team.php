<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Whereabouts\Country;
use App\Model\Common\League;
use App\Model\Teams\Manager;
use App\Model\Players\PlayerTeam;
use App\Model\Players\Player;
use App\Model\Events\EventPlayerTeam;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link',
        'country_id',
        'league_id',
        'manager_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function manager()
    {
        return $this->belongsTo(Mananger::class);
    }

    public function playerTeams()
    {
        return $this->hasMany(PlayerTeam::class);
    }

    public function players()
    {
        return $this->hasManyThrough(Player::class, PlayerTeam::class);
    }

    public function events()
    {
        return $this->hasManyThrough(EventPlayerTeam::class, PlayerTeam::class);
    }
}
