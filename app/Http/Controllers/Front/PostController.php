<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * PostController constructor
     * @param PostRepository
     */
    public function __construct(
        private PostRepository $postRepository
    )
    {}

    /**
     * 新規作成画面を表示します。
     *
     * @param Request $request
     * @return void
     */
    public function createIndex(Request $request)
    {
        return view('post.index');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        // 入力値に対してのバリデーションを行う。

        Post::create($request->all());

        return view('');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function editIndex($post_id)
    {
        $Post = Post::find($post_id);

        if(!$Post) { throw new NotFoundHttpException(); }

        $User = $Post->user();

        // dd($Post);
        return view('');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request)
    {
        $Post = Post::create($request->all());
        // dd($Post);
        return [];
    }

    /**
     * 入力値と、リレーションで保持しているModelのバリデーションを行います。
     *
     * @param Post $Post
     * @return void
     */
    // private function valid(Post $Post)
    // {
    //     if($Post->create_at) // 編集の場合
    //     {
    //         // 保持しているModelの存在チェック。
    //         $User =
    //     }
    //     $validator = Validator::make($request->all(), [
    //         ''
    //     ]);
    // }
}
