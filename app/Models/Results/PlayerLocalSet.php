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
        'set_id',
        'event_id',
        'points_in_favor',
        'points_against',
        'minute'
    ];

    protected $attributes = [
        'points_in_favor' => 0,
        'points_against' => 0
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
