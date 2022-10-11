<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Results\ByPointEventPlayerTeam;

class ByPoint extends Model
{
    use HasFactory, SoftDeletes;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function points()
    {
        return $this->hasMany(ByPointEventPlayerTeam::class);
    }
}
