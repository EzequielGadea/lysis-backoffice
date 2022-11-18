<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set.php;
use App\Models\Events\EventPlayerTeamSanctionCard.php;

class EventPlayerTeamSanctionCardSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team_sanction_card_set';

    protected $fillable = [
	'event_player_team_sanction_card_id',
	'set_id',
    ];

    public function eventPlayerTeamSanctionCard() {
	return $this->belongsTo(EventPlayerTeamSanctionCard::class);
    }

    public function set() {
	return $this->belongsTo(Set::class);
    }
}
