<?php

namespace App\Repositories;

use App\Models\UserCategory;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

class UserCategoryRepository
{
    /**
     * Userに紐付いたカテゴリの連想配列を返します。
     *
     * @param string $user_id
     * @return array $user_category_list [category_id => cagegory_name]
     */
    public function getListForSelect($user_id)
    {
        if(!$user_id) { return []; }

        // userに紐付いたカテゴリidだけの配列を取得。
        $user_categoriy_ids = DB::table('t_user_category')
            ->where('user_id', $user_id)
            ->pluck('category_id');

        $user_category_list = [];
        foreach($user_categoriy_ids as $user_category_id) {
            // カテゴリidからカテゴリ名を取得。
           $category_neme = DB::table('m_category')
                ->where('id', $user_category_id)
                ->value('category_name');

            // [cateogry_id => category_name]の形式に整形。
            $user_category_list[$user_category_id] = $category_neme;
        }

        return $user_category_list;
    }

    /**
     * ユーザーに紐づくカテゴリのModelのCollectionを返します。
     *
     * @param [int] $user_id
     * @return UserCategory[] $UserCategories
     * */
    public function getList($user_id)
    {
        $UserCategories = UserCategory::where('user_id', $user_id)->get();

        return $UserCategories;
    }

    /**
     * ユーザーカテゴリ情報一覧取得
     *
     * @param string $user_id
     * @return Catgeory $user_category_list
    */
    public function get_user_category_list($user_id)
    {
        $user_category_list = DB::table('t_user_category')->where('user_id', $user_id)->get();

        return $user_category_list;
    }

    /**
     * マイカテゴリ更新
     *
     * @param int $user_id
     * @param array $category_id_list
     * @return void
    */
    public function updateUserCategory($user_id, $category_id_list)
    {
        DB::beginTransaction();
        try{
            // 更新前にすべてのマイカテゴリを削除して初期化する
            UserCategory::where('user_id', $user_id)->delete();

            foreach($category_id_list as $category_id) {
                UserCategory::create([
                    'user_id' => $user_id,
                    'category_id' => $category_id
                ]);

                logs()->info('マイカテゴリの更新が完了しました。カテゴリID:'.$category_id);
            }

            DB::commit();
        } catch(\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);

            DB::rollBack();
        }
    }
}
