<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Users\Subscription;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'surname',
        'birth_date',
        'subscription_id',
        'profile_picture'
    ];

    public function user() 
    {
        return $this->hasOne(User::class);
    }

    public function subscription() 
    {
        return $this->belongsTo(Subscription::class);
    }
}
