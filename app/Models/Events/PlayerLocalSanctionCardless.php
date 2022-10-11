<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->belongsTo(PlayerLocal::class);
    }

    public function sanction()
    {
        return $this->belongsTo(SanctionCardless::class);
    }
}
