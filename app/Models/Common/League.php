<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Common\Sport;
use App\Models\Whereabouts\Country;
use App\Models\Teams\Team;
use App\Models\Events\Event;
use App\Models\Common\Image;

class League extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link',
        'country_id',
        'sport_id',
        'image_id'
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
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
