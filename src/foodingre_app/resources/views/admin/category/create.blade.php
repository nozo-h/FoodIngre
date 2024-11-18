<x-admin-original-layout.format title="カテゴリの追加">
    <div class="max-w-7xl mx-auto">
        <div class="mt-4 ml-8">
            <h2 class="flex justify-start text-2xl">カテゴリの追加</h2>
        </div>
        <div class="flex justify-center mt-8">
            <form method="POST" action="{{ route('admin.category.store') }}">
                @csrf

                {{-- カテゴリ --}}
                <div class="flex flex-col mb-6">
                    <label for="category" class="mb-1 text-gray-700 text-md font-semibold">カテゴリ名</label>
                    <input type="text" name="category" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" id="category" value="{{ old('category') }}">
                </div>

                {{-- サブカテゴリ --}}
                <h1 class="text-xl font-semibold mb-4">サブカテゴリ</h1>

                <div id="subCategories">
                    <div class="flex flex-col mb-6">
                        <label for="subCategory[0]" class="mb-1 text-gray-700 text-md font-semibold subCategoryColumn">サブカテゴリ1</label>
                        <input type="text" name="subCategory[0]" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" id="subCategory[0]" value="{{ old('subCategory[0]') }}">
                    </div>
                </div>

                <div class="flex justify-center mb-8">
                    <button type="button" class="px-4 py-2 w-48 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" onclick="return addSubCategory()">
                            <span class="material-symbols-outlined text-sm text-gray-800 font-bold">add</span>
                            <span class="text-gray-800">新規カテゴリ追加</span>
                    </button>
                </div>

                <div class="flex justify-center mb-12">
                    <a href="{{ route('admin.category.index') }}" class="mx-4 py-2 w-32 border border-gray-500 rounded bg-gray-500 text-white text-center hover:border-gray-600 hover:bg-gray-600">戻る</a>
                    <button type="submit" class="mx-4 py-2 w-32 border border-sky-700 rounded bg-sky-700 text-white hover:border-sky-800 hover:bg-sky-800">追加</button>
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
            // subCategoryの要素数を取得
            const subCategoryCount = subCategory.length;
            const subCategoryCountAddOne = subCategoryCount + 1;
        
            // ボタンクリック後の動作
            const newDiv1 = document.createElement('div');
            newDiv1.classList.add('flex','flex-col');
            newDiv1.setAttribute('id', 'div1[' + subCategoryCount + ']')
        
            const newLabel = document.createElement('label');
            newLabel.setAttribute('for', 'subCategory[' + subCategoryCount + ']');
            newLabel.classList.add('mb-1', 'text-gray-700', 'text-md', 'font-semibold','subCategoryColumn');
            newLabel.textContent = 'サブカテゴリ' + subCategoryCountAddOne;
            newLabel.setAttribute('id', 'div1[' + subCategoryCount + ']')
        
            const newInput1 = document.createElement('input');
            newInput1.setAttribute('type', 'text');
            newInput1.setAttribute('name', 'subCategory[' + subCategoryCount + ']');
            newInput1.setAttribute('required', 'required');
            newInput1.setAttribute('maxlength', '255');
            newInput1.classList.add('w-72', 'sm:w-160', 'rounded-lg', 'border-gray-500', 'newSubCategoryColumn');
            newInput1.setAttribute('id', 'subCategory[' + subCategoryCount + ']');
            newInput1.setAttribute('value', '{{ old("subCategory[' + subCategoryCount + ']") }} ');
        
            newDiv1.appendChild(newLabel);
            newDiv1.appendChild(newInput1);
        
            const newDiv2 = document.createElement('div');
            newDiv2.classList.add('flex','mt-2','mb-4');
            newDiv2.setAttribute('id', 'div2[' + subCategoryCount + ']')
        
            const newButton = document.createElement('button');
            newButton.setAttribute('type', 'button');
            newButton.setAttribute('id', 'deleteNewSubCategory[' + subCategoryCount+ ']');
            newButton.setAttribute('onclick', 'return removeColumn(' + subCategoryCount+ ')');
            newButton.classList.add('py-1','px-4','rounded', 'bg-gray-200', 'text-sm' , 'hover:bg-gray-400', 'ease-linear', 'duration-100');
            newButton.textContent = '追加したカテゴリを削除';
        
            newDiv2.appendChild(newButton);
            
            const parentElement = document.getElementById('subCategories');
            parentElement.appendChild(newDiv1);
            parentElement.appendChild(newDiv2);
        }
    
        // カラムの削除
        function removeColumn(subCategoryCount) {
            document.getElementById('div1[' + subCategoryCount + ']').remove();
            document.getElementById('div2[' + subCategoryCount + ']').remove();
        }
    
    </script>

</x-admin-original-layout.format>
