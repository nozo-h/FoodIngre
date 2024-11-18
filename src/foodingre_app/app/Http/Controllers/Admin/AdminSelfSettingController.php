<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Throwable;

class AdminSelfSettingController extends Controller
{
    // 管理者ユーザーか確認
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // 管理者のプロフィール編集画面の表示
    public function index()
    {
        return view('admin.admin-self-setting.index');
    }

    // プロフィールの更新処理
    public function update(AdminProfileRequest $request)
    {
        // ログイン中のユーザー情報を取得
        $authUserId = Auth::id();
        // DBからユーザー情報を取得
        $userInfo = Admin::findOrFail($authUserId);
        // 更新が発生しているか判定する（後のメッセージに反映するため）
        $isUpdate = false;
        // 更新用のカラム名（パスワード以外）
        $userInfoColumnsName = ['name', 'nickname', 'email'];

        /**
         * UserProfileRequestで処理できないバリデーション処理
         * メールアドレスが変わっていた場合に処理する
         * */
        if ($request->email !== $userInfo->email) {
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);
        }
        /**
         * UserProfileRequestで処理できないバリデーション処理
         * パスワード欄が入力されてた場合に処理する
         * */
        if (is_string($request->password)) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        // DB更新処理
        foreach ($userInfoColumnsName as $userInfoColumnName) {
            if ($request->$userInfoColumnName !== $userInfo->$userInfoColumnName) {
                $isUpdate = true;
                $userInfo->$userInfoColumnName = $request->$userInfoColumnName;
                $userInfo->save();
            } 
        }
        // パスワードの更新処理
        if (is_string($request->password)) {
            $isUpdate = true;
            $userInfo->password = Hash::make($request->password);
            $userInfo->save();
        }

        // リダイレクト時の処理分岐
        // 更新がある場合
        if ($isUpdate) {
            return redirect()->route('admin.adminProfile.index')
            ->with(['message'=> 'プロフィールを更新しました', 'status' => 'info']);
        // 更新がない場合
        } else {
            return redirect()->route('admin.adminProfile.index')
            ->with(['message'=> '変更がないため、プロフィールは更新されていません', 'status' => 'info']);
        }

    }

    // ユーザーの削除確認画面
    public function deleteConfirmation()
    {
        // 認証情報はBlade側のヘルパ関数で取得するためreturn viewのみ
        return view('admin.admin-self-setting.profile-delete-confirmation');
    }

    // 削除処理
        // ユーザーの削除処理
        public function delete($id)
        {
            // ログイン中のユーザー情報とidの確認し、異なる場合エラーにする
            $authUserId = Auth::id();
    
            if((int)$id !== $authUserId) {
                return redirect()->route('admin.adminProfile.index')
                ->with(['message'=> 'エラーが発生しました', 'status' => 'alert']);
            }
    
            // ユーザー情報を取得
            $userInfo = Admin::findOrFail($authUserId);
    
            // 将来的にはtransactionで処理が必要
            try {
                $userInfo->delete();
                return redirect('/admin/login')->with(['message'=> 'アカウントは削除されました', 'status' => 'info']);
            } catch (Throwable $e) {
                Log::error($e);
                throw $e;
                return redirect()->route('admin.adminProfile.index')
                ->with(['message'=> 'エラーが発生しました', 'status' => 'alert']);
            }
    
        }
}
