<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

//use App\Http\Controllers\Front\Controller;
class UserController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository $userRepository
    )
    {
        $this->UserCategoryController = app()->make('App\Http\Controllers\Front\UserCategoryController');
        $this->UserFollowController   = app()->make('App\Http\Controllers\Front\UserFollowController');
        $this->UserBlockController    = app()->make('App\Http\Controllers\Front\UserBlockController');
        //$this->UserDmApplyController  = app()->make('App\Http\Controllers\Front\UserDmApplyController');
    }

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
        $this->UserCategoryController->init_category_list_session($user->user_id);
        $this->UserFollowController->init_follow_list_session($user->user_id);
        $this->UserFollowController->init_follower_list_session($user->user_id);
        $this->UserBlockController->init_block_list_session($user->user_id);
        //$this->UserDmApplyController->init_dm_list_session($user->user_id);

        return redirect('/user/mypage');
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
        ||  empty($request->repassword)
        ||  empty($request->email)
        ) {
            return view('user/create')->with('error','未入力の項目があります');
        }

        if ($request->password !== $request->repassword) {
            return view('user/create')->with('error','パスワードが一致しません');
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

        $this->init_user_session($user->user_id);
        $this->UserCategoryController->init_category_list_session($user->user_id);

        return redirect('/user/mypage');
    }

    /**
     * ユーザー更新
     *
     * @param Request $request
     * @return void
     */
    public function update_user(Request $request)
    {
        $user_id    = session('user.user_id');
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

        return redirect('/user/mypage');
    }

    /**
     * ユーザーセッション情報初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_user_session($user_id)
    {
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
}
