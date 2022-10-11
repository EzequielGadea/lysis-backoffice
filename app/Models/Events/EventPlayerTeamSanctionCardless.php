<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sanctions\SanctionCardless;
use App\Models\Events\EventPlayerTeam;

class EventPlayerTeamSanctionCardless extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team_sanction_cardless';

    protected $fillable = [
        'sanction_cardless_id',
        'event_player_team_id',
        'minute'
    ];

    public function sanction()
    {
        return $this->belongsTo(SanctionCardless::class);
    }

    public function eventPlayerTeam()
    {
        return $this->belongsTo(EventPlayerTeam::class);
    }
}
