<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Venue;
use App\Models\Whereabouts\City;
use App\Models\Events\Referee;
use App\Models\Events\EventPlayerTeam;
use App\Models\Results\ByPoint;
use App\Models\Results\ByMark;
use App\Models\Results\BySet;
use App\Models\Players\PlayerVisitor;
use App\Models\Players\PlayerLocal;
use App\Models\Common\League;
use App\Models\Teams\TeamVisitor;
use App\Models\Teams\TeamLocal;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_date',
        'venue_id',
        'league_id'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function city(){
        return $this->hasOneThrough(City::class, Venue::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function referees()
    {
        return $this->belongsToMany(Referee::class)->withTimestamps();
    }

    public function teamPlayers()
    {
        return $this->hasMany(EventPlayerTeam::class);
    }

    public function resultByPoint()
    {
        return $this->hasOne(ByPoint::class);
    }

    public function resultByMark()
    {
        return $this->hasOne(ByMark::class);
    }

    public function resultBySet()
    {
        return $this->hasOne(BySet::class);
    }

    public function result()
    {
        if ($this->resultByPoint !== null)
            return $this->resultByPoint;
        if ($this->resultByMark !== null)
            return $this->resultByMark;
        if ($this->resultBySet !== null)
            return $this->resultBySet;
        return null;
    }

    public function playerVisitor()
    {
        return $this->hasOne(PlayerVisitor::class);
    }

    public function playerLocal()
    {
        return $this->hasOne(PlayerLocal::class);
    }

    public function teamVisitor()
    {
        return $this->hasOne(TeamVisitor::class);
    }

    public function teamLocal()
    {
        return $this->hasOne(TeamLocal::class);
    }

    public function isIndividual()
    {
        if($this->playerVisitor !== null && $this->playerLocal !== null)
            return true;
        return false;
    }

    public function opponents()
    {
        if ($this->isIndividual()) {
            return collect([$this->playerLocal->player,$this->playerVisitor->player]);
        }
        return collect([$this->teamLocal->team, $this->teamVisitor->team]);
    }
}
