<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\MarkName;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerVisitor;
use App\Models\Events\Event;

class ByMark extends Model
{
    use HasFactory, SoftDeletes;

    public function markName()
    {
        return $this->belongsTo(MarkName::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function marksPlayerTeam()
    {
        return $this->hasMany(ByMarkEventPlayerTeam::class);
    }

    public function marksPlayerVisitor()
    {
        return $this->hasMany(ByMarkPlayerVisitor::class);
    }
}
