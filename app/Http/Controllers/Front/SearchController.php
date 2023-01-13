<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;
use App\Common\Consts;

//use App\Http\Controllers\Front\Controller;
class SearchController extends Controller
{
    /**
     * UserController constructor
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository $userRepository,
        private PostRepository $postRepository,
    )
    {
    }

    /**
     * 入力画面を表示します。
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        if (is_null($request->type)) {
            return view('search.index');
        }

        $search_type = $request->type;
        $Users = null;
        $Posts = null;

        if ($search_type == Consts::SEARCH_TYPE_USER) { // ユーザー検索
            $Users = $this->search_user(
                $request->user_id,
                $request->user_name,
                $request->sex,
                $request->age,
                $request->address,
            );
            if (empty($Users)) {
                return view('search.index');
            }
        } else if($search_type == Consts::SEARCH_TYPE_POST) { // 投稿検索
            $Posts = $this->search_post(
                $request->user_id,
                $request->post_title,
                $request->post_text,
            );
            if (empty($Posts)) {
                return view('search.index');
            }
        }

        return view('search.result', compact('Users', 'Posts'));
    }

    private function search_user($user_id = null, $user_name = null, $sex = null, $age = null, $address = null)
    {
        if (
            empty($user_id) &&
            empty($user_name) &&
            empty($sex) &&
            empty($age) &&
            empty($address)
        ) {
            return;
        }
        $Users = $this->userRepository->get_user_list_for_search($user_id, $user_name, $sex, $age, $address);

        return $Users;
    }

    private function search_post($user_id, $post_title = null, $post_text = null)
    {
        if (empty($post_title) && empty($post_text)) {
            return;
        }
        $Posts = $this->postRepository->getListForSearch($user_id, $post_title, $post_text);

        return $Posts;
    }
}
