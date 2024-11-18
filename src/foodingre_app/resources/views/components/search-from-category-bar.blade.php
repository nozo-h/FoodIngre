<form method="GET" action="{{ route('user.search.category', ['id' => $categoryId]) }}">
    <div class="flex justify-center mt-6 ml-2">
        <input type="search" name="keyword" class="md:mx-2 rounded-lg w-60 md:w-96 h-10 hover:border-indigo-600" placeholder="Search Food..." value="{{ session('keyword') }}"/>
        <input type="submit" class="mx-1 md:mx-2 rounded-lg w-36 md:w-44 h-10 bg-blue-500 hover:bg-blue-600 cursor-pointer max-md:text-xs text-white font-semibold" value="カテゴリ内で検索" />
        <a href="{{ route('user.search') }}" class="mr-1 md:mx-2 w-28 md:w-32 h-10 rounded-lg bg-gray-500 max-md:text-xs text-white text-center font-semibold flex items-center justify-center hover:bg-gray-600">通常の検索</a>
    </div>
</form>