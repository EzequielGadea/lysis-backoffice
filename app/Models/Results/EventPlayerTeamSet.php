<?php

namespace App\Models\Results;

use App\Models\Events\Event;
use App\Models\Events\EventPlayerTeam;
use App\Models\Players\PlayerTeam;
use App\Models\Results\Set;
use App\Models\Results\BySet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPlayerTeamSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team_set';

    protected $fillable = [
        'points_in_favor',
        'points_against',
        'minute'
    ];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function eventPlayerTeam()
    {
        return $this->belongsTo(EventPlayerTeam::class);
    }

    public function result()
    {
        return $this->hasOneThrough(BySet::class, Set::class);
    }

    public function playerTeam()
    {
        return $this->hasOneThrough(PlayerTeam::class, EventPlayerTeam::class); 
    }

    public function event()
    {
        return $this->hasOneThrough(Event::class, EventPlayerTeam::class);
    }
}
