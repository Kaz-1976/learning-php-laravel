<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use App\Models\EcUser;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;
use Illuminate\Support\Facades\Log;

class ReceiptImagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\EcUser           $user
     * @param  \App\Models\EcReceiptDetail  $image
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(EcUser $ecUser, EcReceiptDetail $ecReceiptDetail)
    {
        // 結果を返す
        return $ecUser->id === $ecReceiptDetail->ec_receipts->user_id;
    }
}
