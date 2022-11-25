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
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function PHPUnit\Framework\throwException;

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
            'post_img_url.length' => 'max:100',
            ],
            [
                // エラーメッセージの定義。
                'post_title'   => MessageConsts::ERROR_POST_TITLE_REQUIRED,
                'post_text'    => MessageConsts::ERROR_POST_TEXT_REQUIRED,
                'post_img_url' => MessageConsts::ERROR_POST_IMG_FILE_TYPE,
                'post_img_url' => MessageConsts::ERROR_POST_IMG_LENGTH
            ]
        );

        if($validator->fails())
        {
            // エラーメッセージをsessionに保存してredirectする。
            return redirect('/post')
                ->withErrors($validator)
                ->withInput()
                ->with('flush_message', MessageConsts::ERROR_POST_SAVE);
        }

        if($mode === 'create') // 新規作成の場合
        {
            $this->create($request, $user_id);

            return redirect()
                ->route('post.index')
                ->with('flush_message', MessageConsts::POST_CREATE_COMPLETE);
        } else // 編集の場合
        {
            $this->edit($request);

            return redirect()
                ->route('post.editIndex', ['post_id' => $request->get('post_id')])
                ->with('flush_message', MessageConsts::POST_EDIT_COMPLETE);
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
        // 画像ファイル
        $post_img_file = $request->file('post_img_url');
        // 入力値
        $user_category_id = $request->get('user_category');
        $post_title = $request->get('post_title');
        $post_text = $request->get('post_text');

        // 現在登録されているpost_idのmaxを取得する。
        $max_post_id = $this->postRepository->getMaxId($user_id);
        $post_id = $max_post_id + 1;

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
                // 保存先パス名
                // TODO：storage配下に変更
                $target_path = 'post/'.$user_id;
                // ファイルアップロード
                $upload_post_img_url = $this->fileService->uploadImg($post_img_file, $target_path);
            }

            // DB保存
            $this->postRepository->create(
                $user_id,
                $post_id,
                $user_category_id,
                $post_title,
                $post_text,
                $upload_post_img_url
            );

            DB::commit();
        }
        catch(\Exception $e)
        {
            throwException($e);
            // TODO：例外発生時の画像アップロードはどうするか検討。
            logs()->error('例外が発生しました。'.$e);
            DB::rollBack();
        }

        return;
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
        $user_category_id = $request->get('user_category');
        $post_title = $request->get('post_title');
        $post_text = $request->get('post_text');
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
                // 保存先パス名
                $target_path = 'post/'.$user_id;
                // ファイルアップロード
                $upload_post_img_url = $this->fileService->uploadImg($post_img_file, $target_path);
            }

            // DB保存
            $this->postRepository->edit(
                $post_id,
                $user_category_id,
                $post_title,
                $post_text,
                $upload_post_img_url
            );

            DB::commit();
        }
        catch(\Exception $e)
        {
            throwException($e);
            // TODO：例外発生時の画像アップロードはどうするか検討。
            logs()->error('例外が発生しました。'.$e);
            DB::rollBack();
        }

        return;
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

        $user_id = 'ituki';

        // ajaxで送信されたuser_idとpost_idを配列で取得する。
        $target_data = $request->target_data;
        $favorite_user_id = $target_data['favorite_user_id'];
        $post_id = $target_data['favorite_post_id'];

        if(!Post::where('post_id', $post_id)->first())
        {
            // throw new NotFoundHttpException('投稿が見つかりませんでした。');
            return response()->json(['error' => '投稿が削除された可能性があります。']);
        }

        // TODO：退会してユーザー削除すると関連データも全部削除しないといけないので(面倒くさい)、論理削除希望
        if(!User::where('user_id', $favorite_user_id)->first())
        {
            // throw new NotFoundHttpException('投稿者が見つかりませんでした。');
            return response()->json(['error' => 'ユーザーが退会した可能性があります。']);
        }

        $this->userFavoritePostRepository->favorite($user_id, $favorite_user_id, $post_id);

        // front側でお気に入りボタンの色を変更する処理を追加する。
        return response()->json(['favorite_post_id' => $post_id]);
    }
}