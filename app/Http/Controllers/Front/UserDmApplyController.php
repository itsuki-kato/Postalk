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
        $UserDmApplies = $this->userDmApplyRepository->get_user_dm_apply_list(Auth::user()->id);

        // Viewで扱いやすいように分割
        $UserDmAppliesToMe     = array();
        $UserDmAppliesToOther  = array();
        $UserDmAppliesComplete = array();

        foreach ($UserDmApplies as $UserDmApply) {

            if ($UserDmApply->apply_status === Consts::DM_APPLY_STATUS_APPROVAL) {

                $UserDmAppliesComplete[] = $UserDmApply;

            } else if ($UserDmApply->apply_user_id == Auth::user()->id) {

                $UserDmAppliesToMe[] = $UserDmApply;

            } else if ($UserDmApply->user_id == Auth::user()->id) {

                $UserDmAppliesToOther[] = $UserDmApply;

            }
        }

        //var_dump($UserDmAppliesComplete);

        return view('user.dm_apply_list', compact('UserDmAppliesToMe', 'UserDmAppliesToOther', 'UserDmAppliesComplete'));
    }

    /**
     * DM申請
     */
    public function apply_dm(Request $request)
    {
        $this->userDmApplyRepository->create_user_dm_apply(Auth::user()->id, $request->apply_user_id, Consts::DM_APPLY_STATUS_APPLYING);

        return redirect('/dm_apply_list');
    }

    /**
     * DM承認
     */
    public function approve_dm(Request $request)
    {
        $this->userDmApplyRepository->update_user_dm_apply($request->apply_user_id, Auth::user()->id, Consts::DM_APPLY_STATUS_APPROVAL);

        return redirect('/dm_apply_list');
    }

    /**
     * DM否認
     */
    public function deny_dm(Request $request)
    {
        $this->userDmApplyRepository->update_user_dm_apply(Auth::user()->id, $request->apply_user_id, Consts::DM_APPLY_STATUS_DENY);

        return redirect('/dm_apply_list');
    }
}
