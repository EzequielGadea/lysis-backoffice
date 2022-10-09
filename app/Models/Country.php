<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Player;
use App\Models\Manager;
use App\Models\League;
use App\Models\Team;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'country_flag_link'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }
    
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
