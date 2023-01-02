@extends('user.mypage.mypage_header')

@section('mypage_content')
    <h1>お気に入り投稿一覧</h1>
    @foreach($UserFavoritePosts as $UserFavoritePost)
        <div class="border mb-5">
            <p>カテゴリ名：{{ $UserFavoritePost->post->category->category_name }}</p>
            <p>ユーザー名：{{ $UserFavoritePost->user->user_name }}</p>
            <p>タイトル：{{ $UserFavoritePost->post->post_title }}</p>
            <p>本文：{{ $UserFavoritePost->post->post_text }}</p>
        </div>
    @endforeach
@endsection
