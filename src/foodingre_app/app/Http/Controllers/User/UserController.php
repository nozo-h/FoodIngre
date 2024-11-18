<?php

namespace App\Http\Controllers\User;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Models\Images;
use App\Models\Posts;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Throwable;

class UserController extends Controller
{
    // ページネーションにより１ページあたりの表示数
    private const PAGINATE = 12;

    // 投稿の公開・非公開のフラグ
    private const PUBLIC_POSTS_FLAG = 1;
    private const PRIVATE_POSTS_FLAG = 0;

    public function index($id)
    {
        $isMyAccount = false;
        /**
         * アカウント情報編集のボタン表示フラグ（本人じゃない場合は表示しない）
         * →$idは文字列のためキャストで整数に変換する
         *  */
        if (Auth::id() === (int)$id) {
            $isMyAccount = true;
        }

        // ユーザー情報を取得
        $userInfo = User::findOrFail($id);

        // 投稿情報（非公開は表示しない）
        $userPosts = Posts::where('user_id', $id)->where('publication_status', self::PUBLIC_POSTS_FLAG)
        ->orderBy('created_at', 'desc')->paginate(self::PAGINATE);

        // 投稿の画像情報
        $imagesInfo = Images::where('user_id', $id)->get(); 

        return view('user.profile.profile', compact('isMyAccount', 'userInfo', 'userPosts', 'imagesInfo'));
    }


    public function edit()
    {
        // 認証情報はBlade側のヘルパ関数で取得するためreturn viewのみ
        return view('user.profile.profile-edit');
    }


    // ユーザー情報の更新処理
    public function update(UserProfileRequest $request)
    {
        // ログイン中のユーザー情報を取得
        $authUserId = Auth::id();
        // DBからユーザー情報を取得
        $userInfo = User::findOrFail($authUserId);
        // 更新が発生しているか判定する（後のメッセージに反映するため）
        $isUpdate = false;
        // 更新用のカラム名（パスワード以外）
        $userInfoColumnsName = ['name', 'nickname', 'email'];

        // ゲストの場合、編集を禁止する
        if($userInfo->authority === 0) {
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> 'ゲストユーザーには編集権限がありません', 'status' => 'alert']);
        }

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
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> 'プロフィールを更新しました', 'status' => 'info']);
        // 更新がない場合
        } else {
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> '変更がないため、プロフィールは更新されていません', 'status' => 'info']);
        }

    }

    // ユーザーの削除確認画面
    public function deleteConfirmation()
    {
        // 認証情報はBlade側のヘルパ関数で取得するためreturn viewのみ
        return view('user.profile.profile-delete-confirmation');
    }

    // ユーザーの削除処理
    public function delete($id)
    {
        // ログイン中のユーザー情報とidの確認し、異なる場合エラーにする
        $authUserId = Auth::id();
        
        if((int)$id !== $authUserId) {
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> 'エラーが発生しました', 'status' => 'alert']);
        }
        // ユーザー情報と画像情報を取得
        $userInfo = User::findOrFail($authUserId);
        $imageInfos = $userInfo->images;

        // ゲストユーザーの場合は処理を中止する
        if($userInfo->authority === UserConstants::GUEST_AUTHORITY) {
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> '権限がありません', 'status' => 'alert']);
        }

        // 将来的にはtransactionで処理が必要
        DB::beginTransaction();

        try {
            // 画像情報の削除
            $userInfo->images()->delete();
            $userInfo->posts()->delete();
            $userInfo->delete();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            
            Log::error($e);
            throw $e;
            return redirect()->route('user.userProfile.edit')
            ->with(['message'=> 'エラーが発生しました', 'status' => 'alert']);
        }

        // 画像ファイルを削除
        foreach($imageInfos as $info) {
            ImageService::delete($info->filename);
        }
        
        return redirect('/')->with(['message'=> 'アカウントは削除されました', 'status' => 'info']);
    }

    // 非公開の投稿一覧
    public function privatePosts($id)
    {

        $isMyAccount = false;
        /**
         * アカウント情報編集のボタン表示フラグ（本人じゃない場合は表示しない）
         * →$idは文字列のためキャストで整数に変換する
         *  */
        if (Auth::id() === (int)$id) {
            $isMyAccount = true;
        } else {
            abort(404);
        }

        // ユーザー情報を取得
        $userInfo = User::findOrFail($id);

        // 投稿情報（非公開のみ表示)
        $userPosts = Posts::where('user_id', $id)->where('publication_status', self::PRIVATE_POSTS_FLAG)
        ->orderBy('created_at', 'desc')->paginate(self::PAGINATE);

        return view('user.profile.private-posts', compact('isMyAccount', 'userInfo', 'userPosts'));
    }
}
