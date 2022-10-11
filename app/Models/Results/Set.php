<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\BySet;
use App\Models\Results\EventPlayerTeamSet;
use App\Models\Results\PlayerVisitorSet;

class Set extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'set_number'
    ];

    public function result()
    {
        return $this->belongsTo(BySet::class);
    }

    public function pointsPlayerTeam()
    {
        return $this->hasMany(EventPlayerTeamSet::class);
    }

    public function pointsPlayerVisitor()
    {
        return $this->hasMany(PlayerVisitorSet::class);
    }
}
