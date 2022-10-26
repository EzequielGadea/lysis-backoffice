<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\Event;
use App\Models\Teams\Team;

class TeamVisitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'team_visitor';

    protected $fillable = [
        'event_id',
        'team_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
