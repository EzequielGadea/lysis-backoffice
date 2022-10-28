<?php

namespace App\Models\Common;

use App\Models\Common\Sport;
use App\Models\Events\Event;
use App\Models\Teams\Team;
use App\Models\Whereabouts\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class League extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link',
        'country_id',
        'sport_id',
        'picture'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
