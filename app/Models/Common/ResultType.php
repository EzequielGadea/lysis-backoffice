<?php

namespace App\Models\Common;

use App\Models\Results\ByMark;
use App\Models\Results\ByPoint;
use App\Models\Results\BySet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultType extends Model
{
    use HasFactory, SoftDeletes;

    public function byMarks()
    {
        return $this->hasMany(ByMark::class);
    }

    public function byPoints()
    {
        return $this->hasMany(ByPoint::class);
    }

    public function bySets()
    {
        return $this->hasMany(BySet::class);
    }
}
