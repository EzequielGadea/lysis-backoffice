<?php

namespace App\Models\Players;

use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCard;
use App\Models\Events\PlayerLocalSanctionCardless;
use App\Models\Players\Player;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Results\ByPointPlayerLocal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_local';

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
        return $this->hasMany(ByMarkPlayerLocal::class, 'event_id', 'event_id');
    }

    public function points()
    {
        return $this->hasMany(ByPointPlayerLocal::class, 'event_id', 'event_id');
    }

    public function cardSanctions()
    {
        return $this->hasMany(PlayerLocalSanctionCard::class, 'event_id', 'event_id');
    }

    public function cardlessSanctions()
    {
        return $this->hasMany(PlayerLocalSanctionCardless::class, 'event_id', 'event_id');
    }
}
