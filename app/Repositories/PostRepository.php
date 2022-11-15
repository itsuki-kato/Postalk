<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    /**
     * PostRepostioryConstructor
     *
     * @param UserCategoryRepository $userCategoryRepository
     */
    public function __construct(
        private UserCategoryRepository $userCategoryRepository
    )
    {}

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

    /**
     * タイムライン表示用にユーザーカテゴリに紐付いた投稿のCollectionを取得します。
     *
     * @param string $user_id
     * @return Post[] $Posts
     */
    public function getListForTimeLine($user_id)
    {
        $UserCategories = $this->userCategoryRepository->getList($user_id);

        $user_cateory_ids = [];
        foreach($UserCategories as $UserCategory)
        {
            // userに紐付いたcategory_idの配列。
            $user_cateory_ids[] = $UserCategory->category_id;
        }

        // user_categoryに紐付いた投稿を取得する。
        $Posts = Post::whereIn('category_id', $user_cateory_ids)
            ->orderBy('create_at', 'desc')
            ->get();

        return $Posts;
    }

    /**
     * 投稿の新規作成
     *
     * @param string $user_id
     * @param int $post_id
     * @param string $user_category_id
     * @param string $post_title
     * @param string $post_text
     * @param string $upload_post_img_url
     * @return void
     */
    public function create($user_id, $post_id, $user_category_id, $post_title, $post_text, $upload_post_img_url)
    {
        Post::create([
            'user_id'      => $user_id,
            'post_id'      => $post_id,
            'category_id'  => $user_category_id,
            'post_title'   => $post_title,
            'post_text'    => $post_text,
            'post_img_url' => $upload_post_img_url
        ]);

        logs()->info('登録が完了しました。'.$post_id, ['Front' => 'post.create']);

        return;
    }

    /**
     *投稿の編集
     *
     * @param string $post_id
     * @param string $user_category_id
     * @param int $post_title
     * @param string $post_text
     * @param string $upload_post_img_url
     * @return void
     */
    public function edit($post_id, $user_category_id, $post_title, $post_text, $upload_post_img_url)
    {
        Post::where('post_id', $post_id)
            ->update([
                'category_id'  => $user_category_id,
                'post_title'   => $post_title,
                'post_text'    => $post_text,
                'post_img_url' => $upload_post_img_url
            ]);

        logs()->info('編集が完了しました。'.$post_id, ['Front' => 'post.create']);

        return;
    }
}
