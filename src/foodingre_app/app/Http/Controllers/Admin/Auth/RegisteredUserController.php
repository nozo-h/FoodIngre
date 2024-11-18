<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use App\Constants\AdminConstants;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'nickname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 管理ユーザー登録処理
        // デフォルトでユーザーステータス：利用可 / 権限：低権限（最高権限ではない)　とする
        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'nickname' => $request->nickname,
            'is_available' => AdminConstants::ADMIN_USER_AVAILABLE,
            'authority' => AdminConstants::NORMAL_ADMIN_AUTHORITY,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect(RouteServiceProvider::ADMIN_HOME);
    }
}
