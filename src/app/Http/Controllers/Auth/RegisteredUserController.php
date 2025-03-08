<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EcUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => ['required', 'string', 'max:255', 'unique:ec_users,user_id'],
            'user_name' => ['required', 'string', 'max:255'],
            'user_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:ec_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = EcUser::create([
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
            'user_kana' => $request->user_kana,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'enable_flg' => $request->enable_flg,
            'admin_flg' => $request->admin_flg,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(url('', null, app()->isProduction()));
    }
}
