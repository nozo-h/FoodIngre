<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Throwable;

class SearchController extends Controller
{
    // ページネーションにより１ページあたりの表示数
    private const PAGINATE = 12;

    // DBにおける公開ステータスフラグ
    private const PUBLICATION_STATUS_PUBLIC = 1;

    public function index(Request $request)
    {
        $keyword = $request->keyword;

        // 検索キーワードが何もない場合の処理
        if(!$keyword) {
            return view('common.home');
        }

        // 検索キーワードがある場合の処理
        return redirect()->route('user.search', compact('keyword'));
    }

    // 投稿の表示
    public function show($id)
    {
        // 投稿情報を取得
        $postInfo = Posts::findOrFail($id);
        /**
         * アカウント情報編集のボタン表示フラグ（本人じゃない場合は表示しない）
         * →$idは文字列のためキャストで整数に変換する
         *  */
        $isMyAccount = false;
        if (Auth::id() === (int)$postInfo->user_id) {
            $isMyAccount = true;
        }

        
        // postInfoが非公開の場合かつ自ユーザー出ない場合、404にする
        if (!$postInfo->publication_status && !$isMyAccount) {
            abort(404);
        } 

        // カテゴリ情報を取得 / カテゴリが削除された場合はnull
        try{
            $secondaryCategoryInfo = SecondaryCategory::findOrFail($postInfo->secondary_category_id);
            $primaryCategoryInfo = PrimaryCategory::findOrFail($secondaryCategoryInfo->primary_category_id);
        } catch (Throwable $e)
        {
            $secondaryCategoryInfo = null;
            $primaryCategoryInfo = null;
        }
        
        // 投稿者情報を取得
        $contributorInfo = User::findOrFail($postInfo->user_id);
        
        return view('user.post.show', compact('isMyAccount', 'postInfo', 'secondaryCategoryInfo', 'primaryCategoryInfo', 'contributorInfo'));

    }

    // 検索を行う
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        // キーワードが何もない場合、空配列とセッションを更新
        if(!$keyword) {
            $searchResults = [];
            session(['keyword' => $keyword]);
            return view('common.search', compact('searchResults'));
        }
        
        // 全検索
        // 非公開機能は未搭載↓
        if($keyword === "*") {
            $searchResults = Posts::orderBy('updated_at', 'desc')->paginate(self::PAGINATE);
        } else {
            // 検索条件と結果取得 あいまい検索＋検索順位を定義
            $searchResults = Posts::where(function($query) use ($keyword) {
                $query->orWhere('food_label', 'like', '%' . $keyword . '%');
                $query->orWhere('product_name', 'like', '%' . $keyword . '%');
                $query->orWhere('ingredient', 'like', '%' . $keyword . '%');
                $query->orWhere('other', 'like', '%' . $keyword . '%');
                $query->orWhere('remarks', 'like', '%' . $keyword . '%');
                $query->orWhere('manufacture', 'like', '%' . $keyword . '%');
            })
            ->where('publication_status', '=', self::PUBLICATION_STATUS_PUBLIC) // column6が1の場合を追加
            ->orderByRaw("
                CASE
                    WHEN food_label LIKE '%{$keyword}%' THEN 1
                    WHEN product_name LIKE '%{$keyword}%' THEN 2
                    WHEN ingredient LIKE '%{$keyword}%' THEN 3
                    WHEN other LIKE '%{$keyword}%' THEN 4
                    WHEN remarks LIKE '%{$keyword}%' THEN 5
                    WHEN manufacture LIKE '%{$keyword}%' THEN 6
                    ELSE 7
                END
            ")
            ->paginate(self::PAGINATE);
        }
        

        // セッションに検索値を格納する
        session(['keyword' => $keyword]);

    return view('common.search', compact('searchResults', 'keyword'));

    }

    // カテゴリ表示
    public function category()
    {
        // カテゴリを取得
        $categories = PrimaryCategory::with('secondaryCategory')->get();

        return view('common.category', compact('categories'));
    }

    // カテゴリ別検索結果
    public function searchFromCategory(Request $request, $id)
    {
        
        // ページに表示するカテゴリ情報を取得
        $secondaryCategoryInfo = SecondaryCategory::findOrFail($id);
        $primaryCategoryInfo = PrimaryCategory::findOrFail($secondaryCategoryInfo->primary_category_id);
        
        $keyword = $request->keyword;
        
        // 検索値を入力した際にキーワードが何もない場合、空配列とセッションを更新　＋ カテゴリ条件のみ検索
        if(!$keyword) {
            // カテゴリ条件を満たすものかつ、公開されている内容を表示
            $searchResults = Posts::where('secondary_category_id', $id)
                                    ->where('publication_status', self::PUBLICATION_STATUS_PUBLIC)
                                    ->paginate(self::PAGINATE);
            session(['keyword' => $keyword]);
            return view('common.search-from-category', compact('id', 'searchResults', 'secondaryCategoryInfo', 'primaryCategoryInfo'));
        }

        // 検索条件と結果取得 あいまい検索＋検索順位を定義
        $searchResults = Posts::where(function($query) use ($keyword) {
            $query->orWhere('food_label', 'like', '%' . $keyword . '%');
            $query->orWhere('product_name', 'like', '%' . $keyword . '%');
            $query->orWhere('ingredient', 'like', '%' . $keyword . '%');
            $query->orWhere('other', 'like', '%' . $keyword . '%');
            $query->orWhere('remarks', 'like', '%' . $keyword . '%');
            $query->orWhere('manufacture', 'like', '%' . $keyword . '%');
        })
        ->where('secondary_category_id', '=', $id)
        ->where('publication_status', '=', self::PUBLICATION_STATUS_PUBLIC) // column6が1の場合を追加
        ->orderByRaw("
            CASE
                WHEN food_label LIKE '%{$keyword}%' THEN 1
                WHEN product_name LIKE '%{$keyword}%' THEN 2
                WHEN ingredient LIKE '%{$keyword}%' THEN 3
                WHEN other LIKE '%{$keyword}%' THEN 4
                WHEN remarks LIKE '%{$keyword}%' THEN 5
                WHEN manufacture LIKE '%{$keyword}%' THEN 6
                ELSE 7
            END
        ")
        ->paginate(self::PAGINATE);

        // セッションに検索値を格納する
        session(['keyword' => $keyword]);

        return view('common.search-from-category', compact('id', 'searchResults', 'secondaryCategoryInfo', 'primaryCategoryInfo'));
    }
}
