<?php

namespace App\Repositories;

use App\Models\UserFollow;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

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
     * @param string $user_id
     * @param string $follow_user_id
    */
    public function create_user_follow($user_id, $follow_user_id)
    {
        $UserFollow = UserFollow::where([
            ['id', '=', $user_id],
            ['follow_user_id', '=', $follow_user_id],
        ])->first();

        DB::beginTransaction();
        try
        {
            if(is_null($UserFollow)) // フォローしていなかったら登録する
            {
                UserFollow::create([
                    'id'             => $user_id,
                    'follow_user_id' => $follow_user_id
                ]);
    
                DB::commit();
                logs()->info('ユーザーフォローが完了しました。'.$follow_user_id);
            }
        }
        catch (\Exception $e)
        {
            throwException($e);
            logs()->info('例外が発生しました'.$e);
            DB::rollBack();
        }

        return;
    }

    /**
     * ユーザーフォロー情報削除
     *
     * @param int $user_id
     * @param int $follow_user_id
     * @return void
    */
    public function delete_user_follow($user_id, $follow_user_id)
    {
        $UserFollow = UserFollow::where(
            ['id', '=', $user_id],
            ['follow_user_id', '=', $follow_user_id]
        )->get();

        // フォローされていなかったらreturn
        if(!$UserFollow) {
            logs()->info('フォローしていないためフォロー解除できませんでした。');
            return;
        }

        DB::beginTransaction();
        try {
            DB::table('t_user_follow')
                ->where('user_id', $user_id)
                ->where('follow_user_id', $follow_user_id)
                ->delete();

            DB::commit();
            logs()->info('フォロー解除が完了しました');
        } catch (\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);
            
            DB::rollBack();
        }
    }

    /**
     * フォローしているかどうかを判断します。
     *
     * @param string $user_id
     * @param string $favorite_user_id
     * @param string $post_id
     * @return bool $exists
     */
    public function isFollower($user_id, $favorite_user_id, $post_id)
    {
        $UserFavoritePost = UserFavoritePost::where([
            ['user_id', '=', $user_id],
            ['favorite_user_id', '=', $favorite_user_id],
            ['id', '=', $post_id]
        ])->first();

        if($UserFavoritePost) // お気に入り登録されていた場合
        {
            return true;
        }
        else // お気に入り登録されていなかった場合
        {
            return false;
        }
    }
}
