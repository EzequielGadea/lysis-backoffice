<?php

namespace App\Models\Results;

use App\Models\Events\Event;
use App\Models\Players\PlayerLocal;
use App\Models\Results\ByPoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ByPointPlayerLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_point_player_local';

    protected $fillable = [
        'by_point_id',
        'event_id',
        'points_in_favor',
        'points_against',
        'minute',
    ];

    protected $attributes = [
        'points_in_favor' => 0,
        'points_against' => 0,
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function result()
    {
        return $this->belongsTo(ByPoint::class);
    }

    public function playerLocal()
    {
        return $this->belongsTo(PlayerLocal::class, 'event_id', 'event_id');
    }
}
