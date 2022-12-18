<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserFollowRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        if(!$request->ajax()) { throw new BadRequestHttpException('不正なアクセスです。'); }

        // TODO:渡されたユーザーIDとログインユーザーが一致しているか判定。

        $target_data = $request->target_data;
        $user_id = $target_data['user_id'];
        $follow_user_id = $target_data['follow_user_id'];

        // TODO:渡されたユーザーIDとログインユーザーが一致しているか判定。

        $this->userFollowRepository->create_user_follow($user_id, $follow_user_id);

        return response()->json([
            'user_id' => $user_id,
            'follow_user_id' => $follow_user_id
        ]);
    }

    /**
     * フォロー解除
     *
     * @param Request $request
     * @return void
     */
    public function unfollow(Request $request)
    {
        if(!$request->ajax()) { throw new BadRequestHttpException('不正なアクセスです。'); }

        $target_data = $request->target_data;
        $user_id = $target_data['user_id'];
        $follow_user_id = $target_data['follow_user_id'];

        // TODO:渡されたユーザーIDとログインユーザーが一致しているか判定。

        $this->userFollowRepository->delete_user_follow($user_id, $follow_user_id);

        return redirect('/user/mypage');
    }
}
