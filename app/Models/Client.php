<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionType;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'surname',
        'birth_date',
        'subscription_id'
    ];

    public function user() {
        return $this->hasOne(User::Class);
    }

    public function subscription() {
        return $this->hasOne(Subscription::class);
    }

    public function subscriptionType() {
        return $this->hasOneThrough(SubscriptionType::class, Subscription::class);
    }
}
