<?php

namespace App\Models\Sanctions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanctionCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'color'
    ];
}
