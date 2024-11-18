<x-original-layout.format title="カテゴリの選択">
    <div class="flex flex-col mx-auto lg:max-w-7xl max-w-5xl">
        <div class="mt-12 ml-8">
            <h2 class="flex justify-start text-xl max-md:justify-center">カテゴリ別で検索</h2>
            <p class="flex mt-2 text-xs max-md:justify-center">調べたいカテゴリをクリックしてください</p>
        </div>
        <div class="mt-4 ml-8">
            <a href="{{ route('user.index') }}">
                <span class="material-symbols-outlined text-sm text-gray-500">arrow_back_ios_new</span>
                <span class="text-gray-800">ホームへ戻る</span>
            </a>
        </div>
        <div class="mx-5 md:mx-20 my-10">
            @foreach ($categories as $category)
            <div class="md:w-160 lg:w-200">
                <div class="my-4 border-b-2 border-green-600">
                    <p class="text-xl font-bold">{{ $category->name }}</p>
                </div>
                <div class="flex flex-wrap ml-3 md:ml-10">
                    @foreach($category->SecondaryCategory as $secondary)
                        <div class="w-full md:w-1/2 lg:w-1/2 text-sm truncate">
                            <a href="{{ route('user.search.category', ['id' => $secondary->id]) }}">
                                <span class="material-symbols-outlined text-sm text-gray-500">arrow_forward_ios</span>
                                <span>{{ $secondary->name }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-original-layout.format>