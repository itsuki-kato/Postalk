<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Common\Consts;

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

    /**
     * 入力画面を表示します。
     *
     * @param Request $request
     */
    public function show_user(Request $request)
    {
        if (empty($request->user_id)) {
            redirect('/');
        }

        $User = $this->userRepository->get_user($request->user_id);
        return view('user.index', compact('User'));
    }

}
