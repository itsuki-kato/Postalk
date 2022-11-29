<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserCategoryRepository;

class UserCategoryController extends Controller
{
    /**
     * UserCategoryController constructor
     */
    public function __construct(
        private UserCategoryRepository $userCategoryRepository,
    )
    {}

    /**
     * カテゴリ選択
     *
     * @param Request $request
     * @return void
     */
    public function select_category(Request $request)
    {
        $this->set_select_category_session($request->category_id);

        return redirect('/user/mypage');
    }

    /**
     * カテゴリ一覧セッション初期化
     *
     * @param string $user_id
     * @return void
     */
    public function init_category_list_session($user_id)
    {
        $user_category_list = $this->userCategoryRepository->get_user_category_list($user_id);

        foreach($user_category_list as $index => $user_category){
            session()->put('user_category_list.'.$index, [
                'category_id' => $user_category->category_id
            ]);
        }
    }

    /**
     * 選択中カテゴリセッション設定
     *
     * @param string $category_id
     * @return void
     */
    public function set_select_category_session($category_id)
    {
        session()->put('user_select_category', $category_id);
    }

}
