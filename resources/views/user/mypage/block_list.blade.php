@extends('layouts.layout')

@section('content')

    <h1>ブロック一覧</h1>
    <br>

    @if(!empty(session('user_block_list')))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>プロフィール画像</th>
            </tr>
            @foreach(session('user_block_list') as $user_block)
                {{ Form::open(['url' => 'user/unblock']) }}
                <tr>
                    <td>
                        <a href="{{$user_block['user_id']}}">{{$user_block['user_id']}}</a>
                        <input type="hidden" name="block_user_id" value={{$user_block['user_id']}}>
                    </td>
                    <td>{{$user_block['user_name']}}</td>
                    <td>{{$user_block['pf_img_url']}}</td>
                    <td><button>ブロック解除</button></td>
                </tr>
                {{ Form::close() }}
            @endforeach
        </table>
    @else
        ブロックしていません
    @endif

@endsection
