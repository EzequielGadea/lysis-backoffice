<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Country;
use App\Models\Team;

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
        return $this->belongsTo(Team::class)->withPivot('contract_start', 'shirt_number', 'position_id');
    }

}
