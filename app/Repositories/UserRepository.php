<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Userモデルとの接続を担当します。
 * returnはModelかModelの配列かCollectionを返してください。
 */
class UserRepository
{
    /**
     * ユーザー情報一覧取得
     *
     * @return User $user_list
    */
    public function get_user_list($user_id_list = null)
    {
        if (empty($user_id_list)) {
            $user_list = DB::table('t_user')->get();
        } else {
            $user_list = DB::table('t_user')->whereIn('user_id', $user_id_list)->get();
        }

        return $user_list;
    }

    /**
     * ユーザー情報一覧取得(検索用)
     *
     * @return User $user_list
    */
    public function get_user_list_for_search($user_id = null, $user_name = null, $sex = null, $age = null, $address = null)
    {
		// todo: カテゴリでフィルタリング

        $query = DB::table('t_user');
        if (!empty($user_id)) {
            $query = $query->where('user_id', 'LIKE', '%'.$user_id.'%');
        }
        if (!empty($user_name)) {
            $query = $query->where('user_name', 'LIKE', '%'.$user_name.'%');
        }
        if (!empty($sex)) {
            $query = $query->where('sex', $sex);
        }
        /*if (!empty($user_id)) {
            $query = $query->where('age', $age);
        }*/
        if (!empty($address)) {
            $query = $query->where('address', $address);
        }

        $user_list = $query->get();

        return $user_list;
    }

    /**
     * ユーザー情報取得
     *
     * @param string $user_id
     * @param string $password
     * @return User $user
    */
    public function get_user($user_id, $password = null)
    {
        // TODO: パワープレーしない
        if (!empty($password)) {
            $user = DB::table('t_user')
            ->select('user_id')
            ->where('user_id', $user_id)
            ->where('password', $password)
            ->first();
        } else {
            $user = DB::table('t_user')
            ->select(
                'id',
                'user_id',
                'user_name',
                'email',
                'sex',
                'birth',
                'address',
                'pf_img_url',
                'bg_img_url',
                'intro'
            )
            ->where('user_id', $user_id)
            ->first();
        }

        return $user;
    }

    /**
     * ユーザー情報登録
     *
     * @param string $user_id
     * @param string $user_name
     * @param string $password
     * @param string $email
     * @param string $sex
     * @param int    $birth
     * @param string $address
     * @return void
    */
    public function create_user($user_id, $user_name, $password, $email, $sex, $birth = null, $address = null)
    {
        // TODO: passwordの暗号化
        // TODO: try-catch,transactionの記述箇所検討
        try {
            DB::beginTransaction();

            DB::table('t_user')->insert([
                'user_id'   => $user_id,
                'user_name' => $user_name,
                'password'  => $password,
                'email'     => $email,
                'sex'       => $sex,
                'birth'     => $birth,
                'address'   => $address,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            // TODO:エラーメッセージ出力
            DB::rollBack();
        }
    }

    /**
     * ユーザー情報更新
     *
     * @param string $user_id
     * @param string $user_name
     * @param string $password
     * @param string $email
     * @param string $sex
     * @param int    $birth
     * @param string $address
     * @return void
    */
    public function update_user($user_id, $user_name, $email, $address = null, $pf_img_url = null, $bg_img_url = null, $intro = null)
    {
        // TODO: try-catch,transactionの記述箇所検討
        try {
            DB::beginTransaction();

            DB::table('t_user')->where('user_id', $user_id)->update([
                'user_name'  => $user_name,
                'email'      => $email,
                'address'    => $address,
                'pf_img_url' => $pf_img_url,
                'bg_img_url' => $bg_img_url,
                'intro' => $intro,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            // TODO:エラーメッセージ出力
            DB::rollBack();
        }
    }
}
