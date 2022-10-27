<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Common\League;
use App\Models\Common\Image;

class Sport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image_id'
    ];

    public function leagues()
    {
        return $this->hasMany(League::class);
    }
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
