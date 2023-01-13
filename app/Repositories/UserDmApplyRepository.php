<?php

namespace App\Repositories;

use App\Models\UserDmApply;
use Illuminate\Support\Facades\DB;

class UserDmApplyRepository
{
    /**
     * DM申請一覧取得
    */
    public function get_user_dm_apply_list($user_id)
    {
        // パワープレイ
        $User = DB::table('t_user')->where('user_id', $user_id)->first();
        $user_id = $User->id;

        $UserDmApplyList = UserDmApply::where('user_id',$user_id)->get();

        return $UserDmApplyList;
    }

    /**
     * DM申請登録
    */
    public function create_user_dm_apply($user_id, $apply_user_id, $apply_status)
    {
        // パワープレイ
        $User = DB::table('t_user')->where('user_id', $user_id)->first();
        $user_id = $User->id;
        $ApplyUser = DB::table('t_user')->where('user_id', $apply_user_id)->first();
        $apply_user_id = $ApplyUser->id;

        DB::beginTransaction();
        try {
            UserDmApply::create([
                'user_id'       => $user_id,
                'apply_user_id' => $apply_user_id,
                'apply_status'  => $apply_status,
            ]);
        }
        catch (\Exception $e) {
            throw new \Exception('例外が発生しました。'.$e, 1);
            logs()->info('例外が発生しました。'.$e);
        }
        return;
    }

    /**
     * DM申請更新
    */
    public function update_user_dm_apply($user_id, $apply_user_id, $apply_status)
    {
        // PP
        $User = DB::table('t_user')->where('user_id', $user_id)->first();
        $user_id = $User->id;
        $ApplyUser = DB::table('t_user')->where('user_id', $apply_user_id)->first();
        $apply_user_id = $ApplyUser->id;

        DB::beginTransaction();
        try {
            UserDmApply::create([
                'user_id'       => $user_id,
                'apply_user_id' => $apply_user_id,
                'apply_status'  => $apply_status,
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
