<?php

namespace App\Http\Controllers\Admin;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Posts;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminUsersSettingController extends Controller
{
    // ページネーションにより１ページあたりの表示数
    private const PAGINATE = 12;

    private $usersInfo;

    public function __construct()
    {
        $this->middleware('auth:admin');

        // ユーザー一覧にアクセスする
        $this->usersInfo = DB::table('users');

    }

    // ユーザー一覧を表示
    public function index()
    {
        // ユーザー一覧を取得し表示する（削除済みユーザーは取得しない）
        $users = $this->usersInfo->select('*')
        ->where('deleted_at', null)->get();

        return view('admin.user-management.list', compact('users'));
    }

    // ユーザー情報の編集ページ
    public function edit($id)
    {
        // ログイン中の管理者情報を取得
        $admin = Admin::findOrFail(Auth::id());

        // 編集するユーザー情報を取得する
        $user = User::findOrFail($id);

        // 投稿情報（非公開情報含めて表示する）
        $userPosts = Posts::where('user_id', $id)
        ->orderBy('created_at', 'desc')->paginate(self::PAGINATE);

        return view('admin.user-management.edit', compact('user', 'admin', 'userPosts'));
    }

    // ユーザー情報の更新処理
    public function update(Request $request, $id)
    {
        // リクエスト情報
        $requestIsAvailable = $request->is_available;
        
        // ログイン中の管理者情報を取得
        $admin = Admin::findOrFail(Auth::id());
        
        // 更新するユーザーの情報を取得
        $user = User::findOrFail($id);
        
        // 管理者が最高権限か普通権限か確認
        if ($admin->authority) {
            // ゲストユーザーの編集権限もあり
            if (!$user->is_available && $requestIsAvailable === 'available') {
                $user->is_available = UserConstants::USER_AVAILABLE;
                $user->save();

            } elseif ($user->is_available && $requestIsAvailable === 'unavailable') {
                $user->is_available = UserConstants::USER_DISABLE;
                $user->save();
            }

        } else {
            // 普通管理者はゲストユーザーの編集権限なし
            if (!$admin->authority && $user->is_available && $requestIsAvailable === 'unavailable') {
                return redirect()->route('admin.users.edit', ['id' => $id ])
                ->with(['message' => 'この操作はできません','status' => 'alert']);

            } elseif (!$user->is_available && $requestIsAvailable === 'available') {
                $user->is_available = UserConstants::USER_AVAILABLE;
                $user->save();

            } elseif ($user->is_available && $requestIsAvailable === 'unavailable') {
                $user->save();
            }
        }

        return redirect()->route('admin.users.edit', ['id' => $id ])
        ->with(['message' => 'ステータスが変更されました','status' => 'info']);
    }

    // ユーザーの削除（ソフトデリート）
    public function destroy(Request $request, $id)
    {
        // リクエスト情報
        $requestDelete = $request->deleted_process;
        
        // ログイン中の管理者情報を取得
        $admin = Admin::findOrFail(Auth::id());
        
        // 更新するユーザーの情報を取得
        $user = User::findOrFail($id);

        // 管理者が最高権限か普通権限か確認
        if ($admin->authority) {
            // ユーザー削除操作
            if (!$user->is_available &&$requestDelete === 'delete') {
                $user->delete();
                return redirect()->route('admin.users.index')
                ->with(['message' => 'ユーザーが削除されました','status' => 'info']);
            }
        }

        return redirect()->route('admin.users.edit', ['id' => $id ])
        ->with(['message' => 'ステータスが変更されました','status' => 'info']);
    }

    // ユーザーのポストを表示（非表示設定の投稿も表示可能にする）
    public function postIndex($id)
    {
        // 投稿情報を取得
        $postInfo = Posts::findOrFail($id);

        // カテゴリ情報を取得
        $secondaryCategoryInfo = SecondaryCategory::findOrFail($postInfo->secondary_category_id);
        $primaryCategoryInfo = PrimaryCategory::findOrFail($secondaryCategoryInfo->primary_category_id);
        
        // 投稿者情報を取得
        $contributorInfo = User::findOrFail($postInfo->user_id);
        
        return view('admin.user-management.post-index', compact('postInfo', 'secondaryCategoryInfo', 'primaryCategoryInfo', 'contributorInfo'));
    }

    // 投稿を削除する機能
    public function postDelete($id)
    {
        // 投稿情報を取得する
        $postInfo = Posts::findOrFail($id);

        $postInfo->delete();

        return redirect()->route('admin.users.edit', ['id' => $postInfo->user_id])
        ->with(['message' => '投稿は削除されました','status' => 'info']);

    }


    // ユーザーの削除リスト
    public function deletedUserList()
    {
        // ユーザー情報を取得
        $users = User::onlyTrashed()->get();

        // 削除されたユーザー情報が存在するか確認する
        $userCheck = User::onlyTrashed()->first();

        return view('admin.user-management.deleted-users-list', compact('users', 'userCheck'));
    }

    // 削除されたユーザーの再復活
    public function deletedUserReactivation(Request $request, $id)
    {
        // ログイン中の管理者情報を取得
        $admin = Admin::findOrFail(Auth::id());
        
        // 最高権限の場合、対象のデータを復活させる（それ以外の権限では操作できないようにする）
        if($admin->authority && $request->user_setting === 'reactivation') {
            User::withTrashed()->find($id)->restore();
            return redirect()->route('admin.deleted.users.list')
            ->with(['message' => '復元が完了しました','status' => 'info']);

        } else {
            return redirect()->route('admin.deleted.users.list')
            ->with(['message' => 'この操作はできません','status' => 'alert']);
        }

    }

    // 削除されたユーザーの完全削除
    public function deletedUserCompletelyDelete(Request $request, $id)
    {
        // ログイン中の管理者情報を取得
        $admin = Admin::findOrFail(Auth::id());

        // 最高権限の場合、対象のデータを復活させる（それ以外の権限では操作できないようにする）
        if($admin->authority && $request->user_setting === 'delete_completely') {
            User::withTrashed()->find($id)->forceDelete();
            return redirect()->route('admin.deleted.users.list')
            ->with(['message' => '完全削除しました','status' => 'info']);

        } else {
            return redirect()->route('admin.deleted.users.list')
            ->with(['message' => 'この操作はできません','status' => 'alert']);
        }
    }



}