@extends('layouts.layout')

@section('content')

    <h1>フォロワー一覧</h1>
    <br>

    @if(!empty(session('user_follower_list')))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>プロフィール画像</th>
            </tr>
            @foreach(session('user_follower_list') as $user_follower)
                <tr>
                    <td><a href="{{$user_follower['user_id']}}">{{$user_follower['user_id']}}</a></td>
                    <td>{{$user_follower['user_name']}}</td>
                    <td>{{$user_follower['pf_img_url']}}</td>
                </tr>
            @endforeach
        </table>
    @else
        フォローされていません
    @endif

@endsection
