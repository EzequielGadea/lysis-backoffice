<?php

namespace App\Models\Results;

use App\Models\Common\ResultType;
use App\Models\Events\Event;
use App\Models\Results\ByPointEventPlayerTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ByPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'result_type_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function points()
    {
        return $this->hasMany(ByPointEventPlayerTeam::class);
    }

    public function type()
    {
        return $this->belongsTo(ResultType::class);
    }
}
