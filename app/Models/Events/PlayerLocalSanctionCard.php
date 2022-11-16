<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\PlayerLocalSanctionCardSet.php;
use App\Models\Players\PlayerLocal;
use App\Models\Sanctions\SanctionCard;

class PlayerLocalSanctionCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_local_sanction_card';

    protected $fillable = [
        'event_id',
        'sanction_card_id',
        'minute'
    ];

    public function player()
    {
        return $this->belongsTo(PlayerLocal::class, 'event_id', 'event_id');
    }

    public function sanction()
    {
        return $this->belongsTo(SanctionCard::class, 'sanction_card_id');
    }

    public function inSet() {
        return $this->hasOne(PlayerLocalSanctionCardSet::class);
    }
}
