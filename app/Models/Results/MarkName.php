<?php

namespace App\Models\Results;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Results\ByMark;

class MarkName extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function marks()
    {
        return $this->hasMany(ByMark::class);
    }
}
