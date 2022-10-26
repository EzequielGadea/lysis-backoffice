<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Players\Player;
use App\Models\Results\ByMarkPlayerVisitor;
use App\Models\Results\ByPointPlayerVisitor;

class PlayerVisitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_visitor';

    protected $fillable = [
        'event_id',
        'player_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function marks()
    {
        return $this->hasMany(ByMarkPlayerVisitor::class, 'event_id', 'event_id');
    }

    public function points()
    {
        return $this->hasMany(ByPointPlayerVisitor::class, 'event_id', 'event_id');
    }

    public function cardSanctions()
    {
        return $this->hasMany(PlayerVisitorSanctionCard::class, 'event_id', 'event_id');
    }

    public function cardlessSanctions()
    {
        return $this->hasMany(PlayerVisitorSanctionCardless::class, 'event_id', 'event_id');
    }
}
