<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Country;
use App\Models\Teams\Team;
use App\Models\Players\PlayerTeam;
use App\Models\Players\PlayerVisitor;
use App\Models\Players\PlayerLocal;
use App\Models\Events\EventPlayerTeam;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'height',
        'weight'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function playerTeams()
    {
        return $this->hasMany(PlayerTeam::class);
    }

    public function teams()
    {
        return $this->hasManyThrough(Team::class, PlayerTeam::class);
    }
    
    public function playerVisitor()
    {
        return $this->hasMany(PlayerVisitor::class);
    }

    public function playerLocal()
    {
        return $this->hasMany(PlayerLocal::class);
    }

    public function events()
    {
        return $this->hasManyThrough(EventPlayerTeam::class, PlayerTeam::class);
    }
}
