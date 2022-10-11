<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\BySet;
use App\Models\Results\EventPlayerTeamSet;

class Set extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'set_number'
    ];

    public function result()
    {
        return $this->belongsTo(BySet::class);
    }

    public function points()
    {
        return $this->hasMany(EventPlayerTeamSet::class);
    }
}
