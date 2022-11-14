<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Events\PlayerVisitorSanctionCardlessSet.php
use App\Models\Players\PlayerVisitor;
use App\Models\Sanctions\SanctionCardless;

class PlayerVisitorSanctionCardless extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'player_visitor_sanction_cardless';

    protected $fillable = [
        'event_id',
        'sanction_cardless_id',
        'minute'
    ];

    public function sanction()
    {
        return $this->belongsTo(SanctionCardless::class);
    }

    public function playerVisitor()
    {
        return $this->belongsTo(PlayerVisitor::class);
    }

    public function inSet() {
        return $this->hasOne(PlayerVisitorSanctionCardlessSet::class);
    }
}
