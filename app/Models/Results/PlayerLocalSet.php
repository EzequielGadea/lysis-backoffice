<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Results\Result;

class PlayerLocalSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_local_set';
    
    protected $fillable = [
        'points_in_favor',
        'points_against',
        'minute'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function result()
    {
        return $this->belongsTo(Set::class);
    }
}
