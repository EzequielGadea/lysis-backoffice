<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Whereabouts\Country;
use App\Models\Teams\Team;
use App\Models\Common\Image;

class Manager extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'country_id',
        'image_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
