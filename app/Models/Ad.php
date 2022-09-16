<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Value;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'clicks_hired',
        'location'
    ];

    public function values() {
        return $this->belongsToMany(Value::class)->withTimestamps();
    }
}
