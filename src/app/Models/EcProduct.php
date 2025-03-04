<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_data',
        'image_type',
        'qty',
        'price',
        'public_flg',
        'created_by',
        'updated_by'
    ];

    public function ec_cart_details()
    {
        return $this->hasMany(EcCartDetail::class, 'product_id', 'id');
    }

    public function ec_user()
    {
        return $this->belongsTo(EcUser::class, 'created_by', 'id');
    }

    public function ec_user_updated()
    {
        return $this->belongsTo(EcUser::class, 'updated_by', 'id');
    }
}
