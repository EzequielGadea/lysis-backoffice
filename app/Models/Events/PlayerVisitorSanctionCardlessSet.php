<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set.php;
use App\Models\Events\PlayerVisitorSanctionCardless.php;

class PlayerVisitorSanctionCardlessSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_visitor_sanction_cardless_set';

    protected $fillable = [
	'player_visitor_sanction_cardless_id',
	'set_id',
    ];

    public function playerVisitorSanctionCardless() {
        return $this->belongsTo(PlayerVisitorSanctionCardless::class);
    }

    public function set() {
	return $this->belongsTo(Set::class);
    }
}

