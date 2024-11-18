<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestUserLoginController extends Controller
{
    public function login()
    {
        // ゲストユーザーの存在を確認
        $guestUser = User::where('email', UserConstants::GUEST_EMAIL)->first();

        // ゲストユーザーがない場合はアカウントを作成
        if(!$guestUser) {
            $user = User::create([
                'name' => UserConstants::GUEST_NAME,
                'email' => UserConstants::GUEST_EMAIL,
                'nickname' => UserConstants::GUEST_NICKNAME,
                'is_available' => UserConstants::USER_AVAILABLE,
                'authority' => UserConstants::GUEST_AUTHORITY,
                'password' => Hash::make(UserConstants::GUEST_PW),
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME);
        } else {
            
            // ある場合はログイン

            Auth::login($guestUser);

            return redirect(RouteServiceProvider::HOME)
            ->with(['message'=> 'ログインしました', 'status' => 'info']);
        }

    }
}
