<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ByPointPlayerVisitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_point_player_visitor';

    protected $fillable = [
        'points_in_favor',
        'points_against',
        'minute'
    ];

    public function playerVisitor()
    {
        return $this->belongsTo(PlayerVisitor::class, 'event_id', 'event_id');
    }

    public function result()
    {
        return $this->belongsTo(ByPoint::class);
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