<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPlayerTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_player_team';

    protected $fillable = [
        'contract_start'
    ];
}
