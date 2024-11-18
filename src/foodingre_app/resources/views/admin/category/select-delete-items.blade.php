<x-admin-original-layout.format title="カテゴリ／サブカテゴリを選択して削除">
    <div class="max-w-7xl mx-auto">
        <div class="mt-4 ml-8">
            <h2 class="flex justify-start text-2xl">カテゴリ／サブカテゴリを選択して削除</h2>
        </div>
        <div class="flex justify-center mt-8">
            <form method="POST" action="{{ route('admin.category.delete', ['id' => $primaryCategoryInfo->id]) }}">
                @csrf
                @method('DELETE')

                {{-- カテゴリ --}}
                <div class="flex justify-between">
                    <h1 class="text-xl font-semibold mb-4">カテゴリ</h1>
                </div>

                <div class="flex flex-col mb-6">
                    <label for="category" class="mb-1 text-gray-700 text-md font-semibold">カテゴリ名</label>
                    <p class="text-gray-700">{{ $primaryCategoryInfo->name }}</p>
                </div>

                {{-- サブカテゴリ --}}
                <h1 class="text-xl font-semibold mb-4">サブカテゴリ</h1>

                <div class="mb-10">
                    @foreach ($secondaryCategoryInfo as $secondary)
                    <div class="flex flex-col mb-6 px-4 py-2 bg-gray-100 rounded-lg">
                        <label for="subCategory[{{ $secondary->secondary_id }}]" class="mb-1 text-gray-700 text-md font-semibold subCategoryColumn">サブカテゴリ{{ $secondary->secondary_id }}</label>
                        <div class="flex justify-between w-72 sm:w-160">
                            <p class="text-gray-700">{{ $secondary->name }}</p>
                            <div class="flex">
                                <p class="text-sm text-gray-700 mr-2">削除する</p>
                                <input type="checkbox" class="rounded" name="subCategory[{{ $secondary->secondary_id }}]" id="subCategory[{{ $secondary->secondary_id }}]" value="{{ $secondary->id }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- カテゴリを削除 --}}
                <div class="flex flex-col items-center mb-12">
                    <div class="flex">
                        <p class="font-bold">カテゴリ全てを削除する</p>
                        <input type="checkbox" class="ml-4 rounded w-5 h-5" name="primaryCategory" value="deletePrimaryCategory">
                    </div>
                    <p class="mt-2 text-center text-xs text-gray-600">カテゴリ全てを削除する場合、<br>先にサブカテゴリを削除してください</p>
                </div>

                <div class="flex justify-center mb-6">
                    <a href="{{ route('admin.category.edit', ['id' => $primaryCategoryInfo->id]) }}" class="mx-4 py-2 w-32 border border-gray-500 rounded bg-gray-500 text-white text-center hover:border-gray-600 hover:bg-gray-600">編集に戻る</a>
                    <button type="submit" class="mx-4 py-2 px-4 rounded bg-red-300 text-black hover:bg-red-500 hover:text-white" onclick="return confirmDeleteOrNot()">選択したカテゴリを削除</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        'use strict'
        function confirmDeleteOrNot()
        {
            if(confirm(`選択したカテゴリを削除してもよろしいですか？`)) {
                return true;
            } else {
                alert('削除はキャンセルしました');
                return false;
            }
        }
    </script>
</x-admin-original-layout.format>