<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Susbcription;

class SubscriptionType extends Model
{
    use HasFactory, SoftDeletes;

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}
