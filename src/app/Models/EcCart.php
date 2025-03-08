<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcCart extends Model
{
    use HasFactory;

    public function ec_addresses()
    {
        return $this->belongsTo(EcAddress::class, 'address_id', 'id');
    }

    public function ec_cart_details()
    {
        return $this->hasMany(EcCartDetail::class, 'cart_id', 'id');
    }

    public function ec_user()
    {
        return $this->belongsTo(EcUser::class, 'user_id', 'id');
    }
}
