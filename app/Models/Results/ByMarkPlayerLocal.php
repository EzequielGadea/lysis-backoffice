<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\ByMark;
use App\Models\Events\Event;

class ByMarkPlayerLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'by_mark_player_local';

    protected $fillable = [
        'mark_value'
    ];

    public function result()
    {
        return $this->belongsTo(ByMark::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
