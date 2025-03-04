<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcReceipt extends Model
{
    public function ec_receipt_details()
    {
        return $this->hasMany(EcReceiptDetail::class, 'receipt_id', 'id');
    }

    public function ec_user()
    {
        return $this->belongsTo(EcUser::class, 'user_id', 'id');
    }
}
