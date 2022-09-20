<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionType;
use App\Models\Client;

class Subscription extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasMany(Client::class);
    }

    public function type() {
        return $this->hasOne(SubscriptionType::class);
    }
}
