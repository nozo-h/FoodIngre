<x-admin-original-layout.format title="カテゴリの編集">
    <div class="max-w-7xl mx-auto">
        <div class="mt-4 ml-8">
            <h2 class="flex justify-start text-2xl">カテゴリの編集</h2>
        </div>
        <div class="flex justify-center mt-8">
            <form method="POST" action="{{ route('admin.category.update', ['id' => $primaryCategoryInfo->id]) }}">
                @csrf
                @method('PUT')

                {{-- カテゴリ --}}
                <div class="flex justify-between">
                    <h1 class="text-xl font-semibold mb-4">カテゴリ</h1>
                    <div class="flex px-4 h-9 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100">
                        <a href="{{ route('admin.category.select-delete-items', ['id' => $primaryCategoryInfo->id]) }}">
                            <span class="material-symbols-outlined text-xl text-gray-800">ink_eraser</span>
                            <span class="ml-2 py-2 text-sm text-gray-800">カテゴリ／サブカテゴリを選択して削除</span>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col mb-6">
                    <label for="category" class="mb-1 text-gray-700 text-md font-semibold">カテゴリ名</label>
                    <input type="text" name="category" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" id="category" value="{{ $primaryCategoryInfo->name }}">
                </div>

                {{-- サブカテゴリ --}}
                <h1 class="text-xl font-semibold mb-4">サブカテゴリ</h1>

                <div id="subCategories">
                    @foreach ($secondaryCategoryInfo as $secondary)
                    <div class="flex flex-col mb-6">
                        <label for="subCategory[{{ $secondary->secondary_id }}]" class="mb-1 text-gray-700 text-md font-semibold subCategoryColumn">サブカテゴリ{{ $secondary->secondary_id }}</label>
                        <input type="text" name="subCategory[{{ $secondary->secondary_id }}]" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" id="subCategory[{{ $secondary->secondary_id }}]" value="{{ $secondary->name }}">
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-center mb-8">
                    <button type="button" class="px-4 py-2 w-48 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" onclick="return addSubCategory()">
                            <span class="material-symbols-outlined text-sm text-gray-800 font-bold">add</span>
                            <span class="text-gray-800">新規カテゴリ追加</span>
                    </button>
                </div>

                <div class="flex justify-center mb-12">
                    <a href="{{ route('admin.category.index') }}" class="mx-4 py-2 w-32 border border-gray-500 rounded bg-gray-500 text-white text-center hover:border-gray-600 hover:bg-gray-600">戻る</a>
                    <button type="submit" class="mx-4 py-2 w-32 border border-sky-700 rounded bg-sky-700 text-white hover:border-sky-800 hover:bg-sky-800">変更</button>
                </div>
            </form>
        </div>
    </div>

    {{-- カラム追加処理 --}}
    <script>
        'use strict'

        function addSubCategory(){
        
            // 対象箇所を取得
            const subCategory = document.getElementsByClassName("subCategoryColumn");
            const newSubCategory = document.getElementsByClassName("newSubCategoryColumn");
            // subCategoryの要素数を取得
            const subCategoryCountAddOne = subCategory.length + 1;
            const newSubCategoryCount = newSubCategory.length;
        
            // ボタンクリック後の動作
            const newDiv1 = document.createElement('div');
            newDiv1.classList.add('flex','flex-col');
            newDiv1.setAttribute('id', 'div1[' + subCategoryCountAddOne + ']')
        
            const newLabel = document.createElement('label');
            newLabel.setAttribute('for', 'subCategory[' + subCategoryCountAddOne + ']');
            newLabel.classList.add('mb-1', 'text-gray-700', 'text-md', 'font-semibold','subCategoryColumn');
            newLabel.textContent = 'サブカテゴリ' + subCategoryCountAddOne;
            newLabel.setAttribute('id', 'div1[' + subCategoryCountAddOne + ']')
        
            const newInput1 = document.createElement('input');
            newInput1.setAttribute('type', 'text');
            newInput1.setAttribute('name', 'newSubCategory[' + newSubCategoryCount + ']');
            newInput1.setAttribute('required', 'required');
            newInput1.setAttribute('maxlength', '255');
            newInput1.classList.add('w-72', 'sm:w-160', 'rounded-lg', 'border-gray-500', 'newSubCategoryColumn');
            newInput1.setAttribute('id', 'subCategory[' + subCategoryCountAddOne + ']');
        
            newDiv1.appendChild(newLabel);
            newDiv1.appendChild(newInput1);
        
            const newDiv2 = document.createElement('div');
            newDiv2.classList.add('flex','mt-2','mb-4');
            newDiv2.setAttribute('id', 'div2[' + subCategoryCountAddOne + ']')
        
            const newButton = document.createElement('button');
            newButton.setAttribute('type', 'button');
            newButton.setAttribute('id', 'deleteNewSubCategory[' + subCategoryCountAddOne + ']');
            newButton.setAttribute('onclick', 'return removeColumn(' + subCategoryCountAddOne + ')');
            newButton.classList.add('py-1','px-4','rounded', 'bg-gray-200', 'text-sm' , 'hover:bg-gray-400', 'ease-linear', 'duration-100');
            newButton.textContent = '追加したカテゴリを削除';
        
            newDiv2.appendChild(newButton);
            
            const parentElement = document.getElementById('subCategories');
            parentElement.appendChild(newDiv1);
            parentElement.appendChild(newDiv2);
        }
    
        // カラムの削除
        function removeColumn(subCategoryCountAddOne) {
            document.getElementById('div1[' + subCategoryCountAddOne + ']').remove();
            document.getElementById('div2[' + subCategoryCountAddOne + ']').remove();
        }
    
    </script>

</x-admin-original-layout.format>
