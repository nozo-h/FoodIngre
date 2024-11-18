<x-original-layout.format title="{{$primaryCategoryInfo->name}} / {{ $secondaryCategoryInfo->name }} から検索中">
    <div class="flex flex-col mx-auto lg:max-w-7xl max-w-5xl">        
        {{-- 検索バー --}}
        <x-search-from-category-bar categoryId="{{ $id }}" />

        <div class="ml-4 mt-4">
            <a href="{{ route('user.category') }}">
                <span class="material-symbols-outlined text-sm text-gray-500">arrow_back_ios_new</span>
                <span class="text-gray-800">カテゴリ一覧へ戻る</span>
            </a>
        </div>

        <div class="flex flex-col ml-4 mt-2">
            <p class="font-semibold">カテゴリ：{{ $primaryCategoryInfo->name }} / {{ $secondaryCategoryInfo->name }} の中から検索中</p>
            <p>{{ count($searchResults) }}件が見つかりました</p>
        </div>

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
        </div>
    </div>
</x-original-layout.format>