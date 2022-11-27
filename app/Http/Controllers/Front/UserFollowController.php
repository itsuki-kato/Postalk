<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserFollowRepository;

class UserFollowController extends Controller
{
    /**
     * UserFollowController constructor
     * @param UserRepository       $userRepository
     * @param UserFollowRepository $userFollowRepository
     */
    public function __construct(
        private UserRepository $userRepository,
        private UserFollowRepository $userFollowRepository,
    )
    {}

    /**
     * フォロー
     *
     * @param Request $request
     * @return void
     */
    public function follow(Request $request)
    {
        $this->userFollowRepository->create_user_follow(session('user.user_id'), $request->follow_user_id);
        $this->init_follow_list_session(session('user.user_id'));

        return redirect('/user/mypage');
    }

    /**
     * フォロー解除
     *
     * @param Request $request
     * @return void
     */
    public function unfollow(Request $request)
    {
        $this->userFollowRepository->delete_user_follow(session('user.user_id'), $request->follow_user_id);
        $this->init_follow_list_session(session('user.user_id'));

        return redirect('/user/mypage');
    }

    /**
     * フォロー一覧セッション初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_follow_list_session($user_id)
    {
        $user_follow_list = $this->userFollowRepository->get_user_follow_list($user_id);

        // フォロー中のユーザー情報取得
        // TODO: メソッド分け
        $follow_user_id_list = array();
        foreach ($user_follow_list as $user_follow) {
            $follow_user_id_list[] = $user_follow->follow_user_id;
        }
        $user_list = $this->userRepository->get_user_list($follow_user_id_list);

        foreach($user_follow_list as $index => $user_follow){
            foreach ($user_list as $user){
                if ($user_follow->follow_user_id !== $user->user_id){
                    continue;
                }
                session()->put('user_follow_list.'.$index, [
                    'user_id'    => $user_follow->follow_user_id,
                    'user_name'  => $user->user_name,
                    'pf_img_url' => $user->pf_img_url
                ]);
            }
        }
    }

    /**
     * フォロワー一覧セッション初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_follower_list_session($user_id)
    {
        $user_follower_list = $this->userFollowRepository->get_user_follower_list($user_id);

        // フォロー中のユーザー情報取得
        // TODO: メソッド分け
        $follower_user_id_list = array();
        foreach ($user_follower_list as $user_follower) {
            $follower_user_id_list[] = $user_follower->user_id;
        }
        $user_list = $this->userRepository->get_user_list($follower_user_id_list);

        foreach($user_follower_list as $index => $user_follower){
            foreach ($user_list as $user){
                if ($user_follower->user_id !== $user->user_id){
                    continue;
                }
                session()->put('user_follower_list.'.$index, [
                    'user_id'    => $user_follower->user_id,
                    'user_name'  => $user->user_name,
                    'pf_img_url' => $user->pf_img_url
                ]);
            }
        }
    }
}
