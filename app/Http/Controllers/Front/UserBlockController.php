<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserBlockRepository;

class UserBlockController extends Controller
{
    /**
     * UserBlockController constructor
     */
    public function __construct(
        private UserRepository $userRepository,
        private UserBlockRepository $userBlockRepository,
    )
    {}

    /**
     * ブロック一覧セッション初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_block_list_session($user_id)
    {
        $user_block_list = $this->userBlockRepository->get_user_block_list($user_id);

        // ブロック中のユーザー情報取得
        // TODO: メソッド分け
        $block_user_id_list = array();
        foreach ($user_block_list as $user_block) {
            $block_user_id_list[] = $user_block->block_user_id;
        }
        $user_list = $this->userRepository->get_user_list($block_user_id_list);

        foreach($user_block_list as $index => $user_block){
            foreach ($user_list as $user){
                // ブロックしていないユーザーはスルー
                if ($user_block->block_user_id !== $user->user_id){
                    continue;
                }
                session()->put('user_block_list.'.$index, [
                    'user_id'    => $user_block->user_id,
                    'user_name'  => $user->user_name,
                    'pf_img_url' => $user->pf_img_url
                ]);
            }
        }
    }
}
