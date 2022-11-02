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
     * 入力画面を表示します。
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        // ログイン中のユーザーを取得。
        $User = Auth::user();

        // TODO：middlewareで判定を行う。
        // if(is_null($User)) { return redirect()->route('/logout'); }

        // NOTE：空のModel渡すの気持ち悪い。。
        $Post = new Post();

        // NOTE：デバッグ用。
        $user_id = 'ituki';

        // セレクトボックス用のユーザーに紐付いたカテゴリの配列を取得。
        $user_category_list = $this->userCategoryRepository->getList($user_id);

        return view('post.index', compact('Post', 'user_category_list'));
    }

    /**
     * 入力値に対してのバリデーションを行い、通過した場合は新規作成か編集をコールします。
     *
     * @param Request $request
     */
    public function valid(Request $request)
    {
        // create or edit
        $mode = $request->get('mode');

        $validator = Validator::make($request->all(), [
            // バリデーションルールの定義。
            'post_title' => 'required',
            'post_text' => 'required',
            'post_img_url' => 'nullable'
        ],
        [
            // エラーメッセージの定義。
            'post_title.required'    => 'タイトルを入力してください',
            'post_text.required'     => '本文を入力してください'
        ]);

        if($validator->fails())
        {
            // エラーメッセージをsessionに保存してredirectする。
            return redirect('/post')
                ->withErrors($validator)
                ->withInput()
                ->with('flush_message', '入力値に誤りがあるため保存できませんでした。');
        }

        if($mode === 'create') // 新規作成の場合
        {
            $this->create($request);
        }
        else // 編集の場合
        {
            $this->edit($request);
        }

        return redirect()
            ->route('post.index')
            ->with('flush_message', '保存が完了しました。');
    }

    /**
     * 投稿の新規作成を行います。
     *
     * @param Request $request
     * @return void
     */
    private function create(Request $request)
    {
        // TODO：ファイルアップロード処理

        Post::create($request->all());

        return redirect()->route('post.index')->with('result', 'done!');
    }

    /**
     * 編集内容の保存を行います。
     *
     * @param Request $request
     * @return void
     */
    private function edit(Request $request)
    {
        $this->valid($request);

        $Post = Post::create($request->all());
        // dd($Post);
        return [];
    }

}
