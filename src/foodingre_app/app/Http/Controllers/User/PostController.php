<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Models\Images;
use App\Models\Posts;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }

    public function create()
    {
        // カテゴリを取得
        $categories = PrimaryCategory::with('secondaryCategory')->get();

        return view('user.post.create', compact('categories'));
    }

    public function store(CreatePostRequest $request)
    {
        // 必要な変数を宣言
        $imagePath = null;

        // ログイン中のユーザー情報を取得
        $authUserId = Auth::id();

        // 公開設定のDB格納値へ変換
        $publicationStatus = ($request->publicationStatus === 'public') ? true : false;

        // 画像の処理
        // 画像のバリデーション
        $images = $request->file('images');
        $imageValidateResult = ImageService::validateImage($images);

        if($imageValidateResult) {
            return redirect()->back()->withInput()
            ->with(['message' => '画像の枚数は4枚まで、形式はpng/jpegかつ2MB以下である必要があります','status' => 'alert']);
        }

        // DBへ格納する
        try {
            // 画像アップロード処理
            if(!is_null($images)) {
                foreach ($images as $key => $image) {
                    $imagePath[] = ImageService::upload($key ,$image, 'posts');
                }
            }

            
            // DB書き込み処理
            DB::transaction(function() use($authUserId, $publicationStatus, $request, $images, $imagePath)
            {
                // 画像の格納処理
                if(!is_null($images)) {
                    foreach ($images as $key => $image) {
                        $ImageResult[] = Images::create([
                            'user_id' => $authUserId,
                            'url' => null,
                            'filename' => $imagePath[$key],
                            'sort_no' => $key,
                        ]);
                    }
                }

                // ポストのDB処理
                Posts::create([
                    'user_id' => $authUserId,
                    'secondary_category_id' => $request->category,
                    'food_label' => $request->foodLabel,
                    'product_name' => $request->productName,
                    'ingredient' => $request->ingredient,
                    'amount' => $request->amount,
                    'manufacture' => $request->manufacture,
                    'per_gram' => $request->perGrams,
                    'calories' => $request->calories,
                    'proteins' => $request->proteins,
                    'fat' => $request->fat,
                    'carbohydrates' => $request->carbohydrates,
                    'salt' => $request->salt,
                    'other' => $request->other,
                    'remarks' => $request->remarks,
                    'image_first' => $ImageResult[0]->id ?? null,
                    'image_second' => $ImageResult[1]->id ?? null,
                    'image_third' => $ImageResult[2]->id ?? null,
                    'image_fourth' => $ImageResult[3]->id ?? null,
                    'publication_status' => true,
                ]);

            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()->route('user.index')
        ->with(['message' => '投稿が完了しました','status' => 'info']);
    }

    public function edit($id)
    {
        // ログイン中のユーザー情報を取得
        $authUserId = Auth::id();

        // 投稿情報を取得
        $postInfo = Posts::findOrFail($id);

        // ユーザーと投稿ユーザーの整合性確認（違う場合、404）
        if ($authUserId !== $postInfo->user_id) {
            abort(404);
        }
        // カテゴリを取得
        $categories = PrimaryCategory::with('secondaryCategory')->get();

        // 現在のカテゴリを取得
        $currentCategory = SecondaryCategory::findOrFail($postInfo->secondary_category_id);

        return view('user.post.edit', compact('postInfo', 'categories', 'currentCategory'));
    }

    // 投稿の更新処理
    public function update(CreatePostRequest $request, $id)
    {
        // 必要な変数を宣言
        $imageValidateResult = false;

        // 投稿情報・ユーザー情報を取得
        $authUserId = Auth::id();
        $postInfo = Posts::findOrFail($id);

        // 公開設定のDB格納値へ変換
        // $publicationStatus = ($request->publicationStatus === 'public') ? true : false;

        // 画像バリデーション（値以外）
        // 画像サイズ/形式のバリデーション
        $images = $request->file('images');
        $imageValidateResult = ImageService::validateImage($images);

        if($imageValidateResult) {
            return redirect()->back()->withInput()
            ->with(['message' => '画像の形式はpng/jpegかつ2MB以下である必要があります','status' => 'alert']);
        }

        // 画像のname[番号]のバリデーション
        $imageValidateResult = ImageService::requestImageNumberValidation($request);

        if($imageValidateResult) {
            return redirect()->back()->withInput()
            ->with(['message' => '画像の形式はpng/jpegかつ2MB以下である必要があります','status' => 'alert']);
        }

        // 更新対象・削除対象の決定
        $decideDeleteAndUpdateResults = ImageService::decideDeleteAndUpdateResult($request, $postInfo);
        // リクエストで不正がある場合、終了
        if($decideDeleteAndUpdateResults === false) {
            return redirect()->back()->withInput()
            ->with(['message' => '画像更新で不正なリクエストがあります。更新処理を終了します。','status' => 'alert']);
        }

        // 画像ファイルの更新/削除処理とDB書き込み準備
        $imageFilesControl = ImageService::imageFilesControl($postInfo, $images, $decideDeleteAndUpdateResults);

        $imagePath = $imageFilesControl[0];
        $deletePath = $imageFilesControl[1];
        $currentImageId = $imageFilesControl[2];

        // DBへ更新する
        try {
            DB::transaction(function() use($postInfo, $request, $authUserId, $decideDeleteAndUpdateResults, $imagePath, $deletePath, $currentImageId)
            {
                // sort用のカウンター
                $sortNoCounter = 0;
                // 画像のDB更新処理
                foreach($imagePath as $key => $path) {
                    $decideDeleteAndUpdateResult = $decideDeleteAndUpdateResults[$key];

                    // 画像情報の追加処理
                    if(!is_null($path)) {
                        $imageInfo = Images::create([
                            'user_id' => $authUserId,
                            'url' => null,
                            'filename' => $imagePath[$key],
                            'sort_no' => $sortNoCounter,
                        ]);

                        // DB用の情報を取得
                        $imageResult[] = $imageInfo->id;

                        $sortNoCounter++;

                    // 画像情報の維持（タイムスタンプのみ更新）
                    } elseif($decideDeleteAndUpdateResult === "sustain") {
                        $sustainImageInfo = Images::findOrFail($currentImageId[$key]);
                        $sustainImageInfo->update([
                            'sort_no' => $sortNoCounter,
                        ]);

                        // DB用の情報を取得
                        $imageResult[] = $currentImageId[$key];

                        $sortNoCounter++;
                    }
                    
                    // 画像情報の削除処理
                    if(!is_null($deletePath[$key])) {
                        Images::where('filename', $deletePath[$key])->delete();
                    }
                }

                // ポストのDB更新処理
                $postInfo->secondary_category_id = $request->category;
                $postInfo->food_label = $request->foodLabel;
                $postInfo->product_name = $request->productName;
                $postInfo->ingredient = $request->ingredient;
                $postInfo->amount = $request->amount;
                $postInfo->manufacture = $request->manufacture;
                $postInfo->per_gram = $request->perGrams;
                $postInfo->calories = $request->calories;
                $postInfo->proteins = $request->proteins;
                $postInfo->fat =$request->fat;
                $postInfo->carbohydrates =$request->carbohydrates;
                $postInfo->salt =$request->salt;
                $postInfo->other =$request->other;
                $postInfo->remarks =$request->remarks;
                $postInfo->image_first = $imageResult[0] ?? null;
                $postInfo->image_second = $imageResult[1] ?? null;
                $postInfo->image_third = $imageResult[2] ?? null;
                $postInfo->image_fourth = $imageResult[3] ?? null;
                $postInfo->publication_status = true;
                $postInfo->save();

            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
            return;
        }

        return redirect()->route('user.post.show', $id)
        ->with(['message' => '編集が完了しました','status' => 'info']);
    }

    public function destroy($id)
    {
        // ログイン中のユーザー情報を取得
        $authUserId = Auth::id();

        // 投稿情報を取得し対象を削除する
        $postInfo = Posts::findOrFail($id);
        $postInfo->delete();

        // 削除対象が公開の場合のリダイレクト先
        if($postInfo->publication_status) {
            return redirect()->route('user.userProfile.index', $authUserId)
            ->with(['message' => '削除が完了しました','status' => 'info']);
        
        // 削除対象が非公開の場合のリダイレクト先
        } else {
            return redirect()->route('user.userProfile.privatePosts', $authUserId)
            ->with(['message' => '削除が完了しました','status' => 'info']);
        }

    }
}
