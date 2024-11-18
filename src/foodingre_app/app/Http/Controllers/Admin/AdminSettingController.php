<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSettingController extends Controller
{

    private $adminsInfo;

    // 管理者ユーザーか確認
    public function __construct()
    {
        $this->middleware('auth:admin');

        // ユーザー一覧にアクセスする
        $this->adminsInfo = DB::table('admins');
    }

    public function index()
    {
        // ユーザー一覧を取得し表示する（削除済みユーザーは取得しない）
        $admins = $this->adminsInfo->select('*')
        ->where('deleted_at', null)->get();

        return view('admin.admins-management.index', compact('admins'));
    }

    // ユーザーを新規作成する
    public function create()
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.index')
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }

        return view('admin.admins-management.create');
    }

    // 新規作成情報を格納する
    public function store(AdminProfileRequest $request)
    {
        // EMAIL/PW/権限のバリデーション
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'authority' => ['required','in:normal_authority,supreme_authority' ,  'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // DBに登録
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'nickname' => $request->nickname,
            'password' => Hash::make($request->password),
            'is_available' => AdminConstants::ADMIN_USER_AVAILABLE,
            'authority' => ($request->authority === 'supreme_authority') ? AdminConstants::SUPREME_ADMIN_AUTHORITY : AdminConstants::NORMAL_ADMIN_AUTHORITY,
        ]);
        
        return redirect()->route('admin.admins.index')
        ->with(['message' => 'ユーザーを新規作成しました','status' => 'info']);
        
    }

    // 管理ユーザー情報の編集
    public function edit($id)
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());

        // 編集対象の管理ユーザーの情報取得
        $admin = Admin::findOrFail($id);

        return view('admin.admins-management.edit', compact('admin'));
    }

    // 編集内容の更新
    public function update(Request $request ,$id)
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());
        // 編集対象の管理ユーザーの情報取得
        $admin = Admin::findOrFail($id);

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.edit', $id)
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }
        
        // 設定機能↓↓↓
        // 権限
        if(!$admin->authority && $request->authority === 'supreme_authority') {
            $admin->authority = AdminConstants::SUPREME_ADMIN_AUTHORITY;
            $admin->save();
        } elseif($admin->authority && $request->authority === 'normal_authority') {
            $admin->authority = AdminConstants::NORMAL_ADMIN_AUTHORITY;
            $admin->save();
        } else {
            return redirect()->route('admin.admins.edit', $id)
            ->with(['message' => '変更処理でエラーが発生しました','status' => 'alert']);
        }
        return redirect()->route('admin.admins.edit', $id)
        ->with(['message' => '変更が完了しました','status' => 'info']);
        
    }

    // 管理ユーザーの削除処理
    public function destroy(Request $request, $id)
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());
        // 編集対象の管理ユーザーの情報取得
        $admin = Admin::findOrFail($id);

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.edit', $id)
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }

        // 削除を実行 / 正しくない場合はエラーとする
        if($request->deleted_process === 'delete') {
            $admin->delete();
            return redirect()->route('admin.admins.index')
            ->with(['message' => '削除が完了しました','status' => 'info']);
        } else {
            return redirect()->route('admin.admins.edit', $id)
            ->with(['message' => '変更処理でエラーが発生しました','status' => 'alert']);
        }
    }

    // 削除された管理ユーザーリストを取得
    public function deletedAdminList()
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.index')
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }
        // 削除された管理ユーザー一覧を取得
        $admins = Admin::onlyTrashed()->get();

        // 削除されたユーザー情報が存在するか確認する
        $userCheck = Admin::onlyTrashed()->first();
        
        return view('admin.admins-management.deleted-admins-list', compact('admins', 'userCheck'));
        
    }

    // 削除から復活させる
    public function deletedAdminReactivation(Request $request, $id)
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.index')
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }

        // 復活処理をする
        if($request->user_setting === 'reactivation') {
            Admin::withTrashed()->find($id)->restore();
            return redirect()->route('admin.deleted.admins.list')
            ->with(['message' => '復元が完了しました','status' => 'info']);

        } else {
            return redirect()->route('admin.deleted.admins.list')
            ->with(['message' => '変更処理でエラーが発生しました','status' => 'alert']);
        }

    }

    // 完全削除する
    public function deletedAdminCompletely(Request $request, $id)
    {
        // ログイン中の管理者情報を取得
        $authAdmin = Admin::findOrFail(Auth::id());

        // 最高権限者以外は実行不可能とする
        if(!$authAdmin->authority) {
            return redirect()->route('admin.admins.index')
            ->with(['message' => 'この操作を実行する権限がありません','status' => 'alert']);
        }
        // 最高権限の場合、対象のデータを復活させる（それ以外の権限では操作できないようにする）
        if($request->user_setting === 'delete_completely') {
            Admin::withTrashed()->find($id)->forceDelete();
            return redirect()->route('admin.deleted.admins.list')
            ->with(['message' => '完全削除しました','status' => 'info']);

        } else {
            return redirect()->route('admin.deleted.admins.list')
            ->with(['message' => '変更処理でエラーが発生しました','status' => 'alert']);
        }

    }

}
