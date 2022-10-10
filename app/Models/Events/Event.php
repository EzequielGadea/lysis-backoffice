<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Venue;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_date'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function city(){
        return $this->hasOneThrough(City::class, Venue::class);
    }
}
