<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\EventPlayerTeam;
use App\Models\Events\EventPlayerTeamSanctionCardSet;
use App\Models\Sanctions\SanctionCard;

class EventPlayerTeamSanctionCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team_sanction_card';

    protected $fillable = [
        'sanction_card_id',
        'event_player_team_id',
        'minute'
    ];

    public function sanction()
    {
        return $this->belongsTo(SanctionCard::class, 'sanction_card_id');
    }

    public function eventPlayerTeam()
    {
        return $this->belongsTo(EventPlayerTeam::class);
    }

    public function inSet () {
        return $this->hasOne(EventPlayerTeamSanctionCardSet::class);
    }
}
