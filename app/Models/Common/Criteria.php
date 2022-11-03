<?php

namespace App\Models\Common;

use App\Models\Results\MarkName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sort_by'
    ];

    public function markNames()
    {
        return $this->hasMany(MarkName::class);
    }
}
