<x-original-layout.format title="検索結果">
    <div class="flex flex-col justify-center mx-auto lg:max-w-7xl max-w-5xl">
        {{-- 検索バー --}}
        <x-search-bar />

        <div class="flex flex-col ml-4 mt-8">
            <p>{{ count($searchResults) }}件が見つかりました</p>
        </div>

        {{-- 通常版 --}}
        <div class="flex flex-wrap my-4 justify-center md:justify-start">
        @foreach ($searchResults as $result)
            <div class="flex flex-col mx-5 my-2">
                <a href="{{ route('user.post.show', ['id' => $result->id]) }}">
                    <div class="w-80 h-64 bg-gray-100 rounded border-2 hover:border-2 hover:border-blue-400 ease-linear duration-150 cursor-pointer overflow-hidden">
                        <x-image filename="{{ $result->imageFirst->filename ?? null }}" type="profile" />
                    </div>
                    <div class="w-80">
                        <p class="mt-2 font-semibold text-lg text-gray-700 text-center truncate">{{ $result->food_label }}</p>
                    </div>
                </a>
            </div>
        @endforeach
        </div>
        {{-- <div class="flex flex-col mx-6">
            @foreach ($searchResults as $result)
            <div class="my-2">
                <a href="{{ route('user.post.show', ['id' => $result->id]) }}">
                    <h1 class="text-xl">{{ $result->food_label }}</h1>
                    
                </a>
            </div>
            @endforeach
        </div> --}}

        {{-- ページネーション（0件の場合以外は処理する） --}}
        @if($searchResults)
        <div class="mb-8">
            {{ $searchResults->appends(['keyword' => $keyword])->links() }}
        </div>
        @endif
    </div>
    <div>
    </div>
</x-original-layout.format>