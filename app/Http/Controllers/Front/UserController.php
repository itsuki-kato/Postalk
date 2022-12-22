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
     * プロフィール更新
     *
     * @param Request $request
     * @return void
     */
    public function update_profile(Request $request)
    {
        $user_id    = Auth::user()->user_id;
        $user_name  = null;
        $email      = null;
        $address    = null;
        $pf_img_url = $request->old_pf_img_url;
        $bg_img_url = $request->old_bg_img_url;
        $intro = null;

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
        if (!empty($request->intro)) {
            $intro = $request->intro;
        }

        $this->userRepository->update_user(
            $user_id,
            $user_name,
            $email,
            $address,
            $pf_img_url,
            $bg_img_url,
            $intro
        );

        //$this->init_user_session($user_id);

        return redirect('/');
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
