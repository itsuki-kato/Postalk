<?php

namespace App\Http\Controllers\Front;

use App\Common\MessageConsts;
use App\Models\User;
use App\Models\Post;
use App\Models\UserFavoritePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserCategoryRepository;
use App\Repositories\UserFavoritePostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FileService;
use App\Services\NotifyService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * PostController constructor
     * @param PostRepository
     */
    public function __construct(
        private PostRepository $postRepository,
        private UserCategoryRepository $userCategoryRepository,
        private UserFavoritePostRepository $userFavoritePostRepository,
        private FileService $fileService,
        private NotifyService $notifyService
    )
    {}

    /**
     * タイムラインを表示します。
     */
    public function list()
    {
        $user_id = Auth::user()->id;
        $Posts = $this->postRepository->getListForTimeLine($user_id);

        return view('post.list', compact('user_id', 'Posts'));
    }

    /**
     * 入力画面を表示します。
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $Post = new Post();

        // セレクトボックス用のユーザーに紐付いたカテゴリの配列を取得。
        $user_category_list = $this->userCategoryRepository->getListForSelect(Auth::user()->id);

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
        $Post = Post::where('id', $post_id)->first();

        $user_category_list = $this->userCategoryRepository->getListForSelect(Auth::user()->id);

        return view('post.index', compact('Post', 'user_category_list'));
    }

    /**
     * 投稿の新規作成を行います。
     *
     * @param Request $post_request
     */
    public function store(Request $post_request)
    {
        $mode = $post_request->get('mode');
        $post_img_file = $post_request->file('post_img_url');
        $user_category_id = $post_request->get('user_category');
        $post_title = $post_request->get('post_title');
        $post_text = $post_request->get('post_text');

        // NOTE：画像アップロードは任意のため判定を行う。
        $upload_post_img_url = null;
        if($post_img_file) {
            // 保存先パス名
            $target_path = 'post/'.Auth::user()->id;
            // ファイルアップロード
            $upload_post_img_url = $this->fileService->uploadImg($post_img_file, $target_path);
        }

        if($mode === 'create') { // 新規作成
            // DB保存
            $this->postRepository->create(
                Auth::user()->id,
                $user_category_id,
                $post_title,
                $post_text,
                $upload_post_img_url
            );
    
            return redirect()
                ->route('post.index')
                ->with('flush_message', MessageConsts::POST_CREATE_COMPLETE);

        } else { // 編集
            $this->postRepository->edit(
                $post_request->get('post_id'),
                $user_category_id,
                $post_title,
                $post_text,
                $upload_post_img_url
            );

            return redirect()
                ->route('post.editIndex', ['post_id' => $post_request->get('post_id')])
                ->with('flush_message', MessageConsts::POST_EDIT_COMPLETE);
        }
    }

    /**
     * 投稿をユーザーのお気に入りに追加、削除します。
     *
     * @param Request $request
     * @return void
     */
    public function favorite(Request $request)
    {
        if(!$request->ajax()) { throw new BadRequestException('不正なアクセスです。'); }

        // ajaxで送信されたuser_idとpost_idを配列で取得する。
        $target_data = $request->target_data;
        $favorite_user_id = $target_data['favorite_user_id'];
        $post_id = $target_data['favorite_post_id'];

        if(!Post::where('id', $post_id)->first()) {
            return response()->json(['error' => '投稿が削除された可能性があります。']);
        }

        // TODO：退会してユーザー削除すると関連データも全部削除しないといけないので(面倒くさい)、論理削除希望
        if(!User::where('id', $favorite_user_id)->first()) {
            return response()->json(['error' => 'ユーザーが退会した可能性があります。']);
        }

        $exists = $this->userFavoritePostRepository->exists(Auth::user()->id, $favorite_user_id, $post_id);

        // お気に入り登録されていなかったら登録処理
        if($exists == false) {
            // 複数テーブルに登録のため、外側でTransaction開始
            DB::beginTransaction();
            try {
                // お気に入り登録
                $UserFavoritePost = $this->userFavoritePostRepository->favorite(Auth::user()->id, $favorite_user_id, $post_id);
                // お気に入り登録通知作成
                $this->notifyService->dispatch($UserFavoritePost);

                DB::commit();
            } catch(\Exception $e) {
                throw new Exception('例外が発生しました。'.$e, 1);
                logs()->info('例外が発生しました。'.$e);
                DB::rollBack();
            }
        } else {
            // お気に入り登録されていたら削除処理
            $this->userFavoritePostRepository->removeFavorite(Auth::user()->id, $favorite_user_id, $post_id);
        }

        // front側でお気に入りボタンの色を変更する処理を追加する。
        return response()->json([
            'favorite_post_id' => $post_id,
            'exists' => $exists
        ]);
    }
}