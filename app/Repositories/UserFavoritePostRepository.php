<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
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
     * @param string $user_id
     * @param string $favorite_user_id
     * @param string $favorite_post_id
     * @return void
     */
    public function favorite($user_id, $favorite_user_id, $favorite_post_id)
    {
        DB::beginTransaction();
        try
        {
            UserFavoritePost::create([
                'user_id' => $user_id,
                'favorite_user_id' => $favorite_user_id,
                'favorite_post_id' => $favorite_post_id,
                'favorite_type' => UserFavoritePost::TYPE_LIKE
            ]);

            DB::commit();
            logs()->info('お気に入り登録が完了しました。'.$favorite_post_id, ['Front' => 'post.favorite']);
        }
        catch (\Exception $e)
        {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);
            DB::rollBack();
        }

        return;
    }

}