<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        // 最終ログイン日時を更新
        $event->user->last_login_at = now();
        $event->user->save();

        // リダイレクト
        redirect('/ec_site/', 302, [], app()->isProduction())->send();
    }
}
