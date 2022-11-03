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
        'by_mark_id',
        'event_id',
        'mark_value'
    ];

    public function playerVisitor()
    {
        return $this->belongsTo(PlayerVisitor::class, 'event_id', 'event_id');
    }

    public function result()
    {
        return $this->belongsTo(ByMark::class, 'by_mark_id', 'id');
    }

    public function player()
    {
        return $this->hasOneThrough(Player::class, PlayerVisitor::class, 'player_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
