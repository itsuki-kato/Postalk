@extends('layouts.layout')

@section('content')
<h1>検索条件</h1>

{{ Form::open(['method'=>'get', 'url' => '/search']) }}
    <p>↓のラジオボタン選択でフォーム切り替えたい（ラジオボタンじゃなくてもいい）</p>
    @foreach(Consts::SEARCH_TYPE_LIST as $key => $val)
        <input type="radio" name="search_type" value={{$key}} {{$key == 0 ? 'checked' : ''}}>{{$val}}
    @endforeach
    <br>
    <br>
    <h3>ー－ユーザー検索ー－</h3>
    <table>
        <tr>
            <th>ユーザーID</th>
            <td><input type="text" name="user_id"></td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td><input type="text" name="user_name"></td>
        </tr>
        <tr>
            <th>性別*</th>
            <td>
                @foreach(Consts::SEX_LIST as $key => $val)
                    <input type="radio" name="sex" value={{$key}} {{$key == 0 ? 'checked' : ''}}>{{$val}}
                @endforeach
            </td>
        </tr>
        <tr>
            <th>年齢(まだ使えない)</th>
            <td><input type="number" name="age"></td>
        </tr>
        <tr>
            <th>居住地</th>
            <td><input type="text" name="address"></td>
        </tr>
    </table>
    <h3>ー－投稿検索ー－</h3>
    <table>
        <tr>
            <th>投稿タイトル</th>
            <td><input type="text" name="post_title"></td>
        </tr>
        <tr>
            <th>投稿内容</th>
            <td><input type="text" name="post_text"></td>
        </tr>
    </table>
    <button>検索</button>
{{ Form::close() }}

@endsection
