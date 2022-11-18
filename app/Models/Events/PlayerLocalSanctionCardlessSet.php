<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set;
use App\Models\Events\PlayerLocalSanctionCardless;

class PlayerLocalSanctionCardlessSet extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'player_local_sanction_cardless_set';

    protected $fillable = [
        'player_local_sanction_cardless_id',
        'set_id',
    ];

    public function playerLocalSanctionCardless() {
        return $this->belongsTo(PlayerLocalSanctionCardless::class);
    }

    public function set() {
        return $this->belongsTo(Set::class);
    }
}
