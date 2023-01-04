<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\UserFollow;
use App\Services\NotifyService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserFollowRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserFollowController extends Controller
{
    /**
     * UserFollowController constructor
     * @param UserRepository       $userRepository
     * @param UserFollowRepository $userFollowRepository
     * @param NotifyService $notifyService
     */
    public function __construct(
        private UserRepository $userRepository,
        private UserFollowRepository $userFollowRepository,
        private NotifyService $notifyService,
    )
    {}

    /**
     * フォロー申請
     *
     * @param Request $request
     * @return void
     */
    public function apply(Request $request)
    {
        if(!$request->ajax()) { throw new BadRequestHttpException('不正なアクセスです。'); }

        $target_data = $request->target_data;
        $user_id = $target_data['user_id'];
        $follow_user_id = $target_data['follow_user_id'];

        // デバッグ用
        $follow_user_id = 21;

        // ユーザーが一致しなかったらログアウトさせる
        if(Auth::user()->id != $user_id) {
            return redirect('/logout');
        }

        // 複数テーブルに登録のため、外側でTransaction開始
        DB::beginTransaction();
        try {
            // フォロー申請
            $UserFollow = $this->userFollowRepository->apply($user_id, $follow_user_id);
            // フォロー申請通知作成
            $this->notifyService->dispatch($UserFollow);
        } catch(\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました'.$e);
            DB::rollBack();
        }


        return response()->json([
            'user_id'        => $user_id,
            'follow_user_id' => $follow_user_id,
            'follow_status'    => UserFollow::FOLLOW_APPLY
        ]);
    }

    /**
     * フォロー中にステータス変更
     * NOTE：フォロー申請されたユーザーがこの操作を行う。
     *
     * @param Request $request
     * @return void
     */
    public function permit(Request $request)
    {
        if(!$request->ajax()) { throw new BadRequestHttpException('不正なアクセスです。'); }

        $target_data = $request->target_data;
        $user_id = $target_data['user_id'];
        $follow_user_id = $target_data['follow_user_id'];

        // follow_user_idとログインユーザーが一致しなかったら操作させない
        if(Auth::user()->id != $follow_user_id) {
            return response()->json([
                'error' => 'ユーザーが異なるためフォロー許可できませんでした'
            ]);
        }

        // デバッグ用
        $follow_user_id = 21;

        $UserFollow = UserFollow::where([
            ['user_id', $user_id],
            ['follow_user_id', $follow_user_id]
        ])->first();

        // nullかフォロー申請中のステータスでない時は操作不可
        if(is_null($UserFollow) || ($UserFollow->follow_status != UserFollow::FOLLOW_APPLY)) {
            return response()->json([
                'error' => '操作不可のステータスです。'
            ]);
        }

        // 複数テーブルに登録のため、外側でTransaction開始
        DB::beginTransaction();
        try {
            // フォロー許可
            $this->userFollowRepository->permit($UserFollow);
            // フォロー申請通知作成
            $this->notifyService->dispatch($UserFollow);
        } catch(\Exception $e) {
            throwException($e);
            logs()->info('例外が発生しました'.$e);
            DB::rollBack();
        }


        return response()->json([
            'user_id'        => $user_id,
            'follow_user_id' => $follow_user_id,
            'follow_status'    => UserFollow::FOLLOW_APPLY
        ]);
    }

    /**
     * フォロー解除
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        if(!$request->ajax()) { throw new BadRequestHttpException('不正なアクセスです。'); }

        $target_data = $request->target_data;
        $user_id = $target_data['user_id'];
        $follow_user_id = $target_data['follow_user_id'];

        // デバッグ用
        $follow_user_id = 21;

        // ユーザーが一致しなかったらログアウトさせる
        if(Auth::user()->id != $user_id) {
            return redirect('/logout');
        }

        $this->userFollowRepository->delete($user_id, $follow_user_id);

        return response()->json([
            'user_id'        => $user_id,
            'follow_user_id' => null,
        ]);
    }
}
