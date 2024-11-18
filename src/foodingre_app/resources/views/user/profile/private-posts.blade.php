<x-original-layout.format title="{{ $userInfo->nickname }}の非公開投稿">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col items-center mt-12">
            {{-- 仮アイコン --}}
            <svg class="w-24 h-24 text-gray-800 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>
            <div class="mt-4 text-2xl text-gray-700">{{ $userInfo->nickname }}</div>
        </div>
        <div class="flex justify-center mt-4">
            @if ($isMyAccount)
            <a href="{{ url('user/setting') }}" class="px-6 py-2 rounded bg-gray-500 text-white hover:border-gray-600 hover:bg-gray-600">プロフィール情報を編集</a>
            @endif
        </div>

        <div class="flex flex-col justify-start m-12">

            <div class="flex max-md:justify-center">
                <h2 class="mx-4 pr-4 border-b-2 border-gray-300 hover:border-green-100 ease-linear duration-200 text-sm md:text-xl"><a href="{{ route('user.userProfile.index', ['id' => auth()->user()->id]) }}">自分の投稿一覧</a></h2>
                <h2 class="mx-4 pr-4 border-b-2 border-green-600 hover:border-green-700 ease-linear duration-200 text-sm md:text-xl"><a href="{{ route('user.userProfile.privatePosts', ['id' => auth()->user()->id ]) }}">非公開投稿の一覧</a></h2>
            </div>

            <div class="flex flex-wrap my-4 justify-center md:justify-start">
                @foreach ($userPosts as $post)
                @if(!$post->publication_status && $isMyAccount)
                <div class="flex flex-col mx-5 my-2">
                    <a href="{{ route('user.post.show', ['id' => $post->id]) }}">
                        <div class="w-80 h-64 bg-gray-100 rounded border-2 hover:border-2 hover:border-blue-400 ease-linear duration-150 cursor-pointer overflow-hidden">
                            <x-image filename="{{ $post->imageFirst->filename ?? null }}" type="profile" />
                        </div>
                        <div class="w-80">
                            <p class="mt-2 font-semibold text-lg text-gray-700 text-center truncate">{{ $post->food_label }}</p>
                        </div>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            {{-- ページネーション --}}
            <div>
                {{ $userPosts->links() }}
            </div>
        </div>
    </div>

</x-original-layout.format>