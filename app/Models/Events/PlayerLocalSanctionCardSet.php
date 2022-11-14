<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set.php;
use App\Models\Events\PlayerLocalSanctionCard.php;

class PlayerLocalSanctionCardSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_local_sanction_card_set';

    protected $fillable = [
        'player_local_sanction_card_id',
        'set_id',
    ];

    public function playerLocalSanctionCard() {
        return $this->belongsTo(PlayerLocalSanctionCard::class);
    }

    public function set() {
        return $this->belongsTo(Set::class);
    }
}

