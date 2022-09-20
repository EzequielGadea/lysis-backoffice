<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Value;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'link',
        'clicks_hired',
        'location'
    ];

    public function values() {
        return $this->belongsToMany(Value::class)->withTimestamps();
    }
}
