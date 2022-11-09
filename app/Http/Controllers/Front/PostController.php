<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserCategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    /**
     * PostController constructor
     * @param PostRepository
     */
    public function __construct(
        private PostRepository $postRepository,
        private UserCategoryRepository $userCategoryRepository,
        private FileService $fileService
    )
    {}

    /**
     * タイムラインを表示します。
     */
    public function list()
    {
        // NOTE：デバッグ用。
        $user_id = 'ituki';
        $Posts = $this->postRepository->getListForTimeLine($user_id);

        return view('post.list', compact('Posts'));
    }

    /**
     * 入力画面を表示します。
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $Post = new Post();

        // NOTE：デバッグ用。
        $user_id = 'ituki';

        // セレクトボックス用のユーザーに紐付いたカテゴリの配列を取得。
        $user_category_list = $this->userCategoryRepository->getListForSelect($user_id);

        return view('post.index', compact('Post', 'user_category_list'));
    }

    /**
     * 編集画面を表示します。
     *
     * @param Request $request
     * @param string $post_id
     */
    public function editIndex(Request $request, $post_id)
    {
        $user_id = 'ituki';
        $Post = Post::where('post_id', $post_id)->first();

        $user_category_list = $this->userCategoryRepository->getListForSelect($user_id);

        return view('post.index', compact('Post', 'user_category_list'));
    }

    /**
     * 入力値に対してのバリデーションを行い、通過した場合は新規作成か編集をコールします。
     *
     * @param Request $request
     */
    public function valid(Request $request)
    {
        // NOTE：デバッグ用。
        $user_id = 'ituki';

        // create or edit
        $mode = $request->get('mode');

        $validator = Validator::make($request->all(), [
            // バリデーションルールの定義。
            'post_title'   => 'required',
            'post_text'    => 'required',
            'post_img_url.imagee' => 'image',
            'post_img_url.length' => 'max:30',
        ],
        [
            // エラーメッセージの定義。
            'post_title'   => 'タイトルを入力してください',
            'post_text'    => '本文を入力してください',
            'post_img_url' => 'ファイルは画像のみ選択できます。',
            'post_img_url' => 'ファイル名は30文字までです。'
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
            $this->create($request, $user_id);

            return redirect()
                ->route('post.index')
                ->with('flush_message', 'created!');
        }
        else // 編集の場合
        {
            $this->edit($request);

            return redirect()
                ->route('post.editIndex', ['post_id' => $request->get('post_id')])
                ->with('flush_message', 'updated!');
        }
    }

    /**
     * 投稿の新規作成を行います。
     *
     * @param Request $request
     * @param string $user_id
     * @return void
     */
    private function create(Request $request, $user_id)
    {
        // 入力値
        $user_category_id = $request->get('user_category');
        $post_title = $request->get('post_title');
        $post_text = $request->get('post_text');

        // 画像ファイル
        $post_img_file = $request->file('post_img_url');

        // ファイルアップロードとDB登録までを1トランザクションとする。
        DB::beginTransaction();
        try
        {
            // NOTE：画像アップロードは任意のため判定を行う。
            $upload_post_img_url = null;
            if($post_img_file)
            {
                // NOTE：デバッグ用。
                $user_id = 'ituki';
                // ファイルアップロード
                $upload_post_img_url = $this->fileService->uploadPostImg($user_id, $post_img_file);
            }

            // 現在登録されているpost_idのmaxを取得する。
            $max_post_id = $this->postRepository->getMaxId($user_id);
            $post_id = $max_post_id + 1;

            Post::create([
                'user_id'      => $user_id,
                'post_id'      => $post_id,
                'category_id'  => $user_category_id,
                'post_title'   => $post_title,
                'post_text'    => $post_text,
                'post_img_url' => $upload_post_img_url
            ]);

            DB::commit();
            logs()->info('登録が完了しました。'.$post_id, ['Front' => 'post.create']);
        }
        catch(\Exception $e)
        {
            // TODO：例外発生時の画像アップロードはどうするか検討。
            logs()->error('例外が発生しました。'.$e);
            DB::rollBack();
        }

    }

    /**
     * 編集内容の保存を行います。
     *
     * @param Request $request
     * @return void
     */
    private function edit(Request $request)
    {
        $user_id = 'ituki';
        $post_id = $request->get('post_id');
        $post_img_file = $request->file('post_img_url');

        // NOTE：画像アップロードは任意のため判定を行う。
        $upload_post_img_url = null;
        if($post_img_file)
        {
            // NOTE：デバッグ用。
            $user_id = 'ituki';
            // ファイルアップロード
            $upload_post_img_url = $this->fileService->uploadPostImg($user_id, $post_img_file);
        }

        Post::where('post_id', $post_id)
            ->update([
                'category_id'  => $request->get('user_category'),
                'post_title'   => $request->get('post_title'),
                'post_text'    => $request->get('post_text'),
                'post_img_url' => $upload_post_img_url
            ]);

        logs()->info('編集が完了しました。'.$post_id, ['Front' => 'post.edit']);

        return;
    }

}
