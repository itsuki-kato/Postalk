<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;;
use App\Services\SampleService;
use App\Http\Controllers\Controller;
use App\Common\Consts;

class UserController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     * @param SampleService $sampleService
     */
    public function __construct(
        private UserRepository $userRepository,
        private CategoryRepository $CategoryRepository,
        private SampleService $sampleService
    )
    {}

    /**
     * ログイン
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        if (empty($request->user_id) || empty($request->password)) {
            return view('user/login')->with('error','ユーザーIDかパスワードがありません');
        }

        $user = $this->userRepository->get_user($request->user_id, $request->password);

        if (empty($user)) {
            return view('user/login')->with('error','ユーザーIDかパスワードが違います');
        }
        $this->init_user_session($user->user_id);
        $this->init_user_category_list_session($request->user_id);

        return redirect(route('user.top', [
            'user_id' => $user->user_id
        ]));
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    /**
     * ユーザー登録
     *
     * @param Request $request
     * @return void
     */
    public function create_user(Request $request)
    {
        if (
            empty($request->user_id)
        ||  empty($request->user_name)
        ||  empty($request->password)
        ||  empty($request->email)
        ) {
            return view('user/login')->with('error','未入力の項目があります');
        }

        $user_list = $this->userRepository->get_user_list();
        foreach($user_list as $user) {
            if ($user->user_id == $request->user_id) {
                return view('user/create')->with('error','使用されているユーザーIDです');
            }
            if ($user->email == $request->email) {
                return view('user/create')->with('error','登録済みのメールアドレスです');
            }
        }

        $this->userRepository->create_user(
            $request->user_id,
            $request->user_name,
            $request->password,
            $request->email,
            $request->sex,
            $request->birth,
            $request->address
        );

        // TODO: 別箇所にユーザー登録処理を記載。※下記は仮
        $this->CategoryRepository->create_user_category($request->user_id, "sport");
        $this->CategoryRepository->create_user_category($request->user_id, "comic");
        $this->CategoryRepository->create_user_category($request->user_id, "love");

        $this->init_user_session($request->user_id);
        $this->init_user_category_list_session($request->user_id);

        return redirect(route('user.top', [
            'user_id' => $request->user_id
        ]));
    }

    /**
     * ユーザー更新
     *
     * @param Request $request
     * @return void
     */
    public function update_user(Request $request)
    {
        $user_id    = $request->user_id;
        $user_name  = null;
        $email      = null;
        $address    = null;
        $pf_img_url = $request->old_pf_img_url;
        $bg_img_url = $request->old_bg_img_url;
        $intro_text = null;

        if (!empty($request->user_name)) {
            $user_name = $request->user_name;
        }
        if (!empty($request->email)) {
            $email = $request->email;
        }
        if (!empty($request->address)) {
            $address = $request->address;
        }
        if (!empty($request->pf_img)) {
            $pf_img_url = upload_file($request->file('pf_img'), Consts::DIR_PF_IMG, Consts::DISK_DEFAULT, $request->old_pf_img_url);
        }
        if (!empty($request->bg_img)) {
            $bg_img_url = upload_file($request->file('bg_img'), Consts::DIR_PF_IMG, Consts::DISK_DEFAULT, $request->old_bg_img_url);
        }
        if (!empty($request->intro_text)) {
            $intro_text = $request->intro_text;
        }

        $this->userRepository->update_user(
            $user_id,
            $user_name,
            $email,
            $address,
            $pf_img_url,
            $bg_img_url,
            $intro_text
        );

        $this->init_user_session($user_id);

        return redirect(route('user.top', [
            'user_id' => $request->user_id
        ]));
    }

    /**
     * ユーザーカテゴリ選択
     *
     * @param Request $request
     * @return void
     */
    public function select_user_category(Request $request)
    {
        $this->set_user_select_category_session($request->category_id);

        return redirect(route('user.top', [
            'user_id' => $request->user_id
        ]));
    }

    /**
     * ユーザーセッション情報初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_user_session($user_id)
    {
        session()->forget('user');

        $user = $this->userRepository->get_user($user_id);

        session()->put('user', [
            'user_id'    => $user->user_id,
            'user_name'  => $user->user_name,
            'email'      => $user->email,
            'sex'        => $user->sex,
            'birth'      => $user->birth,
            'address'    => $user->address,
            'pf_img_url' => $user->pf_img_url,
            'bg_img_url' => $user->bg_img_url,
            'intro_text' => $user->intro_text
        ]);
    }

    /**
     * ユーザーカテゴリ一覧セッション情報設定
     *
     * @param string $user_id
     * @return void
     */
    public function init_user_category_list_session($user_id)
    {
        $user_category_list = $this->CategoryRepository->get_user_category_list($user_id);

        foreach($user_category_list as $index => $user_category){
            session()->put('user_category_list.'.$index, [
                'category_id' => $user_category->category_id
            ]);
        }
    }

    /**
     * ユーザー選択カテゴリセッション情報設定
     *
     * @param string $category_id
     * @return void
     */
    public function set_user_select_category_session($category_id)
    {
        session()->put('user_select_category', $category_id);
    }
}
