<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\ByMark;
use App\Models\Events\Event;
use App\Models\Players\Player;
use App\Models\Players\PlayerLocal;

class ByMarkPlayerLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_mark_player_local';

    protected $fillable = [
        'by_mark_id',
        'event_id',
        'mark_value',
    ];

    public function result()
    {
        return $this->belongsTo(ByMark::class, 'by_mark_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function playerLocal()
    {
        return $this->belongsTo(PlayerLocal::class, 'event_id', 'event_id');
    }

    public function player()
    {
        return $this->hasOneThrough(Player::class, PlayerLocal::class, 'player_id', 'id');
    }
}
