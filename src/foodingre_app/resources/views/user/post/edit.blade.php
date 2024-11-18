<x-original-layout.format title="投稿を編集">
    <div class="max-w-7xl mx-auto">
        <div class="mt-12">
            <h2 class="flex justify-center sm:justify-start sm:ml-4 text-xl">投稿を編集</h2>
        </div>
        <div class="flex flex-col items-center mx-5 mb-5 mt-10">
            <x-input-error class="mb-4" :messages="$errors->all()"/>
                <form method="POST" action= "{{ route('user.post.update', ['id' => $postInfo->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    {{-- 画像 --}}
                    <h3 class="mb-4 border-b border-gray-300 text-gray-700 text-xl font-bold">画像の設定</h3>
                    <div class="flex flex-col mb-6">
                        <label for="image1" class="mb-1 text-gray-700 text-md font-semibold">画像1（サムネイル）</label>
                        <div class="flex justify-between max-sm:flex-col" id="imageBlock1">
                            @if($postInfo->imageFirst)
                                <div class="w-60 h-40 rounded border-2 overflow-hidden cursor-pointer" id="image1">
                                    <x-image filename="{{ $postInfo->imageFirst->filename }}" type="edit"/>
                                </div>
                            @else
                            <div id="updateImageBlock1" class="max-sm:w-60 max-sm:text-xs">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像1を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[0]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="add" name="updateFlag[0]" id="updateFlag1">
                            </div>
                            @endif
                            @if($postInfo->imageFirst)
                            <div class="hidden max-sm:w-60 max-sm:text-xs" id="updateImageBlock1">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像1を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[0]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="sustain" name="updateFlag[0]" id="updateFlag1">
                            </div>
                            <div class="max-sm:mt-2 sm:self-end">
                                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" id="deleteOrCancelButton1" onclick="return updateImage('image1', 1)">
                                    削除
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="image2" class="mb-1 text-gray-700 text-md font-semibold">画像2</label>
                        <div class="flex justify-between max-sm:flex-col" id="imageBlock2">
                            @if($postInfo->imageSecond)
                                <div class="w-60 h-40 rounded border-2 overflow-hidden cursor-pointer" id="image2">
                                    <x-image filename="{{ $postInfo->imageSecond->filename }}" type="edit"/>
                                </div>
                            @else
                            <div id="updateImageBlock2" class="max-sm:w-60 max-sm:text-xs">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像2を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[1]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="add" name="updateFlag[1]" id="updateFlag2">
                            </div>
                            @endif

                            @if($postInfo->imageSecond)
                            <div class="hidden max-sm:w-60 max-sm:text-xs" id="updateImageBlock2">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像2を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[1]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="sustain" name="updateFlag[1]" id="updateFlag2">
                            </div>
                            <div class="max-sm:mt-2 sm:self-end">
                                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" id="deleteOrCancelButton2" onclick="return updateImage('image2', 2)">
                                    削除
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="image3" class="mb-1 text-gray-700 text-md font-semibold">画像3</label>
                        <div class="flex justify-between max-sm:flex-col" id="imageBlock3">
                            @if($postInfo->imageThird)
                                <div class="w-60 h-40 rounded border-2 overflow-hidden cursor-pointer" id="image3">
                                    <x-image filename="{{ $postInfo->imageThird->filename }}" type="edit"/>
                                </div>
                            @else
                            <div id="updateImageBlock3" class="max-sm:w-60 max-sm:text-xs">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像3を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[2]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="add" name="updateFlag[2]" id="updateFlag3">
                            </div>
                            @endif
                        
                            @if($postInfo->imageThird)
                            <div class="hidden max-sm:w-60 max-sm:text-xs" id="updateImageBlock3">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像3を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[2]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="sustain" name="updateFlag[2]" id="updateFlag3">
                            </div>
                            <div class="max-sm:mt-2 sm:self-end">
                                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" id="deleteOrCancelButton3" onclick="return updateImage('image3', 3)">
                                    削除
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col mb-12">
                        <label for="image4" class="mb-1 text-gray-700 text-md font-semibold">画像4</label>
                        <div class="flex justify-between max-sm:flex-col" id="imageBlock4">
                            @if($postInfo->imageFourth)
                                <div class="w-60 h-40 rounded border-2 overflow-hidden cursor-pointer" id="image4">
                                    <x-image filename="{{ $postInfo->imageFourth->filename }}" type="edit"/>
                                </div>
                            @else
                            <div id="updateImageBlock4" class="max-sm:w-60 max-sm:text-xs">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像4を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[3]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="add" name="updateFlag[3]" id="updateFlag4">
                            </div>
                            @endif

                            @if($postInfo->imageFourth)
                            <div class="hidden max-sm:w-60 max-sm:text-xs" id="updateImageBlock4">
                                <div class="flex flex-col my-10">
                                    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像4を追加する</label>
                                    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
                                    <input type="file" name="images[3]" id="images" accept="image/*">
                                </div>
                                <input type="hidden" value="sustain" name="updateFlag[3]" id="updateFlag4">
                            </div>
                            <div class="max-sm:mt-2 sm:self-end">
                                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-400 ease-linear duration-100" id="deleteOrCancelButton4" onclick="return updateImage('image4', 4)">
                                    削除
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- カテゴリ --}}
                    <h3 class="mb-4 border-b border-gray-300 text-gray-700 text-xl font-bold">投稿内容の設定</h3>
                    <div class="flex flex-col mb-6">
                        <label for="category" class="mb-1 text-gray-700 text-md font-semibold">カテゴリ</label>
                        <p class="text-xs text-gray-600">カテゴリがない場合、「その他」または大項目の中で「その他」を選択してください</p>
                        <select name="category" id="category" required class="w-72 md:w-full bg-gray-100 bg-opacity-50 rounded-lg border border-gray-500" >
                            <option value="{{ $postInfo->secondary_category_id }}">現在選択中のカテゴリ：{{ $currentCategory->name }} </option>
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
                        <input type="text" id="foodLabel" name="foodLabel" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ $postInfo->food_label }}" placeholder="例：〇〇産小麦使用　焼きそば">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="productName" class="mb-1 text-gray-700 text-md font-semibold">名称</label>
                        <input type="text" id="productName" name="productName" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ $postInfo->product_name }}" placeholder="例：ゆでめん">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="ingredient" class="mb-1 text-gray-700 text-md font-semibold">原材料</label>
                        <textarea id="ingredient" name="ingredient" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="例：小麦（国産）、食塩／かんすい" >{{ $postInfo->ingredient }}</textarea>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="amount" class="mb-1 text-gray-700 text-md font-semibold">内容量（グラム/ミリリッター）</label>
                        <input type=number" step="0.001" id="amount" name="amount" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->amount === null ? "" :floatval($postInfo->amount) }}" placeholder="例：100g/1000ml">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="manufacture" class="mb-1 text-gray-700 text-md font-semibold">製造者／販売者</label>
                        <input type="text" id="manufacture" name="manufacture" required class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ $postInfo->manufacture }}" placeholder="例：製造者：〇〇株式会社／販売者：△〇株式会社">
                    </div>

                    {{--成分表示 --}}
                    <div class="flex flex-col mb-6">
                        <label for="perGrams" class="mb-1 text-gray-700 text-md font-semibold">g（グラム）あたり</label>
                        <input type=number" step="0.001" id="perGrams" name="perGrams" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->per_gram === null ? "" : floatval($postInfo->per_gram) }}" placeholder="例：100">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="calories" class="mb-1 text-gray-700 text-md font-semibold">エネルギー（kcal）</label>
                        <input type=number" id="calories" step="0.001" name="calories" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->calories === null ? "" : floatval($postInfo->calories) }}" placeholder="例：250">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="proteins" class="mb-1 text-gray-700 text-md font-semibold">たんぱく質（g）</label>
                        <input type=number" step="0.001" id="proteins" name="proteins" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->proteins === null ? "" : floatval($postInfo->proteins) }}" placeholder="例：0.5">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="fat" class="mb-1 text-gray-700 text-md font-semibold">脂質（g）</label>
                        <input type=number" step="0.001" id="fat" name="fat" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->fat === null ? "" : floatval($postInfo->fat) }}" placeholder="例：8.0">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="carbohydrates" class="mb-1 text-gray-700 text-md font-semibold">炭水化物（g）</label>
                        <input type=number" step="0.001" id="carbohydrates" name="carbohydrates" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->carbohydrates === null ? "" : floatval($postInfo->carbohydrates) }}" placeholder="例：70.5">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="salt" class="mb-1 text-gray-700 text-md font-semibold">食塩相当量（g）</label>
                        <input type=number" step="0.001" id="salt" name="salt" class="w-72 sm:w-160 h-10 p-3 rounded-lg border border-gray-500 border-solid" value="{{ $postInfo->salt === null ? "" : floatval($postInfo->salt) }}" placeholder="例：0.2">
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="other" class="mb-1 text-gray-700 text-md font-semibold">その他の成分表示</label>
                        <textarea id="other" name="other" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="その他に成分表示内容がある場合、記載してください" >{{ $postInfo->other }}</textarea>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="remarks" class="mb-1 text-gray-700 text-md font-semibold">備考</label>
                        <textarea id="remarks" name="remarks" class="w-72 sm:w-160 rounded-lg border-gray-500" placeholder="備考がある場合、記載してください" >{{ $postInfo->remarks }}</textarea>
                    </div>
                    {{-- <div class="flex flex-col mb-20">
                        <label class="mb-1 text-gray-700 text-md font-semibold">公開設定</label>
                        <div class="flex">
                            <label class="mx-4"><input type="radio" name="publicationStatus" class="mx-1" value="public" @if($postInfo->publication_status) checked @endif required>公開する</label>
                            <label class="mx-4"><input type="radio" name="publicationStatus" class="mx-1" value="private" @if(!$postInfo->publication_status) checked @endif required>非公開にする</label>
                        </div>
                    </div> --}}
                    <div class="flex max-md:flex-col max-md:items-center md:justify-center mb-8">
                        <a href="{{ route('user.post.show', ['id' => $postInfo->id]) }}" class="mx-4 max-md:mb-4 py-2 w-44 rounded bg-gray-500 text-white text-center">戻る</a>
                        <button type="submit" class="mx-4 max-md:mb-4 py-2 w-44 rounded bg-sky-700 text-white">編集内容を投稿する</button>
                    </div>
                </form>
                <form method="POST" action="{{ route('user.post.destroy', ['id' => $postInfo->id]) }}">
                @csrf
                @method('delete')
                    <div class="flex justify-center mb-10">
                        <button type="submit" class="mx-4 max-md:mb-4 py-2 w-44 rounded bg-red-700 text-white hover:bg-red-800" onclick="return confirmDeleteOrNot()" >投稿を削除する</button>                        
                    </div>
                </form>
            </div>
    </div>
    <script>
        'use strict'

        // 削除確認
        function confirmDeleteOrNot()
        {
            if(confirm(`この投稿を削除してもよろしいですか？`)) {
                return true;
            } else {
                alert('削除はキャンセルしました');
                return false;
            }
        }

        // 画像処理
        function updateImage($imageId, number)
        {
            const deleteOrCancelButton = document.getElementById("deleteOrCancelButton" + number);
            const image = document.getElementById($imageId);
            const updateImageBlock = document.getElementById("updateImageBlock" + number);
            const updateFlag = document.getElementById("updateFlag" + number);

            deleteOrCancelButton.addEventListener('click', function() {
                if(deleteOrCancelButton.innerText === "削除") {
                    // 取り消しボタンへの変更と現在の画像の非表示
                    deleteOrCancelButton.innerText = "取消";
                    image.style.display = "none";
                    updateImageBlock.style.display = "block";
                    updateFlag.value = "update";

                } else {
                    deleteOrCancelButton.innerText = "削除";
                    image.style.display = "block";
                    updateImageBlock.style.display = "none";
                    updateFlag.value = "sustain";
                }
            });
        }

    </script>
</x-original-layout.format>