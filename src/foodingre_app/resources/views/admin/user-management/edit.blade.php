<x-admin-original-layout.format title="{{ $user->name }}">
    <div class="max-w-7xl mx-auto">
        <div class="mt-6">
                <a href="{{ route('admin.users.index') }}" class="px-7 py-2 rounded bg-sky-500 hover:bg-sky-600 ease-linear duration-100 text-white">ユーザー一覧へ戻る</a>
        </div>
        <div class="flex flex-col items-center mt-12">
            {{-- 仮アイコン --}}
            <svg class="w-24 h-24 text-gray-800 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>
            <div class="mt-4 text-2xl text-gray-700">{{ $user->name }}</div>
        </div>
        <div class="flex flex-col items-center">
            {{-- ステータス --}}
            @if ($user->is_available)
            <p class="my-3 text-sm text-gray-700">ステータス：有効</p>
            @else
            <p class="my-3 text-sm text-gray-700">ステータス：無効</p>
            @endif
            
            @if ($user->is_available)
            <div class="flex">
                <form method="POST" action="{{ route('admin.users.update', ['id' => $user->id])}}">
                    @method('PUT')
                    @csrf
                    {{-- 操作ボタン --}}                
                    {{-- 有効ユーザー --}}
                    <button name="is_available" value="unavailable" class="w-44 h-10 mx-2 border border-red-800 rounded-md bg-red-800 hover:border-red-700 hover:bg-red-700 text-white">ユーザーを無効にする</button>

                </form>
            </div>
            @endif
            {{-- 無効ユーザー --}}
            @if (!$user->is_available)
            <div class="flex">
                <form method="POST" action="{{ route('admin.users.update', ['id' => $user->id])}}">
                    @method('PUT')
                    @csrf
                    <button name="is_available" value="available" class="w-44 h-10 mx-2 border border-gray-300 rounded-md bg-gray-300 hover:border-gray-400 hover:bg-gray-400">ユーザーを有効する</button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', ['id' => $user->id])}}">
                    @method('DELETE')
                    @csrf
                    <button name="deleted_process" value="delete" class="w-44 h-10 mx-2 border border-red-800 rounded-md bg-red-800 hover:border-red-700 hover:bg-red-700 text-white">ユーザーを削除する</button>
                </form>
            </div>
            @endif
        </div>
        <div class="flex flex-col m-12">
            <h2 class="text-xl">ユーザーの基本情報</h2>
            <div class="flex flex-col mt-4 mx-20">
                <p>メールアドレス：{{ $user->email }}</p>
                <p>ニックネーム：{{ $user->nickname }}</p>
                <p>アカウント種別：
                    @if (!$user->authority)
                        ゲストユーザー
                    @else
                        通常ユーザー
                    @endif
                </p>
                <p>アカウント作成日：{{ $user->created_at }}</p>
                <p>アカウント更新日：{{ $user->updated_at }}</p>
                <p>アカウント削除日：{{ $user->delete_at}}
            </div>
        </div>
        <div class="flex flex-col justify-start m-12">
            <h2 class="text-xl">ユーザーの投稿一覧</h2>
            <div class="flex flex-wrap my-4 justify-center md:justify-start">
                @foreach ($userPosts as $post)
                <div class="flex flex-col mx-5 my-2">
                    <a href="{{ route('admin.users.post.index', ['id' => $post->id]) }}">
                        <div class="w-80 h-64 bg-gray-100 rounded border-2 hover:border-2 hover:border-blue-400 ease-linear duration-150 cursor-pointer overflow-hidden">
                            <x-image filename="{{ $post->imageFirst->filename ?? null }}" type="profile" />
                        </div>
                        <div class="w-80">
                            <p class="mt-2 font-semibold text-lg text-gray-700 text-center truncate">{{ $post->food_label }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            {{-- ページネーション --}}
            <div>
                {{ $userPosts->links() }}
            </div>
        </div>
    </div>
</x-admin-original-layout.format>