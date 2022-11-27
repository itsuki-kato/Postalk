<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Categoryモデルとの接続を担当します。
 * returnはModelかModelの配列かCollectionを返してください。
 */
class UserFollowRepository
{
    /**
     * ユーザーフォロー情報一覧取得
     *
     * @return Objcect $user_follow_list
    */
    public function get_user_follow_list($user_id)
    {
        $user_follow_list = DB::table('t_user_follow')->where('user_id', $user_id)->get();

        return $user_follow_list;
    }

    /**
     * ユーザーフォロー情報一覧取得
     *
     * @return Objcect $user_follow_list
    */
    public function get_user_follower_list($user_id)
    {
        $user_follower_list = DB::table('t_user_follow')->where('follow_user_id', $user_id)->get();

        return $user_follower_list;
    }

    /**
     * ユーザーフォロー情報登録
     *
     * @return Objcect $user_follow_list
    */
    public function create_user_follow($user_id, $follow_user_id)
    {
        DB::beginTransaction();

        try {
            DB::table('t_user_follow')->insert([
                'user_id'        => $user_id,
                'follow_user_id' => $follow_user_id
            ]);

            DB::commit();
        } catch (Throwable $e) {
            // TODO:エラーメッセージ出力
            DB::rollBack();
        }
    }

    /**
     * ユーザーフォロー情報削除
     *
     * @return Objcect $user_follow_list
    */
    public function delete_user_follow($user_id, $follow_user_id)
    {
        DB::beginTransaction();

        try {
            DB::table('t_user_follow')
            ->where('user_id', $user_id)
            ->where('follow_user_id', $follow_user_id)
            ->delete();

            DB::commit();
        } catch (Throwable $e) {
            // TODO:エラーメッセージ出力
            DB::rollBack();
        }
    }
}
