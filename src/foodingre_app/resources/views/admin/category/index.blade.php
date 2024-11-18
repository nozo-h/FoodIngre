<x-admin-original-layout.format title="カテゴリ管理">
    <div class="max-w-7xl mx-auto">
        <div class="mt-4 ml-8">
            <h2 class="flex justify-start text-2xl">カテゴリ管理</h2>
        </div>
        <div class="flex justify-between mt-4 ml-8">
            <a href="{{ route('admin.index') }}">
                <span class="material-symbols-outlined text-sm text-gray-500">arrow_back_ios_new</span>
                <span class="text-gray-800">ホームへ戻る</span>
            </a>
        </div>
        <div class="mx-5 md:mx-20 my-10">
            @foreach ($categories as $category)
            <div class="md:w-160 lg:w-200">
                <div class="flex justify-between my-4 border-b-2 border-sky-500">
                    <p class="text-xl font-bold">{{ $category->name }}</p>
                    <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}">
                        <span class="material-symbols-outlined text-lg text-gray-500">edit</span>
                        <span class="text-sm text-gray-800">編集</span>
                    </a>
                </div>
                <div class="flex flex-wrap ml-3 md:ml-10">
                    @foreach($category->SecondaryCategory as $secondary)
                        <div class="w-full md:w-1/2 lg:w-1/2 text-sm truncate">
                            <p>
                                <span class="material-symbols-outlined text-sm text-gray-500">arrow_forward_ios</span>
                                <span>{{ $secondary->name }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            <div class="flex justify-center mt-10">
                <a href="{{ route('admin.category.create') }}">
                    <div class="px-4 py-2 w-48 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100">
                        <span class="material-symbols-outlined text-sm text-gray-800 font-bold">add</span>
                        <span class="text-gray-800">新規カテゴリ追加</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin-original-layout.format>