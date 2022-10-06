<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubscriptionType;
use App\Models\Client;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    public function user() {
        return $this->hasMany(Client::class);
    }
}
