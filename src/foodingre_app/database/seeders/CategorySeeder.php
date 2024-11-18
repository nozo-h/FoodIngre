<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // 初期値
    public function run(): void
    {
        DB::table('primary_categories')->insert([
            ['id' => 1,'name' => '米・小麦・穀物','sort_no' => 1,],
            ['id' => 2,'name' => 'パン・シリアル・麺類','sort_no' => 2,],
            ['id' => 3,'name' => '肉・卵','sort_no' => 3,],
            ['id' => 4,'name' => '魚介・魚卵・海藻','sort_no' => 4,],
            ['id' => 5,'name' => '牛乳・乳製品（アイスクリームを除く）','sort_no' => 5,],
            ['id' => 6,'name' => '野菜','sort_no' => 6,],
            ['id' => 7,'name' => '果物','sort_no' => 7,],
            ['id' => 8,'name' => '大豆・大豆加工品','sort_no' => 8,],
            ['id' => 9,'name' => '飲料（アルコールなし・乳飲料を除く）','sort_no' => 9,],
            ['id' => 10,'name' => 'アルコール飲料','sort_no' => 10,],
            ['id' => 11,'name' => '惣菜・冷凍食品・インスタント食品','sort_no' => 11,],
            ['id' => 12,'name' => 'お菓子','sort_no' => 12,],
            ['id' => 13,'name' => '調味料','sort_no' => 13,],
            ['id' => 14,'name' => 'カテゴリなし','sort_no' => 14,],
        ]);

        DB::table('secondary_categories')->insert([
            ['id' => 1, 'primary_category_id' => 1, 'secondary_id' => 1, 'name' => '米、米粉', 'sort_no' => 1],
            ['id' => 2, 'primary_category_id' => 1, 'secondary_id' => 2, 'name' => '小麦、小麦粉', 'sort_no' => 2],
            ['id' => 3, 'primary_category_id' => 1, 'secondary_id' => 3, 'name' => '片栗粉', 'sort_no' => 3],
            ['id' => 4, 'primary_category_id' => 1, 'secondary_id' => 4, 'name' => 'ピーナッツ、アーモンド等', 'sort_no' => 4],
            ['id' => 5, 'primary_category_id' => 1, 'secondary_id' => 5, 'name' => '穀物加工品（お粥、レトルト、ピーナッツバター等）', 'sort_no' => 5],
            ['id' => 6, 'primary_category_id' => 1, 'secondary_id' => 6, 'name' => 'その他（米、麦、穀物）', 'sort_no' => 6],
            ['id' => 7, 'primary_category_id' => 2, 'secondary_id' => 1, 'name' => 'パン', 'sort_no' => 1],
            ['id' => 8, 'primary_category_id' => 2, 'secondary_id' => 2, 'name' => 'シリアル', 'sort_no' => 2],
            ['id' => 9, 'primary_category_id' => 2, 'secondary_id' => 3, 'name' => 'うどん', 'sort_no' => 3],
            ['id' => 10, 'primary_category_id' => 2, 'secondary_id' => 4, 'name' => 'そば', 'sort_no' => 4],
            ['id' => 11, 'primary_category_id' => 2, 'secondary_id' => 5, 'name' => 'ラーメン', 'sort_no' => 5],
            ['id' => 12, 'primary_category_id' => 2, 'secondary_id' => 6, 'name' => 'パスタ・スパゲティ・マカロニ', 'sort_no' => 6],
            ['id' => 13, 'primary_category_id' => 2, 'secondary_id' => 7, 'name' => 'その他（パン粉、シリアル、麺類）', 'sort_no' => 7],
            ['id' => 14, 'primary_category_id' => 3, 'secondary_id' => 1, 'name' => '精肉（牛、豚、鶏、その他精肉等）', 'sort_no' => 1],
            ['id' => 15, 'primary_category_id' => 3, 'secondary_id' => 2, 'name' => '卵', 'sort_no' => 2],
            ['id' => 16, 'primary_category_id' => 3, 'secondary_id' => 3, 'name' => 'ソーセージ・ハム・ベーコン等', 'sort_no' => 3],
            ['id' => 17, 'primary_category_id' => 3, 'secondary_id' => 4, 'name' => 'その他（肉加工品）', 'sort_no' => 4],
            ['id' => 18, 'primary_category_id' => 4, 'secondary_id' => 1, 'name' => '鮮魚・魚卵', 'sort_no' => 1],
            ['id' => 19, 'primary_category_id' => 4, 'secondary_id' => 2, 'name' => '魚加工品（缶詰、佃煮等）', 'sort_no' => 2],
            ['id' => 20, 'primary_category_id' => 4, 'secondary_id' => 3, 'name' => '海藻類', 'sort_no' => 3],
            ['id' => 21, 'primary_category_id' => 4, 'secondary_id' => 4, 'name' => 'その他（魚介類、海藻類）', 'sort_no' => 4],
            ['id' => 22, 'primary_category_id' => 5, 'secondary_id' => 1, 'name' => '牛乳・乳飲料', 'sort_no' => 1],
            ['id' => 23, 'primary_category_id' => 5, 'secondary_id' => 2, 'name' => 'バター、チーズ、生クリーム', 'sort_no' => 2],
            ['id' => 24, 'primary_category_id' => 5, 'secondary_id' => 3, 'name' => 'ヨーグルト', 'sort_no' => 3],
            ['id' => 25, 'primary_category_id' => 5, 'secondary_id' => 4, 'name' => 'その他（乳製品）', 'sort_no' => 4],
            ['id' => 26, 'primary_category_id' => 6, 'secondary_id' => 1, 'name' => '野菜類', 'sort_no' => 1],
            ['id' => 27, 'primary_category_id' => 6, 'secondary_id' => 2, 'name' => '野菜加工品（缶詰、カット野菜等）', 'sort_no' => 2],
            ['id' => 28, 'primary_category_id' => 6, 'secondary_id' => 3, 'name' => 'その他（野菜）', 'sort_no' => 3],
            ['id' => 29, 'primary_category_id' => 7, 'secondary_id' => 1, 'name' => '果物類', 'sort_no' => 1],
            ['id' => 30, 'primary_category_id' => 7, 'secondary_id' => 2, 'name' => '果物加工品（缶詰、ジャム等）', 'sort_no' => 2],
            ['id' => 31, 'primary_category_id' => 7, 'secondary_id' => 3, 'name' => 'その他（果物）', 'sort_no' => 3],
            ['id' => 32, 'primary_category_id' => 8, 'secondary_id' => 1, 'name' => '豆腐・油揚げ・厚揚げ', 'sort_no' => 1],
            ['id' => 33, 'primary_category_id' => 8, 'secondary_id' => 2, 'name' => '納豆', 'sort_no' => 2],
            ['id' => 34, 'primary_category_id' => 8, 'secondary_id' => 3, 'name' => 'その他（大豆類、きな粉等）', 'sort_no' => 3],
            ['id' => 35, 'primary_category_id' => 9, 'secondary_id' => 1, 'name' => '水', 'sort_no' => 1],
            ['id' => 36, 'primary_category_id' => 9, 'secondary_id' => 2, 'name' => '緑茶、紅茶、ジャスミン茶等', 'sort_no' => 2],
            ['id' => 37, 'primary_category_id' => 9, 'secondary_id' => 3, 'name' => 'コーヒー', 'sort_no' => 3],
            ['id' => 38, 'primary_category_id' => 9, 'secondary_id' => 4, 'name' => 'ジュース（果実ジュース、炭酸飲料等）', 'sort_no' => 4],
            ['id' => 39, 'primary_category_id' => 9, 'secondary_id' => 5, 'name' => 'その他（アルコールなしの飲料）', 'sort_no' => 5],
            ['id' => 40, 'primary_category_id' => 10, 'secondary_id' => 1, 'name' => 'ビール', 'sort_no' => 1],
            ['id' => 41, 'primary_category_id' => 10, 'secondary_id' => 2, 'name' => 'ワイン', 'sort_no' => 2],
            ['id' => 42, 'primary_category_id' => 10, 'secondary_id' => 3, 'name' => 'カクテル', 'sort_no' => 3],
            ['id' => 43, 'primary_category_id' => 10, 'secondary_id' => 4, 'name' => 'チューハイ', 'sort_no' => 4],
            ['id' => 44, 'primary_category_id' => 10, 'secondary_id' => 5, 'name' => 'その他（アルコール飲料）', 'sort_no' => 5],
            ['id' => 45, 'primary_category_id' => 11, 'secondary_id' => 1, 'name' => 'コンビニエンスストア惣菜・弁当', 'sort_no' => 1],
            ['id' => 46, 'primary_category_id' => 11, 'secondary_id' => 2, 'name' => 'その他スーパ等の惣菜', 'sort_no' => 2],
            ['id' => 47, 'primary_category_id' => 11, 'secondary_id' => 3, 'name' => '冷凍食品', 'sort_no' => 3],
            ['id' => 48, 'primary_category_id' => 11, 'secondary_id' => 4, 'name' => 'インスタント麺', 'sort_no' => 4],
            ['id' => 49, 'primary_category_id' => 11, 'secondary_id' => 5, 'name' => 'インスタントルー／パスタソース等', 'sort_no' => 5],
            ['id' => 50, 'primary_category_id' => 11, 'secondary_id' => 6, 'name' => 'その他（冷凍食品、インスタント食品）', 'sort_no' => 6],
            ['id' => 51, 'primary_category_id' => 12, 'secondary_id' => 1, 'name' => 'ケーキ・パイ・タルト・シュークリーム等', 'sort_no' => 1],
            ['id' => 52, 'primary_category_id' => 12, 'secondary_id' => 2, 'name' => 'クッキー・ビスケット', 'sort_no' => 2],
            ['id' => 53, 'primary_category_id' => 12, 'secondary_id' => 3, 'name' => '和菓子（煎餅、ようかん等）', 'sort_no' => 3],
            ['id' => 54, 'primary_category_id' => 12, 'secondary_id' => 4, 'name' => 'スナック菓子（ポテトチップス等）', 'sort_no' => 4],
            ['id' => 55, 'primary_category_id' => 12, 'secondary_id' => 5, 'name' => 'チョコレート', 'sort_no' => 5],
            ['id' => 56, 'primary_category_id' => 12, 'secondary_id' => 6, 'name' => 'ガム・キャンディー、グミ', 'sort_no' => 6],
            ['id' => 57, 'primary_category_id' => 12, 'secondary_id' => 7, 'name' => 'アイスクリーム、ラクトアイス等', 'sort_no' => 7],
            ['id' => 58, 'primary_category_id' => 12, 'secondary_id' => 8, 'name' => 'その他（お菓子）', 'sort_no' => 8],
            ['id' => 59, 'primary_category_id' => 13, 'secondary_id' => 1, 'name' => '油（サラダ油、米油、オリーブ油、ごま油等）', 'sort_no' => 1],
            ['id' => 60, 'primary_category_id' => 13, 'secondary_id' => 2, 'name' => '塩、加工塩等', 'sort_no' => 2],
            ['id' => 61, 'primary_category_id' => 13, 'secondary_id' => 3, 'name' => '香辛料（胡椒、スパイス、ナツメグ等）', 'sort_no' => 3],
            ['id' => 62, 'primary_category_id' => 13, 'secondary_id' => 4, 'name' => '砂糖、甜菜糖、ラカント等', 'sort_no' => 4],
            ['id' => 63, 'primary_category_id' => 13, 'secondary_id' => 5, 'name' => '醤油、しょうゆ加工品', 'sort_no' => 5],
            ['id' => 64, 'primary_category_id' => 13, 'secondary_id' => 6, 'name' => '料理酒', 'sort_no' => 6],
            ['id' => 65, 'primary_category_id' => 13, 'secondary_id' => 7, 'name' => 'みりん', 'sort_no' => 7],
            ['id' => 66, 'primary_category_id' => 13, 'secondary_id' => 8, 'name' => '酢、ぽん酢', 'sort_no' => 8],
            ['id' => 67, 'primary_category_id' => 13, 'secondary_id' => 9, 'name' => '味噌', 'sort_no' => 9],
            ['id' => 68, 'primary_category_id' => 13, 'secondary_id' => 10, 'name' => 'だし、つゆ', 'sort_no' => 10],
            ['id' => 69, 'primary_category_id' => 13, 'secondary_id' => 11, 'name' => 'マヨネーズ', 'sort_no' => 11],
            ['id' => 70, 'primary_category_id' => 13, 'secondary_id' => 12, 'name' => 'ケチャップ', 'sort_no' => 12],
            ['id' => 71, 'primary_category_id' => 13, 'secondary_id' => 13, 'name' => 'ソース、たれ', 'sort_no' => 13],
            ['id' => 72, 'primary_category_id' => 13, 'secondary_id' => 14, 'name' => 'ドレッシング', 'sort_no' => 14],
            ['id' => 73, 'primary_category_id' => 13, 'secondary_id' => 15, 'name' => 'マーガリン', 'sort_no' => 15],
            ['id' => 74, 'primary_category_id' => 13, 'secondary_id' => 16, 'name' => 'その他（調味料、うまみ調味料等）', 'sort_no' => 16],
            ['id' => 75, 'primary_category_id' => 14, 'secondary_id' => 1, 'name' => 'その他（カテゴリなし）', 'sort_no' => 1],
        ]);
    }
}
