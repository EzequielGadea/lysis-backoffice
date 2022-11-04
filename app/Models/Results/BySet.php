<?php

namespace App\Models\Results;

use App\Models\Common\ResultType;
use App\Models\Events\Event;
use App\Models\Results\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BySet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'set_amount',
        'result_type_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    public function points()
    {
        return $this->hasManyThrough(EventPlayerTeamSet::class, Set::class);
    }

    public function type()
    {
        return $this->belongsTo(ResultType::class, 'result_type_id', 'id');
    }

    public function allTeamPoints()
    {
        $points = collect();
        foreach ($this->sets as $set) {
            $points->concat($set->pointsPlayerTeam);
        }
        return $points;
    }
}
