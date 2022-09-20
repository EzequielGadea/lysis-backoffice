<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tag;
use App\Models\Ad;

class Value extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'value',
        'tag_id'
    ];

    public function tag() {
        return $this->belongsTo(Tag::class);
    }

    public function ads() {
        return $this->belongsToMany(Ad::class)->withTimestamps();
    }
}
