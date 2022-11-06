<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Players\PlayerLocal;
use App\Models\Results\ByPoint;

class ByPointPlayerLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_point_player_local';

    protected $fillable = [
        'by_point_id',
        'event_id',
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
        return $this->belongsTo(ByPoint::class);
    }

    public function playerLocal()
    {
        return $this->belongsTo(PlayerLocal::class, 'event_id', 'event_id');
    }
}
