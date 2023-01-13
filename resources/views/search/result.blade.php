@extends('layouts.layout')

@section('content')

    <h1>検索結果</h1>
    <br>

    @if(!empty($Users))
        <table>
            <tr>
                <th>プロフィール画像</th>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
            </tr>
            @foreach($Users as $user)
                {{ Form::open(['method'=>'get', 'url' => '/other_user']) }}
                <tr>
                    <td><img class="mypage-profile-img" src="{{$user->pf_img_url}}" height="300" width="900"></td>
                    <td><a href="{{route('user.index', ['user_id' => $user->user_id])}}">{{$user->user_id}}</a></td>
                    <td>{{$user->user_name}}</td>
                </tr>
                {{ Form::close() }}
            @endforeach
        </table>
    @elseif(!empty($Posts))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>投稿タイトル</th>
                <th>投稿内容</th>
            </tr>
        @foreach($Posts as $Post)
            <tr>
                <td>{{$Post->user_id}}</td>
                <td>{{$Post->post_title}}</td>
                <td>{{$Post->post_text}}</td>
            </tr>
        @endforeach
    </table>
    @else
        検索結果なし
    @endif

@endsection
