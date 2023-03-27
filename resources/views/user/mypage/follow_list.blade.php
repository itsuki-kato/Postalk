@extends('user.mypage.mypage_header')

@section('mypage_content')

    <h1>フォロー一覧</h1>
    <br>

    @if(!empty($UserFollows))
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>フォロー状態</th>
                <th>操作</th>
            </tr>
            @foreach($UserFollows as $UserFollow)
                <tr>
                    <td>{{ $UserFollow->followUser->user_id }}</td>
                    <td>{{ $UserFollow->followUser->user_name }}</td>
                    <td>
                        @if(Auth::user()->getFollowStatus(Auth::user()->id, $UserFollow->follow_user_id) === App\Models\UserFollow::FOLLOW_APPLY)
                            フォロー申請しています
                        @elseif(Auth::user()->getFollowStatus(Auth::user()->id, $UserFollow->follow_user_id) === App\Models\UserFollow::FOLLOW_PERMIT)
                            フォロー許可されています
                        @endif
                    </td>
                    <td>
                        <div id="follow-btn">
                            {{-- 初期表示 --}}
                            <button 
                                type="button"
                                id="follow-delete-btn"
                                data-user-id="{{ Auth::user()->id }}" 
                                data-follow-user-id="{{ $UserFollow->follow_user_id }}" 
                                class="btn btn-outline-primary">
                                フォロー解除
                            </button>
                            {{-- ボタン押下後はJSONで動的に描写 --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        フォローしていません
    @endif

@endsection
