<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\EventPlayerTeam;
use App\Models\Events\Event;
use App\Models\Results\ByPoint;
use App\Models\Players\PlayerTeam;

class ByPointEventPlayerTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_point_event_player_team';

    protected $fillable = [
        'by_point_id',
        'event_player_team_id',
        'points_in_favor',
        'points_against',
        'minute'
    ];

    protected $attributes = [
        'points_in_favor' => 0,
        'points_against' => 0,
    ];

    public function eventPlayerTeam()
    {
        return $this->belongsTo(EventPlayerTeam::class);
    }

    public function result()
    {
        return $this->belongsTo(ByPoint::class);
    }

    public function playerTeam()
    {
        return $this->hasOneThrough(PlayerTeam::class, EventPlayerTeam::class);
    }
}
