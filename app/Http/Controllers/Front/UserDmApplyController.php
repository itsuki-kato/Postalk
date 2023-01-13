<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserDmApplyRepository;
use Illuminate\Support\Facades\Auth;
use App\Common\Consts;

class UserDmApplyController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserDmApplyRepository $userDmApplyRepository
    )
    {
    }

    /**
     * DM申請一覧画面表示
     */
    public function show_dm_apply_list(Request $request)
    {
        $User = Auth::user();
        $user_id = $User->user_id;

        $UserDmApplies = $this->userDmApplyRepository->get_user_dm_apply_list($user_id);

        return view('user.dm_apply_list', compact('UserDmApplies'));
    }

    /**
     * DM申請
     */
    public function apply_dm(Request $request)
    {
        $User = Auth::user();

        $user_id       = $User->user_id;          //申請ユーザー
        $apply_user_id = $request->apply_user_id; //受理ユーザー

        $this->userDmApplyRepository->create_user_dm_apply($user_id, $apply_user_id, Consts::DM_APPLY_STATUS_APPLYING);
        return redirect('/dm_apply_list'); //とりあえず
    }

    /**
     * DM承認
     */
    public function approve_dm(Request $request)
    {
        $User = Auth::user();

        $user_id       = $request->apply_user_id; // 申請ユーザー
        $apply_user_id = $User->user_id;          // 承認ユーザー

        $this->userDmApplyRepository->update_user_dm_apply($user_id, $apply_user_id, Consts::DM_APPLY_STATUS_APPROVAL);
        return redirect('/dm_apply_list'); //とりあえず
    }

    /**
     * DM否認
     */
    public function deny_dm(Request $request)
    {
        $User = Auth::user();

        $user_id       = $request->apply_user_id; // 申請ユーザー
        $apply_user_id = $User->user_id;          // 否認ユーザー

        $this->userDmApplyRepository->update_user_dm_apply($user_id, $apply_user_id, Consts::DM_APPLY_STATUS_APPLYING);
        return redirect('/dm_apply_list'); //とりあえず
    }
}
