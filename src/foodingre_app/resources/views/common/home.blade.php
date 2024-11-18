<x-original-layout.format>
    <div class="flex justify-center mx-auto lg:max-w-7xl max-w-5xl">
        <div class="mt-60 max-xl:mt-40">
            <div class="mx-2 mb-1 text-md md:text-xl font-semibold text-gray-700">食べ物の情報を探してみよう！</div>
            <p class="ml-2 mb-4 text-gray-600 text-xs">例：小麦、大豆...etc （企業名でも検索可能）</p>
                <div class="flex items-center justify-center">
                    <form method="GET" action="{{ route('user.search') }}">
                        {{-- module.exportで拡張済 --}}
                        <input type="search" name="keyword" class="mx-1 md:mx-2 rounded-lg w-52 md:w-96 lg:w-160 h-10 md:h-12 hover:border-indigo-600" placeholder="Search Food..."/>
                        <input type="submit" class="mx-1 md:mx-2 rounded-lg w-20 md:w-32 h-10 md:h-12 bg-blue-500 hover:bg-blue-600 cursor-pointer text-white font-semibold" value="検索" />
                    </form>
                </div>
            <div class="flex mx-1 sm:mx-3 mt-8 justify-center">
                <a href="{{ route('user.category') }}" class="mx-1 md:mx-6 w-36 md:w-52 h-12 rounded-lg bg-gray-500 text-white text-center font-semibold flex items-center justify-center hover:bg-gray-600">カテゴリ別検索</a>
                <a href="{{ route('user.post.create') }}" class="mx-1 md:mx-6 w-36 md:w-52 h-12 rounded-lg bg-gray-500 text-white text-center font-semibold flex items-center justify-center hover:bg-gray-600">新規投稿</a>
            </div>
        </div>

    </div>
</x-original-layout.format>