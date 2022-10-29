<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Services\SampleService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     * @param SampleService $sampleService
     */
    public function __construct(
        private UserRepository $userRepository,
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
        // TODO: バリデーションの追加

        $user = $this->userRepository->get_user($request->user_id, $request->password);

        if (empty($user)) {
            return view('user/login')->with('error','ユーザーIDかパスワードが違います');
        }

        $this->set_user_session($user);
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
        // TODO: バリデーションの追加
        // TODO: SESSION削除
    }

    /**
     * ユーザー登録
     *
     * @param Request $request
     * @return void
     */
    public function create_user(Request $request)
    {
        // TODO: バリデーションの追加

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
        $user = $this->userRepository->get_user($user_id);
        // TODO: バリデーションの追加
        // TODO: 下記でSESSION保存してもgetで上手く取得できないので検証
        /*session(['user', [
            'user_id'    => $user->user_id
            'user_name'  => $user->user_name
            'email'      => $user->email,
            'sex'        => $user->sex,
            'birth'      => $user->birth,
            'address'    => $user->address,
            'pf_img_url' => $user->pf_img_url,
            'bg_img_url' => $user->bg_img_url,
            'intro_text' => $user->intro_text
        ]]);*/
    }

    /**
     * ユーザーセッション情報設定
     *
     * @param Object $user
     * @return void
     */
    public function set_user_session($user)
    {
        // TODO: バリデーションの追加
        // TODO: 下記でSESSION保存してもgetで上手く取得できないので検証
        /*session(['user', [
            'user_id'    => $user->user_id
            'user_name'  => $user->user_name
            'email'      => $user->email,
            'sex'        => $user->sex,
            'birth'      => $user->birth,
            'address'    => $user->address,
            'pf_img_url' => $user->pf_img_url,
            'bg_img_url' => $user->bg_img_url,
            'intro_text' => $user->intro_text
        ]]);*/
    }
}
