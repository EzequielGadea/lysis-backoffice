<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set;
use App\Models\Events\PlayerVisitorSanctionCard;

class PlayerVisitorSanctionCardSet extends Model
{
    use HasFactory, SoftDeletes;
  
    protected $table = 'player_visitor_sanction_card_set';

    protected $fillable = [
	'player_visitor_sanction_card_id',
	'set_id',
    ];

    public function playerVisitorSanctionCard() {
	return $this->belongsTo(PlayerVisitorSanctionCard::class);
    }

    public function set() {
	return $this->belongsTo(Set::class);
    }
}
