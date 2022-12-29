<?php

namespace App\Http\Controllers\Front;

use App\Common\MessageConsts;
use App\Models\User;
use App\Models\Post;
use App\Models\UserFavoritePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserCategoryRepository;
use App\Repositories\UserFavoritePostRepository;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function profileIndex() {
        return view('user.mypage.profile');
    }
}
