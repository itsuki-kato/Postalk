<?php

namespace App\Repositories;

use App\Models\Catgeory;
use Illuminate\Support\Facades\DB;

/**
 * Categoryモデルとの接続を担当します。
 * returnはModelかModelの配列かCollectionを返してください。
 */
class CategoryRepository
{
    /**
     * カテゴリ情報一覧取得
     *
     * @return Catgeory $category_list
    */
    public function get_category_list()
    {
        $category_list = DB::table('m_category')->get();

        return $category_list;
    }

    /**
     * カテゴリ情報登録
     *
     * @param int    $category_id
     * @param string $category_name
     * @return void
    */
    public function create_category($category_id, $category_name)
    {
        // TODO: try-catch,transactionの記述箇所検討
        try {
            DB::beginTransaction();

            DB::table('m_category')->insert([
                'category_id'   => $category_id,
                'category_name' => $category_name,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            // TODO:エラーメッセージ出力
            DB::rollBack();
        }
    }
}
