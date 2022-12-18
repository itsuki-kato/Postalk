@extends('layouts.layout')

@section('content')
    <div class="block-mypage">
        <div class="d-flex mypage-profile-box border rounded">
            <div class="">
                <img class="mypage-profile-img" src="{{Storage::url(session('user.bg_img_url'))}}" height="300" width="900">
            </div>
            <div class="">
                <div class="">
                    <span class="">ユーザー名</span>
                </div>
                    <div class="">
                        <button type="button" id="follow-btn" data-user-id="{{ session('user.user_id') }}" data-follow-user-id="" class="btn btn-outline-primary">Follow</button>
                    </div>
            </div>
        </div>
        <br>
        <br>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active"
                id="profile-tab"
                data-bs-toggle="tab"
                data-bs-target="#profile"
                type="button"
                role="tab"
                aria-controls="profile"
                aria-selected="true"
                >
                Profile
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                class="nav-link"
                id="category-tab"
                data-bs-toggle="tab"
                data-bs-target="#category"
                type="button"
                role="tab"
                aria-controls="category"
                aria-selected="false"
                >
                MyCategory
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                class="nav-link"
                id="favorite_post-tab"
                data-bs-toggle="tab"
                data-bs-target="#favorite_post"
                type="button"
                role="tab"
                aria-controls="favorite_post"
                aria-selected="false"
                >
                FavoritePost
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                class="nav-link"
                id="follow-tab"
                data-bs-toggle="tab"
                data-bs-target="#follow"
                type="button"
                role="tab"
                aria-controls="follow"
                aria-selected="false"
                >
                Follow
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                class="nav-link"
                id="follower-tab"
                data-bs-toggle="tab"
                data-bs-target="#follower"
                type="button"
                role="tab"
                aria-controls="follower"
                aria-selected="false"
                >
                Follower
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
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
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- プロフィールタブのコンテンツ -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <p>ー－－プロフィールー－－</p>
                <table>
                    <tr>
                        <th>ユーザーID：</th>
                        <td>{{session('user.user_id')}}</td>
                    </tr>
                    <tr>
                        <th>ユーザー名：</th>
                        <td>{{session('user.user_name')}}</td>
                    </tr>
                    <tr>
                        <th>メールアドレス：</th>
                        <td>{{session('user.email')}}</td>
                    </tr>
                    <tr>
                        <th>性別：</th>
                        @foreach(Consts::SEX_LIST as $key => $val)
                            @if ($key == session('user.sex'))
                                <td>{{$val}}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th>誕生日：</th>
                        <td>{{session('user.birth')}}</td>
                    </tr>
                    <tr>
                        <th>住所：</th>
                        <td>{{session('user.address')}}</td>
                    </tr>
                    <tr>
                        <th>プロフィール画像：</th>
                        <td><img src="{{Storage::url(session('user.pf_img_url'))}}" height="100" width="100"></td>
                    </tr>
                    <tr>
                        <th>背景画像：</th>
                        <td><img src="{{Storage::url(session('user.bg_img_url'))}}" height="300" width="900"></td>
                    </tr>
                    <tr>
                        <th>自己紹介文：</th>
                        <td>{{session()->get('user.intro_text')}}</td>
                    </tr>
                </table>
            </div>

            <!-- マイカテゴリタブのコンテンツ -->
            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                <p>ー－－マイカテゴリー－－</p>
                @if(!empty(session('user_category_list')))
                    @foreach(session('user_category_list') as $user_category)
                        {{ Form::open(['url' => 'user/select_category']) }}
                            @if(!empty(session('user_select_category')) && session('user_select_category') == $user_category['category_id'])
                                <button style="background-color:yellow">{{$user_category['category_id']}}</button>
                            @else
                                <button>{{$user_category['category_id']}}</button>
                            @endif
                            <input type="hidden" name="category_id" value={{$user_category['category_id']}}>
                        {{ Form::close() }}
                    @endforeach
                @else
                    カテゴリがありません
                @endif
            </div>

            <!-- お気に入り投稿タブのコンテンツ -->
            <div class="tab-pane fade" id="favorite_post" role="tabpanel" aria-lazelledby="favorite_post-tab">
                <p>お気に入り投稿一覧</p>
            </div>

            <!-- フォロー一覧タブのコンテンツ -->
            <div class="tab-pane fade" id="follow" role="tabpanel" aria-labelledby="follow-tab">
                <p>フォロー一覧</p>
                <table>
                    <tr>
                        <th>フォロー数：</th>
                        <td>
                            @if(!empty(session('user_follow_list')))
                                {{count(session('user_follow_list'))}}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>フォロワー数：</th>
                        <td>
                            @if(!empty(session('user_follower_list')))
                                {{count(session('user_follower_list'))}}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- フォロワータブのコンテンツ -->
            <div class="tab-pane fade" id="follower" role="tabpanel" aria-labelledby="follower-tab">
                <p>フォロワー一覧</p>
                <table>
                    <tr>
                        <th>フォロー数：</th>
                        <td>
                            @if(!empty(session('user_follow_list')))
                                {{count(session('user_follow_list'))}}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>フォロワー数：</th>
                        <td>
                            @if(!empty(session('user_follower_list')))
                                {{count(session('user_follower_list'))}}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- DMタブのコンテンツ -->
            <div class="tab-pane fade" id="dm" role="tabpanel" aria-labelledby="dm-tab">
                <p>DM一覧</p>
            </div>
        </div>
    </div>
@endsection
