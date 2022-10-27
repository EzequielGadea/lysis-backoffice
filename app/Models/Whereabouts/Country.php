<?php

namespace App\Models\Whereabouts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Players\Player;
use App\Models\Teams\Team;
use App\Models\Teams\Manager;
use App\Models\Common\League;
use App\Models\Common\Image;
use App\Models\Events\Referee;
use App\Models\Whereabouts\City;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image_id'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function referees()
    {
        return $this->hasMany(Referee::class);
    }
    
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
