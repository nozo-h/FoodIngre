<x-admin-original-layout.format title="{{ $postInfo->food_label }} / {{ $contributorInfo->nickname }}の投稿">
    <div class="max-w-7xl mx-auto">

        <div class="mt-6">
            <a href="{{ route('admin.users.edit', ['id' => $contributorInfo->id]) }}" class="px-7 py-2 rounded bg-sky-500 hover:bg-sky-600 ease-linear duration-100 text-white">プロフィールへ戻る</a>
        </div>

        {{-- タイトル --}}
        <div class="flex max-md:flex-col mt-4 ml-4 justify-between">
            <div>
                <h1 class="text-2xl text-gray-700 font-bold">{{ $postInfo->food_label ?? "タイトルなし" }}</h1>
                <h3 class="text-sm text-gray-500 font-semibold">カテゴリ： {{ $primaryCategoryInfo->name }} / {{ $secondaryCategoryInfo->name }} </h3>
            </div>
            <div class="mr-16 max-md:ml-2 max-md:mt-8 max-md:w-20">
                <form method="POST" action="{{ route('admin.users.post.delete', ['id' => $postInfo->id]) }}">
                    @method('DELETE')
                    @csrf   
                    <button type="submit" class="px-6 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 ease-linear duration-100 text-white" onclick="return confirmDeleteOrNot()">投稿を削除する</button>
                </form>
            </div>
        </div>

        
        {{-- 内容 --}}
        <div class="flex mt-4 max-md:flex-col">
            <div>
                <div class="flex flex-col mx-8 my-4">
                    <div class="swiper-container h-72 w-96 max-md:h-52 max-md:w-72">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <x-image filename="{{ $postInfo->imageFirst->filename ?? null }}" type="detail" />
                            </div>
    
                            @if($postInfo->imageSecond)
                            <div class="swiper-slide">
                                <x-image filename="{{ $postInfo->imageSecond->filename ?? null }}" type="detail" />
                            </div>
                            @endif
    
                            @if($postInfo->imageThird)
                            <div class="swiper-slide">
                                <x-image filename="{{ $postInfo->imageThird->filename ?? null }}" type="detail" />
                            </div>
                            @endif
    
                            @if($postInfo->imageFourth)
                            <div class="swiper-slide">
                                <x-image filename="{{ $postInfo->imageFourth->filename ?? null }}" type="detail" />
                            </div>
                            @endif
    
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                    
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    <div class="flex flex-col mt-4">
                        <div class="mb-1">
                            @if(!$postInfo->publication_status)
                            <p class="text-gray-700">
                                公開ステータス：非公開
                                <span class="material-icons text-gray-500 text-sm">lock_outline</span>
                            </p>
                            @else
                            <p class="text-gray-700">公開ステータス：公開中</p>
                            @endif
                        </div>
                            
                        <p class="mb-1 text-gray-700">投稿者：<a href="{{ route('user.userProfile.index', ['id' => $contributorInfo->id]) }}" class="text-gray-700 underline">{{ $contributorInfo->nickname }}</a></p>
                        <p class="mb-1 text-gray-700">投稿日：{{ date('Y/m/d', strtotime($postInfo->created_at)) }}</p>
                        @if($postInfo->created_at === $postInfo->updated_at)
                        <p class="mb-1 text-gray-700">編集日：{{ date('Y/m/d', strtotime($postInfo->updated_at)) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex flex-col max-md:ml-4 md:mx-6 my-4">
                {{-- 基本情報 --}}

                <div class="mb-4 w-160 max-xl:w-80 border-b border-gray-300 text-xl">基本情報</div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">名称</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->product_name }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">原材料</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->ingredient }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">内容量（gまたはml）</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->amount === null ? "データが存在しません" : floatval($postInfo->amount) }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">製作所・販売所</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->manufacture }}</div>
                </div>

                {{-- 栄養成分 --}}
                <div class="mb-4 w-160 max-xl:w-80 border-b border-gray-300 text-xl">栄養成分表示</div>
                <div class="mb-4">
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->per_gram === null ? "g または ml あたりのデータが存在しません" : "（" .floatval($postInfo->per_gram) . "g または mlあたり）" }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">エネルギー／熱量</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->calories === null ? "データが存在しません" : floatval($postInfo->calories) . "kcal" }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">たんぱく質</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->proteins === null ? "データが存在しません" : floatval($postInfo->proteins) . "g" }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">脂質</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->fat === null ? "データが存在しません" : floatval($postInfo->fat) . "g" }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">炭水化物</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->carbohydrates === null ? "データが存在しません" : floatval($postInfo->carbohydrates) . "g" }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-lg font-semibold">食塩相当量</div>
                    <div class="mt-2 w-160 max-xl:w-80">{{ $postInfo->salt === null ? "データが存在しません" : floatval($postInfo->salt) . "g" }}</div>
                </div>

                {{-- その他（改行は維持する） --}}
                <div class="mb-4">
                    <div class="text-lg font-semibold">その他</div>
                    <div class="mt-2 w-160 max-xl:w-80 whitespace-pre-wrap">{{ $postInfo->other }}</div>
                </div>
                <div class="mb-4 w-160 max-xl:w-80 border-b border-gray-300 text-xl">備考</div>
                <div class="mb-12">
                    <div class="mt-2 w-160 max-xl:w-80 whitespace-pre-wrap">{{ $postInfo->remarks }}</div>
                </div>
            </div>
        </div>


        {{-- 画像 --}}
        {{-- 詳細 --}}

        {{-- コメント？ --}}

    </div>
    <script>
        'use strict'
        function confirmDeleteOrNot()
        {
            if(confirm(`この投稿を削除してもよろしいですか？`)) {
                return true;
            } else {
                alert('削除はキャンセルしました');
                return false;
            }
        }
    </script>
</x-original-layout.format>