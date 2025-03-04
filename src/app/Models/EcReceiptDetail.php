<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcReceiptDetail extends Model
{
    public function ec_receipts()
    {
        return $this->belongsTo(EcReceipt::class, 'receipt_id', 'id');
    }

    public function ec_products()
    {
        return $this->belongsTo(EcProduct::class, 'product_id', 'id');
    }
}
