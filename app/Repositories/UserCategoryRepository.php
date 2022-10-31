<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\UserCategory;
use Illuminate\Support\Facades\DB;

/**
 * UserCategoryモデルとの接続を担当します。
 */
class UserCategoryRepository
{
    /**
     * Userに紐付いたカテゴリの連想配列を返します。
     *
     * @param User $User
     * @return array $array [category_id => cagegory_name]
     */
    public function getList($User)
    {
        $UserCategories = DB::table('t_user_category')
            ->where('user_id', '=', $User->user_id)
            ->get();

        $array = [];
        // TODO：おそらく遅いので他のやり方を検討する。
        foreach($UserCategories as $UserCategory)
        {
            $category_neme = DB::table('m_category')
                ->select('category_name')
                ->where('category_id', '=', $UserCategory->category_id)
                ->get();

            $array[$UserCategory->category_id] = $category_neme;
        }

        return $array;
    }
}
