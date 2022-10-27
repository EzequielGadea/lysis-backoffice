<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Country;
use App\Models\Common\League;
use App\Models\Teams\Manager;
use App\Models\Players\PlayerTeam;
use App\Models\Players\Player;
use App\Models\Events\EventPlayerTeam;
use App\Models\Common\Image;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link',
        'country_id',
        'league_id',
        'manager_id',
        'image_id'
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
        return $this->belongsTo(Manager::class);
    }

    public function playerTeams()
    {
        return $this->hasMany(PlayerTeam::class);
    }

    public function players()
    {
        return $this->hasManyThrough(Player::class, PlayerTeam::class, 'id', 'id', 'id', 'player_id');
    }

    public function events()
    {
        return $this->hasManyThrough(EventPlayerTeam::class, PlayerTeam::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
