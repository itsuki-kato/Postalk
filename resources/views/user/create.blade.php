@extends('layouts.layout')

@section('content')
    {{ Form::open(['url' => '/create']) }}
    <table>
        <tr>
            <th>ユーザーID*</th>
            <td><input type="text" name="user_id" required></td>
        </tr>
        <tr>
            <th>ユーザー名*</th>
            <td><input type="text" name="user_name" required></td>
        </tr>
        <tr>
            <th>パスワード*</th>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <th>メールアドレス*</th>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <th>性別*</th>
            <td>
                @foreach(UserConst::SEX_LIST as $key => $val)
                    <input type="radio" name="sex" value={{$key}} {{$key == 0 ? 'checked' : ''}}>{{$val}}
                @endforeach
            </td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td><input type="date" name="birth"></td>
        </tr>
        <tr>
            <th>住所</th>
            <td><input type="text" name="address"></td>
        </tr>
    </table>
    <button>登録</button>
    {{ Form::close() }}

    @if(!empty($error))
        <p>{{$error}}</p>
    @endif

@endsection
