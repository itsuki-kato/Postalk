<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{

    /**
     * NOTE：post_idはユーザーごとに管理する？
     * int型にキャストしたpost_idのmaxを取得します。
     *
     * @param string $user_id
     * @return int $max_id
     */
    public function getMaxId($user_id)
    {
        $max_id = DB::table('t_user_post')
            ->where('user_id', $user_id)
            ->orderBy('post_id', 'desc')
            ->value('post_id');

        // 未登録の場合は0を返す。
        if(!$max_id)
        {
            return 0;
        }

        return (int)$max_id;
    }
}
