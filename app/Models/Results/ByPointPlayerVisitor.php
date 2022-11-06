<?php

namespace App\Models\Results;

use App\Models\Events\Event;
use App\Models\Players\Player;
use App\Models\Players\PlayerVisitor;
use App\Models\Results\ByPoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ByPointPlayerVisitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_point_player_visitor';

    protected $fillable = [
        'by_point_id',
        'event_id',
        'points_in_favor',
        'points_against',
        'minute',
    ];

    protected $attributes = [
        'points_in_favor' => 0,
        'points_against' => 0,
    ];

    public function playerVisitor()
    {
        return $this->belongsTo(PlayerVisitor::class, 'event_id', 'event_id');
    }

    public function result()
    {
        return $this->belongsTo(ByPoint::class, 'by_point_id', 'id');
    }

    public function player()
    {
        return $this->hasOneThrough(Player::class, PlayerVisitor::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }
}
