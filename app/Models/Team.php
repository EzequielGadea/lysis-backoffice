<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Country;
use App\Model\League;
use App\Model\Manager;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_link'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function manager()
    {
        return $this->belongsTo(Mananger::class);
    }
}
