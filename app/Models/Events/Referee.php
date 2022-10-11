<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Country;

class Referee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }
}
