<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Services\CategoryEditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminCategoryController extends Controller
{

    private const ADJUST_REQUEST_NO = 1;
    private const ADJUST_SORT_NO = 1;
    private const SECONDARY_ID_INIT = 1;
    private const NEW_NO_FOR_CREATE_SECONDARY_CATEGORY = 1;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // カテゴリを取得
        $categories = PrimaryCategory::with('secondaryCategory')->get();

        return view('admin.category.index', compact('categories'));
    }

    // カテゴリ作成
    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // リクエストを取得
        $primaryCategoryRequest = $request->category;
        $secondaryCategoryRequest = $request->subCategory;

        // カテゴリ/サブカテゴリのバリデーション
        $primaryCategoryValidate = CategoryEditService::validate($primaryCategoryRequest);
        $secondaryCategoryValidate = CategoryEditService::validate($secondaryCategoryRequest);

        if ($primaryCategoryValidate === true || $secondaryCategoryValidate === true) {
            return redirect()->route('admin.category.create')
            ->with(['message'=> '入力内容が正しくありません。内容を確認してください', 'status' => 'alert']);
        }

        // カテゴリ作成
        $primaryCategoryInfo = PrimaryCategory::all();
        
        // sort_noの最大値を取得し、作成するsort_no + 1で割り当てる
        $insertSortNo = $primaryCategoryInfo->max('sort_no') + self::ADJUST_SORT_NO;

        try {

            // カテゴリ追加
            $primaryCategoryTable = PrimaryCategory::create([
                'name' => $primaryCategoryRequest,
                'sort_no' => $insertSortNo,
            ]);

            $primaryCategoryId = $primaryCategoryTable->id;

                //サブカテゴリ追加
                $secondaryId = self::SECONDARY_ID_INIT;



                foreach ($secondaryCategoryRequest as $request) {
                    SecondaryCategory::create([
                        'primary_category_id' => $primaryCategoryId,
                        'secondary_id' => $secondaryId,
                        'name' => $request,
                        'sort_no' => $secondaryId,
                    ]);
                    $secondaryId++;
                }

            return redirect()->route('admin.category.index')
            ->with(['message'=> '作成が完了しました', 'status' => 'info']);

        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
            return redirect()->route('admin.category.create')
            ->with(['message'=> '追加でエラーが発生しました。入力内容を確認してください', 'status' => 'alert']);
        }

    }

    public function edit($id)
    {
        // 対象のカテゴリを取得
        $primaryCategoryInfo = PrimaryCategory::findOrFail($id);
        $secondaryCategoryInfo = SecondaryCategory::where('primary_category_id', $id)->get();

        return view('admin.category.edit', compact('primaryCategoryInfo', 'secondaryCategoryInfo'));
    }

    public function update(Request $request, $id)
    {
        // リクエストを取得
        $primaryCategoryRequest = $request->category;
        $secondaryCategoryRequest = $request->subCategory;
        $newSecondaryCategoryRequest = $request->newSubCategory;

        // DBのカテゴリ情報を取得
        $primaryCategoryInfo = PrimaryCategory::findOrFail($id);
        $secondaryCategoryInfo = SecondaryCategory::where('primary_category_id', $id)->get();

        // カテゴリ/サブカテゴリのバリデーション
        $primaryCategoryValidate = CategoryEditService::validate($primaryCategoryRequest);
        $secondaryCategoryValidate = CategoryEditService::validate($secondaryCategoryRequest);
        $newSecondaryCategoryValidate = CategoryEditService::validate($newSecondaryCategoryRequest);

        if ($primaryCategoryValidate === true || $secondaryCategoryValidate === true || $newSecondaryCategoryValidate === true) {
            return redirect()->route('admin.category.edit', ['id' => $id])
            ->with(['message'=> '入力内容が正しくありません。内容を確認してください', 'status' => 'alert']);
        }

        try {
            DB::transaction(function() use($primaryCategoryRequest, $secondaryCategoryRequest, $newSecondaryCategoryRequest, $primaryCategoryInfo, $secondaryCategoryInfo) {

                // カテゴリ更新
                $primaryCategoryInfo->name = $primaryCategoryRequest;
                $primaryCategoryInfo->save();

                // サブカテゴリ更新（今後、N＋1問題を解消する必要あり）
                foreach ($secondaryCategoryRequest as $key => $request) {
                    $secondary = SecondaryCategory::findOrFail($secondaryCategoryInfo[$key - self::ADJUST_REQUEST_NO]->id);
                    $secondary->name = $request;
                    $secondary->save();
                }

                // サブカテゴリ作成（今後、N＋1問題を解消する必要あり）
                if($newSecondaryCategoryRequest){
                    foreach ($newSecondaryCategoryRequest as $key => $request) {
                        SecondaryCategory::create([
                            'primary_category_id' => $primaryCategoryInfo->id,
                            'secondary_id' => (count($secondaryCategoryInfo) + self::NEW_NO_FOR_CREATE_SECONDARY_CATEGORY),
                            'name' => $newSecondaryCategoryRequest[$key],
                            'sort_no' => (count($secondaryCategoryInfo) + self::NEW_NO_FOR_CREATE_SECONDARY_CATEGORY),
                        ]);
                    }
                }
            },2);
            return redirect()->route('admin.category.index')
            ->with(['message'=> '更新が完了しました', 'status' => 'info']);
        } catch (Throwable $e) {
            Log::error($e);
            return redirect()->route('admin.category.edit', ['id' => $id])
            ->with(['message'=> '更新でエラーが発生しました。入力内容を確認してください', 'status' => 'alert']);
        }
    }

    public function selectDeleteItems($id)
    {
        // DBのカテゴリ情報を取得
        $primaryCategoryInfo = PrimaryCategory::findOrFail($id);
        $secondaryCategoryInfo = SecondaryCategory::where('primary_category_id', $id)->get();

        return view('admin.category.select-delete-items', compact('primaryCategoryInfo', 'secondaryCategoryInfo'));
    }

    public function delete(Request $request, $id)
    {
        // フラグ
        $deletePrimaryCategory = false;
        $deleteSecondaryCategory = false;

        // リクエスト
        $primaryCategory = $request->primaryCategory;
        $secondaryCategories = $request->subCategory;

        // DB取得
        $primaryCategoryInfo = PrimaryCategory::findOrFail($id);
        $secondaryCategoryInfo = SecondaryCategory::where('primary_category_id', $id)->get();

        // 処理決定
        if (is_null($primaryCategory) && is_null($secondaryCategories)) {
            return redirect()->route('admin.category.select-delete-items', $id)
            ->with(['message'=> '更新はありません', 'status' => 'info']);
        }

        if ($primaryCategory === "deletePrimaryCategory") {
            $deletePrimaryCategory = true;
        }

        if ($secondaryCategories) {
            $deleteSecondaryCategory = true;
        }

        // カテゴリの処理
        if ($deletePrimaryCategory) {
            try {
                $primaryCategoryInfo->delete();
                return redirect()->route('admin.category.index')
                ->with(['message'=> '削除が完了しました', 'status' => 'info']);
            } catch (Throwable $e) {
                Log::error($e);
                return redirect()->route('admin.category.index')
                ->with(['message'=> '削除処理にてエラーが発生しました', 'status' => 'alert']);
            }
        }

        // サブカテゴリの処理
        if ($deleteSecondaryCategory) {
            try {
                DB::transaction(function() use($secondaryCategories, $secondaryCategoryInfo) {
                        foreach($secondaryCategories as $key => $category) {
                            $secondary = SecondaryCategory::findOrFail($secondaryCategoryInfo[$key - self::ADJUST_REQUEST_NO]->id);
                            $secondary->delete();
                        }
                    },2);
                    return redirect()->route('admin.category.index')
                    ->with(['message'=> '削除が完了しました。', 'status' => 'info']);
            } catch (Throwable $e) {
                Log::error($e);
                return redirect()->route('admin.category.index')
                ->with(['message'=> '削除処理にてエラーが発生しました。', 'status' => 'alert']);
            }
        }
        return redirect()->route('admin.category.index')
        ->with(['message'=> '削除処理にて何らかのエラーが発生しました（削除は実行されていません）。', 'status' => 'alert']);
    }
}
