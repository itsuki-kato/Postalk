<?php

namespace App\Services;

use App\Models\UserNotify;
use App\Models\UserFollow;
use App\Models\UserFavoritePost;
use App\Repositories\UserNotifyRepository;

class NotifyService
{
    public function __construct(
        private UserNotifyRepository $userNotifyRepository,
    )
    {}

    /**
     * 作成する通知レコードの判定と登録
     * 
     * @param object $Object
     * @return void
     */
    public function dispatch(object $Object)
    {
        switch($Object) {
            case($Object instanceof(UserFollow::class)): // フォロー申請、フォロー許可通知の作成
                $this->userNotifyRepository->createUserFollowNotify($Object->user_id, $Object->id);
                break;
            case($Object instanceof(UserFavoritePost::class)): // 投稿いいね通知
                $this->userNotifyRepository->createFavoritePostNotify($Object->user_id, $Object->id);
                break;
            default:
                // Nothing
                break;
        }

        return;
    }

    /**
     * 既読処理
     *
     * @return void
     */
    public function read()
    {
        return[];
    }
}