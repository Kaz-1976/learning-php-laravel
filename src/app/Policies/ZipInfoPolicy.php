<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class ZipInfoPolicy
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
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view()
    {
        // 結果を返す
        return Auth::check();
    }
}
