<?php

namespace App\Repositories;

use App\Models\UserFavoritePost;
use App\Models\UserFollow;
use App\Models\UserNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\throwException;

class UserNotifyRepository
{
    public function getUnreadList($user_id)
    {
        $UserNotifies = UserNotify::where([
            ['user_id', $user_id],
            ['read_flg', UserNotify::UNREAD]
        ])->get();

        return $UserNotifies;
    }

    public function getReadList($user_id)
    {
        $UserNotifies = UserNotify::where([
            ['user_id', $user_id],
            ['read_flg', UserNotify::READ]
        ])->get();

        return $UserNotifies;
    }

    public function createUserFollowNotify($user_id, $follow_id)
    {
        UserNotify::create([
            'user_id' => $user_id,
            'follow_id' => $follow_id
        ]);

        logs()->info('フォロー通知作成完了しました。');

        return;
    }

    public function createFavoritePostNotify($user_id, $favorite_post_id)
    {
        UserFavoritePost::create([
            'user_id' => $user_id,
            'favorite_post_id' => $favorite_post_id
        ]);

        logs()->info('お気に入り登録通知作成完了しました。');

        return;
    }

    public function read()
    {
        return;
    }
}
