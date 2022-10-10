<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sport;
use App\Models\Country;
use App\Models\Teampp;

class League extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}