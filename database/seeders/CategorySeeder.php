<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_category')->insert([
            [
                'category_name' => 'スポーツ'
            ],
            [
                'category_name' => '観戦・観賞'
            ],
            [
                'category_name' => '集める'
            ],
            [
                'category_name' => '旅行・出かける'
            ],
            [
                'category_name' => 'グルメ・料理'
            ],
            [
                'category_name' => 'アウトドア'
            ],
            [
                'category_name' => '作る'
            ],
            [
                'category_name' => '育てる'
            ],
            [
                'category_name' => '美容・ライフ'
            ],
            [
                'category_name' => '音楽'
            ],
            [
                'category_name' => '芸術・鑑賞'
            ],
            [
                'category_name' => '踊る・ダンス'
            ],
            [
                'category_name' => '遊ぶ・特技'
            ],
            [
                'category_name' => '考える・ゲーム'
            ],
            [
                'category_name' => '学ぶ'
            ],
            [
                'category_name' => '稼ぐ'
            ],
            [
                'category_name' => 'その他'
            ],
            [
                'category_name' => 'ギター'
            ],
            [
                'category_name' => 'プログラミング'
            ],
            [
                'category_name' => '映画'
            ],
            [
                'category_name' => '読書'
            ],
            [
                'category_name' => 'アニメ'
            ],
            [
                'category_name' => '漫画'
            ],
            [
                'category_name' => 'スノボ'
            ],
            [
                'category_name' => 'カフェ巡り'
            ],
            [
                'category_name' => 'フィルムカメラ'
            ],
            [
                'category_name' => '一眼レフ'
            ],
            [
                'category_name' => '料理'
            ],
            [
                'category_name' => '家事'
            ],
            [
                'category_name' => '出会い系'
            ],
            [
                'category_name' => '趣味
                '
            ],
            [
                'category_name' => '観葉植物'
            ],
            [
                'category_name' => 'DIY'
            ],
            [
                'category_name' => 'ファッション'
            ],
            [
                'category_name' => 'お菓子作り'
            ],
            [
                'category_name' => '虫取り'
            ],
            [
                'category_name' => '鉄道'
            ],
            [
                'category_name' => 'K-POP'
            ],
            [
                'category_name' => '邦楽'
            ],
            [
                'category_name' => '洋楽'
            ],
            [
                'category_name' => 'お酒'
            ],
            [
                'category_name' => '山登り'
            ],
            [
                'category_name' => 'キャンプ'
            ],
            [
                'category_name' => '釣り'
            ],
            [
                'category_name' => '顔パネル'
            ],
            [
                'category_name' => '美術館巡り'
            ],
            [
                'category_name' => '喫茶店'
            ],
            [
                'category_name' => 'タバコ'
            ],
        ]);
    }
}
