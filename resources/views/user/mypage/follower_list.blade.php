@extends('user.mypage.mypage_header')

@section('mypage_content')

    <h1>フォロワー一覧</h1>
    <br>

    @if(!empty($UserFollows))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
            </tr>
            @foreach($UserFollows as $UserFollow)
                <tr>
                    <td>{{ $UserFollow->user->user_id }}</td>
                    <td>{{ $UserFollow->user->user_name }}</td>
                </tr>
            @endforeach
        </table>
    @else
        フォロワーはいません
    @endif

@endsection
