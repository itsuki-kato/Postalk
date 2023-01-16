<?php

namespace App\Repositories;

use App\Models\UserDmApply;
use Illuminate\Support\Facades\DB;

class UserDmApplyRepository
{
    /**
     * DM申請一覧取得(他->自分)
    */
    public function get_user_dm_apply_list_to_me($user_id)
    {
        $UserDmApplyListToMe = UserDmApply::where('apply_user_id', $user_id)->get();

        return $UserDmApplyListToMe;
    }

    /**
     * DM申請一覧取得(自分->他)
    */
    public function get_user_dm_apply_list_to_other($user_id)
    {
        $UserDmApplyListToOther = UserDmApply::where('user_id', $user_id)->orget();

        return $UserDmApplyListToOther;
    }

    /**
     * DM申請一覧取得
    */
    public function get_user_dm_apply_list($user_id, $apply_status = null)
    {
        $query = UserDmApply::where('user_id', $user_id)->orWhere('apply_user_id', $user_id);

        if (!empty($apply_status)) {
            $query = $query->where('apply_status', $apply_status);
        }

        $UserDmApplyListToOther = $query->get();

        return $UserDmApplyListToOther;
    }

    /**
     * DM申請登録
    */
    public function create_user_dm_apply($user_id, $apply_user_id, $apply_status)
    {
        DB::beginTransaction();
        try {
            UserDmApply::create([
                'user_id'       => $user_id,
                'apply_user_id' => $apply_user_id,
                'apply_status'  => $apply_status,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('例外が発生しました。'.$e, 1);
        }
    }

    /**
     * DM申請更新
    */
    public function update_user_dm_apply($user_id, $apply_user_id, $apply_status)
    {
        DB::beginTransaction();
        try {
            UserDmApply::where('user_id', $user_id)->where('apply_user_id', $apply_user_id)->update(['apply_status' => $apply_status]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('例外が発生しました。'.$e, 1);
        }
    }
}
