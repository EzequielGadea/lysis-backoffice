<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Events\PlayerLocalSanctionCardlessSet;
use App\Models\Sanctions\SanctionCardless;
use App\Models\Players\PlayerLocal;

class PlayerLocalSanctionCardless extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_local_sanction_cardless';

    protected $fillable = [
        'event_id',
        'sanction_cardless_id',
        'minute'
    ];

    public function playerLocal()
    {
        return $this->belongsTo(PlayerLocal::class, 'event_id', 'event_id');
    }

    public function sanction()
    {
        return $this->belongsTo(SanctionCardless::class, 'sanction_cardless_id', 'id');
    }

    public function inSet() {
        return $this->hasOne(PlayerLocalSanctionCardlessSet::class);
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
