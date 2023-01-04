<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserNotifyRepository;
use App\Services\NotifyService;
use Illuminate\Support\Facades\Auth;

class UserNotifyController extends Controller
{
    /**
     * NotifyController constructor
     */
    public function __construct(
        private UserNotifyRepository $userNotifyRepository,
        private NotifyService $notifyService,
    )
    {}

    /**
     * 未読通知一覧表示
     *
     * @return void
     */
    public function unreadList()
    {
        $UserNotifies = $this->userNotifyRepository->getUnreadList(Auth::user()->id);

        return view('notify.list', compact('UserNotifies'));
    }

    /**
     * 既読通知一覧表示
     *
     * @return void
     */
    public function readList()
    {
        $UserNotifies = $this->userNotifyRepository->getReadList(Auth::user()->id);

        return view('notify.list', compact('UserNotifies'));
    }

    /**
     * 既読
     *
     * @param Request $request
     * @return void
     */
    public function read(Request $request)
    {
        
    }
}
