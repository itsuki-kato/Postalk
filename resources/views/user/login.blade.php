@extends('layouts.layout')

@section('content')
    {{ Form::open(['url' => '/login']) }}
    <table>
        <tr>
            <th>ユーザーID</th>
            <td><input type="text" name="user_id"></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" name="password"></td>
        </tr>
    </table>
    <button>ログイン</button>
    {{ Form::close() }}
    <a href="create">新規登録</a>

    @if(!empty($error))
    <p>{{$error}}</p>
    @endif

@endsection
