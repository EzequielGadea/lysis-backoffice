<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Players\PlayerVisitor;
use App\Models\Players\Player;
use App\Models\Results\ByMark;
use App\Models\Events\Event;

class ByMarkPlayerVisitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_mark_player_visitor';

    protected $fillable = [
        'mark_value'
    ];

    public function playerVisitor()
    {
        return $this->belongsTo(PlayerVisitor::class, 'event_id', 'event_id');
    }

    public function result()
    {
        return $this->belongsTo(ByMark::class);
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
