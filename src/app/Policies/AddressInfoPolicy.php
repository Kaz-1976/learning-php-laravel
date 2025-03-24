<?php

namespace App\Policies;

use App\Models\EcUser;
use App\Models\EcAddress;

class AddressInfoPolicy
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
     * @param  \App\Models\EcUser           $ecUser
     * @param  \App\Models\EcAddress        $ecAddress
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(EcUser $ecUser, EcAddress $ecAddress)
    {
        // 結果を返す
        return $ecUser->id === $ecAddress->user_id;
    }
}
