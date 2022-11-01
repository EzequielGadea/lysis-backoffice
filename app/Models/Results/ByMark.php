<?php

namespace App\Models\Results;

use App\Models\Common\ResultType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\MarkName;
use App\Models\Results\ByMarkEventPlayerTeam;
use App\Models\Results\ByMarkPlayerVisitor;
use App\Models\Results\ByMarkPlayerLocal;
use App\Models\Events\Event;

class ByMark extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'mark_name_id',
        'result_type_id'
    ];

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

    public function marksPlayerLocal()
    {
        return $this->hasMany(ByMarkPlayerLocal::class);
    }

    public function type()
    {
        return $this->belongsTo(ResultType::class, 'result_type_id', 'id');
    }
}
