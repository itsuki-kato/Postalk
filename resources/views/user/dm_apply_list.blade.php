@extends('layouts.layout')

@section('content')
    <h1>DM申請中一覧</h1>

    @if(!$UserDmApplies->isEmpty())
        <table>
            @foreach($UserDmApplies as $UserDmApply)
                @if($UserDmApply->user_id === Auth::user()->id)
                    <tr>
                        <th>ユーザーID：</th>
                        <td>{{$UserDmApply->user_id}}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @else
        申請中のユーザーはいません<br>※判断ロジックおかしい
    @endif
    <br>
    <br>
    <h1>DM承認待ちユーザー一覧</h1>
    @if(!$UserDmApplies->isEmpty())
        <table>
            @foreach($UserDmApplies as $UserDmApply)
                @if($UserDmApply->apply_user_id === Auth::user()->id)
                    <tr>
                        <th>ユーザーID：</th>
                        <td>{{$UserDmApply->user_id}}</td>
                        <td>
                            {{ Form::open(['url' => '/approve_dm']) }}
                                <button>承認</button>
                                <input type="hidden" name="apply_user_id" value="{{$UserDmApply->user_id}}">
                            {{ Form::close() }}
                        </td>
                        <td>
                            {{ Form::open(['url' => '/deny_dm']) }}
                            <button>否認</button>
                            <input type="hidden" name="apply_user_id" value="{{$UserDmApply->user_id}}">
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    @else
        承認待ちのユーザーはいません<br>※判断ロジックおかしい
    @endif
@endsection
