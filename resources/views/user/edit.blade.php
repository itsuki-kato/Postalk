@extends('layouts.layout')

@section('content')
    {{ Form::open(['url' => request()->path(), 'files' => true]) }}
    <table>
        <tr>
            <th>ユーザー名</th>
            <td><input type="text" name="user_name" value={{session('user.user_name')}}></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><input type="email" name="email" value={{session('user.email')}}></td>
        </tr>
        <tr>
            <th>住所</th>
            <td><input type="text" name="address" value={{session('user.address')}}></td>
        </tr>
        <tr>
            <th>プロフィール画像</th>
            <td>
                <input type="file" name="pf_img">
                <input type="hidden" name="old_pf_img_url" value="{{!empty(session('user.pf_img_url')) ? session('user.pf_img_url') : ''}}">
            </td>

        </tr>
        <tr>
            <th>背景画像</th>
            <td>
                <input type="file" name="bg_img">
                <input type="hidden" name="old_bg_img_url" value="{{!empty(session('user.bg_img_url')) ? session('user.bg_img_url') : ''}}">
            </td>

        </tr>
        <tr>
            <th>自己紹介文</th>
            <td>
                <textarea name="intro_text">
                    {{session()->get('user.intro_text')}}
                </textarea>
            </td>
        </tr>
    </table>
    <button>更新</button>
    {{ Form::close() }}

@endsection