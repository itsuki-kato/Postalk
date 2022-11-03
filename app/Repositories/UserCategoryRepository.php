<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\UserCategory;
use Illuminate\Support\Facades\DB;

class UserCategoryRepository
{
    /**
     * Userに紐付いたカテゴリの連想配列を返します。
     *
     * @param string $user_id
     * @return array $user_category_list [category_id => cagegory_name]
     */
    public function getList($user_id)
    {
        if(!$user_id) { return []; }

        // userに紐付いたカテゴリidだけの配列を取得。
        $user_categoriy_ids = DB::table('t_user_category')
            ->where('user_id', $user_id)
            ->pluck('category_id');

        $user_category_list = [];
        foreach($user_categoriy_ids as $user_category_id)
        {
            // カテゴリidからカテゴリ名を取得。
            $category_neme = DB::table('m_category')
                ->where('category_id', $user_category_id)
                ->value('category_name');

            // [cateogry_id => category_name]の形式に整形。
            $user_category_list[$user_category_id] = $category_neme;
        }

        return $user_category_list;
    }
}
