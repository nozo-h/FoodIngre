<x-admin-original-layout.format title="削除済みユーザー一覧">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-start ml-5 my-5">
            <a href="{{ route('admin.users.index') }}" class="mx-2 px-7 py-2 rounded bg-sky-500 hover:bg-sky-600 ease-linear duration-100 text-white">ユーザー一覧へ戻る</a>
        </div>
        <div>
            <select name="sort_user">
                <option value="userIdAcsend">ユーザーID（昇順）</option>
                <option value="userIdAcsend">ユーザーID（降順）</option>
                <option value="userCreatedAtLatest">アカウント作成日（昇順）</option>
                <option value="userCreatedAtLatest">アカウント作成日（降順）</option>
            </select>
        </div>
        <div class="mt-5">
            <h2 class="text-xl">削除済みユーザー一覧</h2>
        </div>
        <table class="mx-auto mt-5 max-w-6xl">
            <thead>
                <tr class="">
                    <th class="h-8 w-28 text-gray-600">ユーザーID</th>
                    <th class="h-8 w-36 text-gray-600">ユーザー名</th>
                    <th class="h-8 w-44 text-gray-600">メールアドレス</th>
                    <th class="h-8 w-36 text-gray-600">ニックネーム</th>
                    <th class="h-8 w-40 text-gray-600">削除日時</th>
                    <th colspan="2" class="h-8 w-80 text-gray-600"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="h-8">
                        <p class="w-28 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->id }}</p>
                    </td>
                    <td class="h-8">
                        <p class="w-36 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->name }}</p>
                    </td>
                    <td class="h-8">
                        <p class="w-44 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->email }}</p>
                    </td>
                    <td class="h-8">
                        <p class="w-36 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->nickname }}</p>
                    </td>
                    <td class="h-8">
                        <p class="w-40 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->deleted_at }}</p>
                    </td>

                    <td class="flex w-80">
                        <form method="POST" action="{{ route('admin.deleted.users.reactivation', ['id' => $user->id]) }}">
                            @method('PATCH')
                            @csrf
                            <button type="submit" class="mx-2 px-2 py-1 border border-gray-300 rounded bg-gray-300 text-black hover:bg-gray-400 ease-linear duration-75" name="user_setting" value="reactivation">削除を取り消す</button>
                        </form>
                        <form method="POST" action="{{ route('admin.deleted.users.delete-completely', ['id' => $user->id]) }}" id="deleteCompletely" onclick="return confirmDeleteOrNot('{{ $user->name }}')">
                            @method('DELETE')
                            @csrf                            
                            <button type="submit" class="mx-2 px-2 py-1 border border-red-800 rounded bg-red-800 text-white hover:bg-red-700 ease-linear duration-75" name="user_setting" value="delete_completely">完全に削除する</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ユーザーが存在しない場合 --}}
        @if (!$userCheck)
        <div class="flex justify-center mt-4">
            <p class="text-md text-gray-800 font-bold">該当ユーザーは存在しません</p>
        </div>
        @endif
    </div>
    <script>
        'use strict'
        function confirmDeleteOrNot(userName)
        {
            if(confirm(`${userName}を削除してもよろしいですか？` + "\r\n" +`投稿も完全に削除されます。十分にご注意ください。`)) {
                return true;
            } else {
                alert('削除はキャンセルしました');
                return false;
            }
        }
    </script>
</x-admin-original-layout.format>