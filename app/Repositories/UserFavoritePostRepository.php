<?php

namespace App\Repositories;

use App\Models\UserFavoritePost;
use Illuminate\Support\Facades\DB;

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
     * ユーザーのお気に入り投稿一覧を返します
     *
     * @param int $user_id
     * @return UserFavoritePost[] $UserFavoritePosts
     */
    public function getList($user_id)
    {
        $UserFavoritePosts = UserFavoritePost::where('user_id', $user_id)->get();

        return $UserFavoritePosts;
    }

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
            ['post_id', '=', $post_id],
            ['user_id', '=', $user_id],
            ['favorite_user_id', '=', $favorite_user_id]
        ])->first();

        DB::beginTransaction();
        try
        {
            if(is_null($UserFavoritePost)) // お気に入り登録されていなかったら登録
            {
                UserFavoritePost::create([
                    'post_id'               => $post_id,
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
            throw new Exception('例外が発生しました。'.$e, 1);
            
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
                ['post_id', '=', $post_id],
                ['user_id', '=', $user_id],
                ['favorite_user_id', '=', $favorite_user_id]
            ])->delete();

            logs()->info('お気に入り削除が完了しました。'.$post_id, ['Front' => 'post.favorite']);

            DB::commit();
        }
        catch (\Exception $e)
        {
            throw new Exception('例外が発生しました。'.$e, 1);
            
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
            ['post_id', '=', $post_id]
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