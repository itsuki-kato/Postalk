<?php

namespace App\Repositories;

use App\Models\UserFollow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * フォロー申請
     * 
     * @param string $user_id
     * @param string $follow_user_id
     * @return void
    */
    public function apply($user_id, $follow_user_id)
    {
        $UserFollow = UserFollow::where([
            ['user_id', '=', $user_id],
            ['follow_user_id', '=', $follow_user_id],
        ])->first();

        DB::beginTransaction();
        try {
            // フォローしていなかったら登録する
            if(is_null($UserFollow)) {
                UserFollow::create([
                    'user_id'        => $user_id,
                    'follow_user_id' => $follow_user_id,
                    'follow_status'    => UserFollow::FOLLOW_APPLY
                ]);
    
                DB::commit();
                logs()->info('フォロー申請が完了しました。'.$follow_user_id);
            }
        } catch (\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました'.$e);
            DB::rollBack();
        }

        return;
    }

    /**
     * フォロー許可
     *
     * @param UserFollow $UserFollow
     * @return void
     */
    public function permit(UserFollow $UserFollow)
    {
        // 最新のステータスを取得して比較する
        $isSameStatus = $this->compareCurrentStatus($UserFollow->id, $UserFollow->follow_status);

        try {
            if($isSameStatus) {
                UserFollow::where('id', $UserFollow->id)
                    ->update(['follow_status' => UserFollow::FOLLOW_PERMIT]);
                DB::commit();
                logs()->info('フォローを許可しました。'.'user_id:'.$UserFollow->user_id.',follow_user_id:'.$UserFollow->follow_user_id);
            } else {
                // TODO：フロント側への通知をどうするか検討する
                logs()->info('ステータスが異なるため許可できませんでした。'.'user_id:'.$UserFollow->user_id.',follow_user_id:'.$UserFollow->follow_user_id);
                return;
            }
        } catch (\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました'.$e);
            DB::rollBack();
        }
    }

    /**
     * フォロー解除(削除)
     *
     * @param int $user_id
     * @param int $follow_user_id
     * @return void
    */
    public function delete($user_id, $follow_user_id)
    {
        $UserFollow = UserFollow::where([
            ['user_id', $user_id],
            ['follow_user_id', $follow_user_id]
            ])->get();
            Log::debug("ここまで");

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

    /**
     * 最新のステータスを取得し、ステータスが一致していればtrueを返します。
     * NOTE：フォロー解除対策。
     *
     * @param int $user_follow_id
     * @param int $follow_status
     * @return bool $isSameStatus
     */
    private function compareCurrentStatus($user_follow_id, $follow_status)
    {
        $CurrentUserFollow = UserFollow::find($user_follow_id);

        if(is_null($CurrentUserFollow)) {
            return false;
        }
        if($CurrentUserFollow->follow_status != $follow_status) {
            return false;
        }

        return true;
    }
}
