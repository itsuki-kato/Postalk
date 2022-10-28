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
}
