<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Players\PlayerTeam;
use App\Models\Events\EventPlayerTeam;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function players()
    {
        return $this->hasMany(PlayerTeam::class);
    }

    public function playersInEvents()
    {
        return $this->hasManyThrough(EventPlayerTeam::class, PlayerTeam::class);
    }
}
