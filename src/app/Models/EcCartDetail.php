<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcCartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'qty',
        'price'
    ];

    public function ec_carts()
    {
        return $this->belongsTo(EcCart::class, 'cart_id', 'id');
    }

    public function ec_products()
    {
        return $this->belongsTo(EcProduct::class, 'product_id', 'id');
    }
}
