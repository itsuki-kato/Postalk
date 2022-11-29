<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Blockモデルとの接続を担当します。
 * returnはModelかModelの配列かCollectionを返してください。
 */
class UserBlockRepository
{
    /**
     * ユーザーフォロー情報一覧取得
     *
     * @return Objcect $user_follow_list
    */
    public function get_user_block_list($user_id)
    {
        $user_block_list = DB::table('t_user_block')->where('user_id', $user_id)->get();

        return $user_block_list;
    }
}
