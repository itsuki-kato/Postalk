@extends('layouts.layout')

@section('content')
    <h1>プロフィール</h1>
    <br>

    {{ Form::open(['url' => '/update_profile', 'files' => true]) }}
    <table>
        <tr>
            <th>ユーザー名</th>
            <td><input type="text" name="user_name" value="{{Auth::user()->user_name}}"></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><input type="email" name="email" value="{{Auth::user()->email}}"></td>
        </tr>
        <tr>
            <th>住所</th>
            <td><input type="text" name="address" value="{{Auth::user()->address}}"></td>
        </tr>
        <tr>
            <th>プロフィール画像</th>
            <td>
                <input type="file" name="pf_img">
                <input type="hidden" name="old_pf_img_url" value="{{Auth::user()->pf_img_url}}">
            </td>
        </tr>
        <tr>
            <th>背景画像</th>
            <td>
                <input type="file" name="bg_img">
                <input type="hidden" name="old_bg_img_url" value="{{Auth::user()->bg_img_url}}">
            </td>

        </tr>
        <tr>
            <th>自己紹介文</th>
            <td>
                <textarea name="intro">
                    {{Auth::user()->intro}}
                </textarea>
            </td>
        </tr>
    </table>
    <button>更新</button>
    {{ Form::close() }}

@endsection
