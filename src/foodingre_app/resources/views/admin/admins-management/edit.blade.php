<x-admin-original-layout.format title="{{ $admin->name }}の編集">
    <div class="max-w-7xl mx-auto">
        <div class="mt-6">
                <a href="{{ route('admin.admins.index') }}" class="px-7 py-2 bg-sky-500 rounded-lg hover:bg-sky-600 ease-linear duration-100 text-white">管理者一覧へ戻る</a>
        </div>
        <div class="flex flex-col items-center mt-12">
            {{-- 仮アイコン --}}
            <svg class="w-24 h-24 text-gray-800 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>
            <div class="mt-4 text-2xl text-gray-700">{{ $admin->name }}</div>
        </div>
        <div class="flex flex-col items-center">
            {{-- ステータス --}}
            @if ($admin->authority)
            <p class="my-3 text-sm text-gray-700">最高管理者</p>
            @else
            <p class="my-3 text-sm text-gray-700">一般管理者</p>
            @endif
            
            {{-- 権限変更 --}}
            <div class="flex">
                <form method="POST" action="{{ route('admin.admins.update', ['id' => $admin->id])}}" onsubmit="return checkChangeAuthority()">
                    @method('PUT')
                    @csrf
                    @if ($admin->authority)
                    {{-- 権限変更 --}}
                    <button type="submit" name="authority" value="normal_authority" class="w-44 h-10 mx-2 border border-gray-700 rounded-md bg-gray-700 hover:border-gray-800 hover:bg-gray-800 text-white">通常管理者に変更する</button>
                    @else
                    <button type="submit" name="authority" value="supreme_authority" class="w-44 h-10 mx-2 border border-gray-700 rounded-md bg-gray-700 hover:border-gray-800 hover:bg-gray-800 text-white">最高管理者に変更する</button>
                    @endif
                </form>
                <form method="POST" action="{{ route('admin.admins.destroy', ['id' => $admin->id])}}" onsubmit="return checkDeleteAdmin()">
                    @method('DELETE')
                    @csrf
                    <button type="submit" name="deleted_process" value="delete" class="w-44 h-10 mx-2 border border-red-800 rounded-md bg-red-800 hover:border-red-700 hover:bg-red-700 text-white">ユーザーを削除する</button>
                </form>
            </div>
        </div>
        <div class="flex flex-col m-12">
            <h2 class="text-xl">ユーザーの基本情報</h2>
            <div class="flex flex-col mt-4 mx-20">
                <p>メールアドレス：{{ $admin->email }}</p>
                <p>ニックネーム：{{ $admin->nickname }}</p>
                <p>アカウント作成日：{{ $admin->created_at }}</p>
                <p>アカウント更新日：{{ $admin->updated_at }}</p>
                <p>アカウント削除日：{{ $admin->delete_at}}
            </div>
        </div>
    </div>
    <script>
        'use strict'
        // 権限変更メソッド
        function checkChangeAuthority()
        {
            if(confirm('権限を変更してもよろしいですか？管理者種別によって権限に制限があります。ご注意ください。')) {
                return true;
            } else {
                alert('変更はキャンセルしました');
                return false;
            }
        }

        function checkDeleteAdmin()
        {
            if(confirm('管理者を削除してもよろしいですか？')) {
                return true;
            } else {
                alert('削除はキャンセルしました');
                return false;
            }
        }

    </script>
</x-admin-original-layout.format>