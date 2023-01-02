@extends('layouts.layout')

@section('content')
    <div class="block-mypage">
        <div class="ajax_error_message"></div>
        <div class="d-flex mypage-profile-box border rounded">
            <div class="">
                <img class="mypage-profile-img" src="{{Storage::url(session('user.bg_img_url'))}}" height="300" width="900">
            </div>
            <div class="">
                <div class="">
                    <span class="">ユーザー名</span>
                </div>
                <div class="">
                    <button type="button" id="follow-apply-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー申請</button>
                </div>
                <div class="">
                    <button type="button" id="follow-permit-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー許可</button>
                </div>
                <div class="">
                    <button type="button" id="follow-delete-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー解除</button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.profileIndex') }}">
                    <button class="nav-link active">
                        Profile
                    </button>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.userCategoryList') }}">
                    <button class="nav-link active">
                        MyCategory
                    </button>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.favoritePostList') }}">
                    <button class="nav-link active">
                        FavoritePost
                    </button>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.followList') }}">
                    <button class="nav-link active">
                        Follow
                    </button>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.followerList') }}">
                    <button class="nav-link active">
                        Follower
                    </button>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('mypage.dmList') }}">
                    <button class="nav-link active">
                        DM
                    </button>
                </a>
                <!-- <button
                class="nav-link"
                id="dm-tab"
                data-bs-toggle="tab"
                data-bs-target="#dm"
                type="button"
                role="tab"
                aria-controls="dm"
                aria-selected="false"
                >
                DM
                </button> -->
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            @yield('mypage_content')
        </div>
    </div>
@endsection
