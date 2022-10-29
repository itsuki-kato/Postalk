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
     * サンプルメソッド
     *
     * @return User $User
     */
    public function sample()
    {
        $User = DB::table('t_user')->first();

        return $User;
    }

    /**
     * ユーザー情報一覧取得
     *
     * @return User $user_list
    */
    public function get_user_list()
    {
        $user_list = DB::table('t_user')->get();

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
        // TODO: passwordの暗号化
        // TODO: パワープレーしない
        if (!empty($password)) {
            $user = DB::table('t_user')->where('user_id', $user_id)->where('password', $password)->first();
        } else {
            $user = DB::table('t_user')->where('user_id', $user_id)->first();
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
}
