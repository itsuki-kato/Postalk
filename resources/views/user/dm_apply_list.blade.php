@extends('layouts.layout')

@section('content')
    <h1>DM申請中一覧</h1>

    @if(!empty($UserDmAppliesToOther))
        <table>
            @foreach($UserDmAppliesToOther as $UserDmApply)
                <tr>
                    <th>ユーザーID：</th>
                    <td>{{$UserDmApply->apply_user_id}}</td>
                </tr>
            @endforeach
        </table>
    @else
        申請中のユーザーはいません
    @endif
    <br>
    <br>
    <h1>DM承認待ちユーザー一覧</h1>
    @if(!empty($UserDmAppliesToMe))
        <table>
            @foreach($UserDmAppliesToMe as $UserDmApply)
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
            @endforeach
        </table>
    @else
        承認待ちのユーザーはいません
    @endif
    <br>
    <br>
    <h1>DM可能ユーザー一覧</h1>
    @if(!empty($UserDmAppliesComplete))
        <table>
            <tr>
                <th>ユーザーID <---> ユーザーID</th>
            </tr>
            @foreach($UserDmAppliesComplete as $UserDmApply)
                <tr>
                    <td>{{$UserDmApply->user_id}} <---> {{$UserDmApply->apply_user_id}}</td>
                </tr>
            @endforeach
        </table>
    @else
        承認待ちのユーザーはいません
    @endif

@endsection
