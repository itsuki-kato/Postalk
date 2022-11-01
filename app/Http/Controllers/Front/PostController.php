<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserCategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * PostController constructor
     * @param PostRepository
     */
    public function __construct(
        private PostRepository $postRepository,
        private UserCategoryRepository $userCategoryRepository
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
        // ログイン中のユーザーを取得。
        $User = Auth::user();

        // TODO：middlewareで判定を行う。
        // if(is_null($User)) { return redirect()->route('/logout'); }

        // NOTE：デバッグ用。
        $user_id = 'ituki';
        // セレクトボックス用のユーザーに紐付いたカテゴリの配列を取得。
        $user_category_list = $this->userCategoryRepository->getList($user_id);
        // dd($user_category_list);

        return view('post.index')->with('user_category_list', $user_category_list);
    }

    /**
     * 投稿の新規作成を行います。
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        // 入力値に対してのバリデーションを行う。
        $this->valid($request);

        Post::create($request->all());

        return view('post.index');
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
        $this->valid($request);

        $Post = Post::create($request->all());
        // dd($Post);
        return [];
    }

    /**
     * 入力値に対してのバリデーションを行います。
     *
     * @param Request $request
     * @return void
     */
    private function valid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // バリデーションルールの定義。
            'category_id' => 'required',
            'post_title' => 'required',
            'post_text' => 'required',
            'post_img_url' => 'nullable'
        ],
        [
            // エラーメッセージの定義。
            'category_id.required'   => 'カテゴリを選択してください',
            'post_title.required'    => 'タイトルを入力してください',
            'post_text.required'     => '本文を入力してください'
        ]);

        // バリデーションを通過できなかった場合はエラーとともにリダイレクト。
        if($validator->fails())
        {
            // エラーメッセージをsessionに保存。
            return redirect('post.index')
                ->withErrors($validator)
                ->withInput();
        }

        return;
    }
}
