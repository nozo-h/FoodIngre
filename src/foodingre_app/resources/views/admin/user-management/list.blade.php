<x-admin-original-layout.format title="ユーザー一覧">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-start ml-5 my-5">
            <a href="{{ route('admin.index') }}" class="mx-2 px-7 py-2 rounded bg-sky-500 hover:bg-sky-600 ease-linear duration-100 text-white">ホームへ戻る</a>
            <a href="{{ route('admin.deleted.users.list') }}" class="mx-2 px-7 py-2 rounded bg-gray-500 hover:bg-gray-600 ease-linear duration-100 text-white">削除済みユーザー一覧</a>
        </div>
        {{-- <div>
            <select name="sort_user">
                <option value="userIdAcsend">ユーザーID（昇順）</option>
                <option value="userIdAcsend">ユーザーID（降順）</option>
                <option value="userCreatedAtLatest">アカウント作成日（昇順）</option>
                <option value="userCreatedAtLatest">アカウント作成日（降順）</option>
            </select>
        </div> --}}
        <div class="mt-5">
            <h2 class="text-xl">ユーザー一覧</h2>
        </div>
        <table class="mx-auto mt-5 max-w-6xl">
            <thead>
                <tr class="">
                    <th class="h-8 text-gray-600">ユーザーID</th>
                    <th class="h-8 text-gray-600">ユーザー名</th>
                    <th class="h-8 text-gray-600">メールアドレス</th>
                    <th class="h-8 text-gray-600">ニックネーム</th>
                    <th class="h-8 text-gray-600">ステータス</th>
                    <th class="h-8 text-gray-600">権限</th>
                    <th class="h-8 text-gray-600">作成日時</th>
                    <th class="h-8 text-gray-600">更新日時</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr onclick="location.href='{{ route('admin.users.edit', ['id' => $user->id ])}}';" class="hover:bg-sky-400 hover:text-white cursor-pointer ease-linear duration-100">
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
                        <p class="w-28 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">
                            @if ($user->is_available)
                            有効
                            @else
                            無効
                            @endif
                        </p>
                    </td>
                    <td class="h-8">
                        <p class="w-28 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">
                            @if ($user->authority)
                            通常ユーザー
                            @else
                            ゲスト
                            @endif
                        </p>
                    </td>
                    <td class="h-8">
                        <p class="w-40 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->created_at }}</p>
                    </td>
                    <td class="h-8">
                        <p class="w-40 items-center text-center overflow-hidden whitespace-nowrap overflow-ellipsis">{{ $user->updated_at }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-original-layout.format>