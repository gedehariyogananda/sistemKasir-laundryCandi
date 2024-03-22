<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesification extends Model
{
    use HasFactory;

    protected $fillable = [
        'spesifikasi_cuci',
        'harga/kilo',
    ];

    public function user_purchaseds()
    {
        return $this->hasMany(UserPurchased::class, 'id');
    }
}
