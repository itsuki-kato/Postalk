<?php

namespace App\Http\Controllers\Front;

use App\Common\MessageConsts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\UserCategoryRepository;
use App\Repositories\UserFavoritePostRepository;
use App\Repositories\UserFollowRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    /**
     * MypageController constructor
     * @param UserFollowRepository $userFollowRepository
     */
    public function __construct(
        private UserRepository $userRepository,
        private CategoryRepository $categoryRepository,
        private UserFavoritePostRepository $userFavoritePostRepository,
        private UserCategoryRepository $userCategoryRepository,
        private UserFollowRepository $userFollowRepository,
    )
    {}

    /**
    * プロフィール画面表示
    * 
    * @param Request $request
    */
    public function profileIndex(Request $request) {
        $User = Auth::user();
        return view('user.mypage.profile', compact('User'));
    }

    /**
     * プロフィール更新
     *
     * @param Request $request
     */
    public function update_profile(Request $request)
    {
        $user_id    = Auth::user()->user_id;
        $user_name  = null;
        $email      = null;
        $address    = null;
        $pf_img_url = $request->old_pf_img_url;
        $bg_img_url = $request->old_bg_img_url;
        $intro = null;

        if (!empty($request->user_name)) {
            $user_name = $request->user_name;
        }
        if (!empty($request->email)) {
            $email = $request->email;
        }
        if (!empty($request->address)) {
            $address = $request->address;
        }
        if (!empty($request->pf_img)) {
            $pf_img_url = upload_file($request->file('pf_img'), Consts::DIR_PF_IMG, Consts::DISK_DEFAULT, $request->old_pf_img_url);
        }
        if (!empty($request->bg_img)) {
            $bg_img_url = upload_file($request->file('bg_img'), Consts::DIR_PF_IMG, Consts::DISK_DEFAULT, $request->old_bg_img_url);
        }
        if (!empty($request->intro)) {
            $intro = $request->intro;
        }

        $this->userRepository->update_user(
            $user_id,
            $user_name,
            $email,
            $address,
            $pf_img_url,
            $bg_img_url,
            $intro
        );

        //$this->init_user_session($user_id);

        return redirect('/');
    }

    /**
     * カテゴリ一覧表示
     */
    public function userCategoryList()
    {
        $UserCategories = Auth::user()->userCategories;

        $user_category_id_list = [];
        foreach($UserCategories as $UserCategory) {
            $user_category_id_list[] = $UserCategory->category_id;
        }

        // マイカテゴリ以外のカテゴリ一覧を取得する
        $Categories = $this->categoryRepository->getListForMypage($user_category_id_list);

        return view('user.mypage.user_category_list', compact('UserCategories', 'Categories'));
    }

    /**
     * マイカテゴリ更新
     *
     * @param Request $request
     */
    public function updateUserCategory(Request $request)
    {
        $category_id_list = $request->get('category_ids');

        // フロント側で制御しているためここには入らないはずだが念の為チェックする
        if(is_null($category_id_list)) {
            return redirect()
                ->route('mypage.userCategoryList')
                ->with('flush_message', MessageConsts::ERROR_USER_CATEGORY_EMPTY);
        }

        $this->userCategoryRepository->updateUserCategory(Auth::user()->id, $category_id_list);

        return redirect()
            ->route('mypage.userCategoryList')
            ->with('flush_message', MessageConsts::USER_CATEGORY_UPDATE_COMPLETE);
    }

    /**
     * ユーザーのお気に入り投稿一覧表示
     *
     * @param Request $request
     */
    public function favoritePostList(Request $request)
    {
        $UserFavoritePosts = $this->userFavoritePostRepository->getList(Auth::user()->id);

        return view('user.mypage.favorite_post_list', compact('UserFavoritePosts'));
    }

    /**
     * フォローユーザー一覧表示
     * 
     * @param Request $request
     */
    public function followList()
    {
        $UserFollows = $this->userFollowRepository->get_user_follow_list(Auth::user()->id);

        return view('user.mypage.follow_list', compact('UserFollows'));
    }

    /**
     * フォロワーユーザー一覧取得
     *
     * @param Request $request
     */
    public function followerList()
    {
        $UserFollows = $this->userFollowRepository->get_user_follower_list(Auth::user()->id);

        return view('user.mypage.follower_list', compact('UserFollows'));
    }
}
