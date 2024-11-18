<x-original-layout.format title="新規投稿を作成">
    <div class="max-w-7xl mx-auto">
        <div class="mt-12">
            <h2 class="flex justify-center sm:justify-start sm:ml-4 text-xl">新規投稿を作成</h2>
        </div>
        <div class="flex flex-col items-center m-5">
            <x-input-error class="mb-4" :messages="$errors->all()"/>
                <form method="POST" action= "{{ route('user.post.create.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- 画像 --}}
                    <div class="flex flex-col items-center my-10">
                        <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像をアップロードする（最大4枚）<br>※1枚あたりのサイズは2MBまで</label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple class="max-sm:w-60 max-sm:text-sm">
                    </div>
                    {{-- カテゴリ --}}
                    <div class="flex flex-col mb-6">
                        <label for="category" class="mb-1 text-gray-700 text-md font-semibold">カテゴリ</label>
                        <p class="text-xs text-gray-600">カテゴリがない場合、「その他」または大項目の中で「その他」を選択してください</p>
                        <select name="category" id="category" required class="w-72 md:w-full bg-gray-100 bg-opacity-50 rounded-lg border border-gray-500" >
                            <option value="{{ old('category') }}">未選択（下から選択してください）</option>
                            @foreach ($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach ($category->SecondaryCategory as $secondary)
                                        <option value="{{$secondary->id}}">
                                            {{ $secondary->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    {{-- 製品情報 --}}
                    <div class="flex flex-col mb-6">
                        <label for="foodLabel" class="mb-1 text-gray-700 text-md font-semibold">商品名</label>
                        <input type="text" id="foodLabel" name="foodLabel" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('foodLabel')}}" placeholder="例：〇〇産小麦使用　焼きそば">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="productName" class="mb-1 text-gray-700 text-md font-semibold">名称</label>
                        <input type="text" id="productName" name="productName" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('productName')}}" placeholder="例：ゆでめん">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="ingredient" class="mb-1 text-gray-700 text-md font-semibold">原材料</label>
                        <textarea id="ingredient" name="ingredient" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="例：小麦（国産）、食塩／かんすい" >{{old('ingredient')}}</textarea>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="amount" class="mb-1 text-gray-700 text-md font-semibold">内容量（グラム/ミリリッター）</label>
                        <input type=number" step="0.001" id="amount" name="amount" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('amount')}}" placeholder="例：100g/1000ml">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="manufacture" class="mb-1 text-gray-700 text-md font-semibold">製造者／販売者</label>
                        <input type="text" id="manufacture" name="manufacture" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('manufacture')}}" placeholder="例：製造者：〇〇株式会社／販売者：△〇株式会社">
                    </div>

                    {{--成分表示 --}}
                    <div class="flex flex-col mb-6">
                        <label for="perGrams" class="mb-1 text-gray-700 text-md font-semibold">g（グラム）あたり</label>
                        <input type=number" step="0.001" id="perGrams" name="perGrams" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('perGrams')}}" placeholder="例：100">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="calories" class="mb-1 text-gray-700 text-md font-semibold">エネルギー（kcal）</label>
                        <input type=number" id="calories" step="0.001" name="calories" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('calories')}}" placeholder="例：250">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="proteins" class="mb-1 text-gray-700 text-md font-semibold">たんぱく質（g）</label>
                        <input type=number" step="0.001" id="proteins" name="proteins" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('proteins')}}" placeholder="例：0.5">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="fat" class="mb-1 text-gray-700 text-md font-semibold">脂質（g）</label>
                        <input type=number" step="0.001" id="fat" name="fat" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('fat')}}" placeholder="例：8.0">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="carbohydrates" class="mb-1 text-gray-700 text-md font-semibold">炭水化物（g）</label>
                        <input type=number" step="0.001" id="carbohydrates" name="carbohydrates" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('carbohydrates')}}" placeholder="例：70.5">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="salt" class="mb-1 text-gray-700 text-md font-semibold">食塩相当量（g）</label>
                        <input type=number" step="0.001" id="salt" name="salt" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{old('salt')}}" placeholder="例：0.2">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="other" class="mb-1 text-gray-700 text-md font-semibold">その他の成分表示</label>
                        <textarea id="other" name="other" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="その他に成分表示内容がある場合、記載してください" >{{old('other')}}</textarea>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="remarks" class="mb-1 text-gray-700 text-md font-semibold">備考</label>
                        <textarea id="remarks" name="remarks" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="備考がある場合、記載してください" >{{old('remarks')}}</textarea>
                    </div>
                    {{-- <div class="flex flex-col mb-20">
                        <label class="mb-1 text-gray-700 text-md font-semibold">公開設定</label>
                        <div class="flex">
                            <label class="mx-4"><input type="radio" name="publicationStatus" class="mx-1" value="public" checked required>公開する</label>
                            <label class="mx-4"><input type="radio" name="publicationStatus" class="mx-1" value="private" required>非公開にする</label>
                        </div>
                    </div> --}}
                    <div class="flex max-md:flex-col max-md:items-center md:justify-center mb-12">
                        <a href="{{ url()->previous() }}" class="mx-4 max-md:mb-4 py-2 w-44 rounded bg-gray-500 text-white text-center">戻る</a>
                        <button type="submit" class="mx-4 max-md:mb-4 py-2 w-44 rounded bg-sky-700 text-white">投稿する</button>
                    </div>
                </form>
        </div>
    </div>
</x-original-layout.format>