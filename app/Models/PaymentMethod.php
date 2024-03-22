<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_name',
    ];

    public function user_purchaseds()
    {
        return $this->hasMany(UserPurchased::class);
    }
}
