<?php

namespace App\Models\Results;

use App\Models\Results\BySet;
use App\Models\Results\EventPlayerTeamSet;
use App\Models\Results\PlayerLocalSet;
use App\Models\Results\PlayerVisitorSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'by_set_id',
        'number',
    ];

    public function result()
    {
        return $this->belongsTo(BySet::class, 'by_set_id', 'id');
    }

    public function pointsPlayerTeam()
    {
        return $this->hasMany(EventPlayerTeamSet::class, 'set_id', 'id');
    }

    public function playerVisitorPoints()
    {
        return $this->hasMany(PlayerVisitorSet::class);
    }

    public function playerLocalPoints()
    {
        return $this->hasMany(PlayerLocalSet::class);
    }
}
