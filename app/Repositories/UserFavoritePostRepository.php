<?php

namespace App\Repositories;

use App\Models\UserFavoritePost;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

class UserFavoritePostRepository
{
    /**
     * UserFavoritePostRepostioryConstructor
     *
     * @param UserCategoryRepository $userCategoryRepository
     */
    public function __construct(
    )
    {}

    /**
     * 投稿をお気に入り登録します。
     * 
     * @param string $post_id
     * @param string $user_id
     * @param string $favorite_user_id
     * @return void
     */
    public function favorite($user_id, $favorite_user_id, $post_id)
    {
        $UserFavoritePost = UserFavoritePost::where([
            ['id', '=', $post_id],
            ['user_id', '=', $user_id],
            ['favorite_user_id', '=', $favorite_user_id]
        ])->first();

        DB::beginTransaction();
        try
        {
            if(is_null($UserFavoritePost)) // お気に入り登録されていなかったら登録
            {
                UserFavoritePost::create([
                    'id'               => $post_id,
                    'user_id'          => $user_id,
                    'favorite_user_id' => $favorite_user_id,
                    'favorite_type'    => UserFavoritePost::TYPE_LIKE
                ]);

                logs()->info('お気に入り登録が完了しました。'.$post_id, ['Front' => 'post.favorite']);

                DB::commit();
            }
        }
        catch (\Exception $e)
        {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);
            DB::rollBack();
        }

        return;
    }

    /**
     * お気に入り登録を削除します。
     *
     * @param string $post_id
     * @param string $user_id
     * @param string $favorite_user_id
     * @return void
     */
    public function removeFavorite($user_id, $favorite_user_id, $post_id)
    {
        
        DB::beginTransaction();
        try
        {
            // NOTE：primaryKey複数＋中間テーブルだとEloquentのdelete()が使用できない
            DB::table('t_user_favorite_post')->where([
                ['id', '=', $post_id],
                ['user_id', '=', $user_id],
                ['favorite_user_id', '=', $favorite_user_id]
            ])->delete();

            logs()->info('お気に入り削除が完了しました。'.$post_id, ['Front' => 'post.favorite']);

            DB::commit();
        }
        catch (\Exception $e)
        {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);
            DB::rollBack();
        }

        return;
    }

    /**
     * お気に入り登録されているかどうかを判断します。
     *
     * @param string $user_id
     * @param string $favorite_user_id
     * @param string $post_id
     * @return bool $exists
     */
    public function exists($user_id, $favorite_user_id, $post_id)
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