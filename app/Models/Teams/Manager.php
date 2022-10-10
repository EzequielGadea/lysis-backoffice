<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Country;
use App\Models\Team;

class Manager extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birth_date'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }
}
