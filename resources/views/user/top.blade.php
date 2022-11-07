@extends('layouts.layout')

@section('content')
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

    <br>
    <p>ー－－マイカテゴリー－－</p>
    @foreach(session('user_category_list') as $user_category)
    {{ Form::open(['url' => request()->path().'/select_category']) }}

        @if(!empty(session('user_select_category')) && session('user_select_category') == $user_category['category_id'])
            <button style="background-color:yellow">{{$user_category['category_id']}}</button>
        @else
            <button>{{$user_category['category_id']}}</button>
        @endif
        <input type="hidden" name="category_id" value={{$user_category['category_id']}}>

    {{ Form::close() }}
    @endforeach

    <br>
    <p>ー－－画面遷移ー－－</p>
    <li><a href={{request()->path()."/edit"}}>プロフィール編集</a></li>
    <li><a href="/logout">ログアウト</a></li>

@endsection
