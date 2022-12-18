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
            ->orderBy('created_at', 'desc')
            ->get();

        return $Posts;
    }

    /**
     * 投稿の新規作成
     *
     * @param string $user_id
     * @param string $user_category_id
     * @param string $post_title
     * @param string $post_text
     * @param string $upload_post_img_url
     * @return void
     */
    public function create($user_id, $user_category_id, $post_title, $post_text, $upload_post_img_url)
    {
        DB::beginTransaction();
        try
        {
            Post::create([
                'user_id'      => $user_id,
                'category_id'  => $user_category_id,
                'post_title'   => $post_title,
                'post_text'    => $post_text,
                'post_img_url' => $upload_post_img_url
            ]);
            logs()->info('投稿の新規作成が完了しました。'. ['Front' => 'post.favorite']);

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
        DB::beginTransaction();
        try
        {
            Post::where('id', $post_id)
                ->update([
                    'category_id'  => $user_category_id,
                    'post_title'   => $post_title,
                    'post_text'    => $post_text,
                    'post_img_url' => $upload_post_img_url
            ]);
            logs()->info('投稿の編集が完了しました。'.$post_id.['Front' => 'post.favorite']);

            DB::commit();
        }
        catch (\Exception $e)
        {
            throwException($e);
            logs()->info('例外が発生しました。'.$e);
            DB::rollBack();
        }

        logs()->info('投稿の編集が完了しました。'.$post_id, ['Front' => 'post.create']);

        return;
    }
}
