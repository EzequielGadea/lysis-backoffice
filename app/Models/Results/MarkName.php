<?php

namespace App\Models\Results;

use App\Models\Common\Criteria;
use App\Models\Common\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\ByMark;

class MarkName extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'criteria_id',
        'unit_id'
    ];

    public function marks()
    {
        return $this->hasMany(ByMark::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
