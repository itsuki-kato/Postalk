@extends('layouts.layout')

@section('content')

    <h1>フォロー一覧</h1>
    <br>

    @if(!empty(session('user_follow_list')))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>プロフィール画像</th>
            </tr>
            @foreach(session('user_follow_list') as $user_follow)
                {{ Form::open(['url' => 'user/unfollow']) }}
                <tr>
                    <td>
                        <a href="{{$user_follow['user_id']}}">{{$user_follow['user_id']}}</a>
                        <input type="hidden" name="follow_user_id" value={{$user_follow['user_id']}}>
                    </td>

                    <td>{{$user_follow['user_name']}}</td>
                    <td>{{$user_follow['pf_img_url']}}</td>
                    <td><button>フォロー解除</button></td>
                </tr>
                {{ Form::close() }}
            @endforeach
        </table>
    @else
        フォローしていません
    @endif

@endsection
