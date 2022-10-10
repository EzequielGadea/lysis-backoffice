<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Country;
use App\Models\Teams\Team;
use App\Models\Players\PlayerTeam;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'height',
        'weight'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function teams()
    {
        return $this->hasMany(PlayerTeam::class);
    }
}
