<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\Set;
use App\Models\Events\EventPlayerTeamSanctionCardless;

class EventPlayerTeamSanctionCardlessSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team_sanction_cardless_set';

    protected $fillable = [
        'event_player_team_sanction_cardless_id',
        'set_id',
    ];

    public function eventPlayerTeamSanctionCard() {
        return $this->belongsTo(EventPlayerTeamSanctionCardless::class);
    }

    public function set() {
        return $this->belongsTo(Set::class);
    }
}
