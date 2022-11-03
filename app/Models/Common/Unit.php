<?php

namespace App\Models\Common;

use App\Models\Results\MarkName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'unit'
    ];

    public function marks()
    {
        return $this->hasMany(MarkName::class);
    }
}
