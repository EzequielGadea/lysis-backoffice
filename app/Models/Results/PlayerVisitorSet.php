<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;

class PlayerVisitorSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_visitor_set';
    
    protected $fillable = [
        'points_in_favor',
        'points_against',
        'minute'
    ];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
