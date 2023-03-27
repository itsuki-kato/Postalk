@extends('user.mypage.mypage_header')

@section('mypage_content')

    <h1>フォロワー一覧</h1>
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
                    <td>{{ $UserFollow->user->user_id }}</td>
                    <td>{{ $UserFollow->user->user_name }}</td>
                    <td>
                        @if(Auth::user()->getFollowStatus($UserFollow->user_id, Auth::user()->id) === null)
                            フォローされていません
                        @elseif(Auth::user()->getFollowStatus($UserFollow->user_id, Auth::user()->id) === App\Models\UserFollow::FOLLOW_APPLY)
                            フォロー申請されています
                        @elseif(Auth::user()->getFollowStatus($UserFollow->user_id, Auth::user()->id) === App\Models\UserFollow::FOLLOW_PERMIT)
                            フォロー許可しています
                        @endif
                    </td>
                    <td>
                        <div id="follow-btn">
                            @if(Auth::user()->getFollowStatus($UserFollow->user_id, Auth::user()->id) === App\Models\UserFollow::FOLLOW_APPLY)
                                {{-- 初期表示 --}}
                                {{-- マイページでは相手が作成したフォローレコードに対して操作するためuser_idとfollow_user_idが逆になる --}}
                                <button 
                                    type="button" 
                                    id="follow-permit-btn"
                                    data-user-id="{{ $UserFollow->user_id }}" 
                                    data-follow-user-id="{{ Auth::user()->id }}" 
                                    class="btn btn-outline-primary">
                                    フォロー許可
                                </button>
                                @endif                        
                            {{-- ボタン押下後はJSONで描写する --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        フォロワーはいません
    @endif

@endsection
