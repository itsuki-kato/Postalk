@extends('layouts.layout')

@section('content')
    @if(!empty($User))
        <table>
            <tr>
                <th>プロフィール画像</th>
                <td>
                    @if(empty($User->pf_img_url))
                        <img class="mypage-profile-img" src="{{Storage::url($User->pf_img_url)}}" height="300" width="900">
                    @else
                        <img class="mypage-profile-img" src="{{Storage::url($User->pf_img_url)}}" height="300" width="900">
                    @endif
                </td>
            </tr>
            <tr>
                <th>ユーザー名</th>
                <td>{{$User->user_name}}</td>
            </tr>
            <tr>
                <th>ユーザーID</th>
                <td>{{$User->user_id}}</td>
            </tr>
            <tr>
                <th>自己紹介文</th>
                <td>{{$User->intro}}</td>
            </tr>
            <tr>
                <th>フォロー関連</th>
                <td>
                    <button type="button" id="follow-apply-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー申請</button>
                    <button type="button" id="follow-permit-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー許可</button>
                    <button type="button" id="follow-delete-btn" data-user-id="{{ Auth::user()->id }}" data-follow-user-id="" class="btn btn-outline-primary">フォロー解除</button>
                    ※まだ反応しない（エラー出るんゴ）
                </td>
            </tr>
            <tr>
                {{ Form::open(['url' => '/apply_dm']) }}
                    <th>DM申請関連</th>
                    <td>
                        <input type="hidden" name="apply_user_id" value="{{$User->id}}">
                        <button>DM申請</button>
                    </td>
                {{ Form::close() }}
            </tr>
        </table>
    @else
        存在しないユーザーです。
    @endif
@endsection
