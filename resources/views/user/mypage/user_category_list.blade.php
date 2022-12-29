@extends('user.mypage.mypage_header')

@section('mypage_content')


    <!-- マイカテゴリタブのコンテンツ -->
    <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
        <p>ー－－マイカテゴリー－－</p>
        @if(!empty(session('user_category_list')))
            @foreach(session('user_category_list') as $user_category)
                {{ Form::open(['url' => 'user/select_category']) }}
                    @if(!empty(session('user_select_category')) && session('user_select_category') == $user_category['category_id'])
                        <button style="background-color:yellow">{{$user_category['category_id']}}</button>
                    @else
                        <button>{{$user_category['category_id']}}</button>
                    @endif
                    <input type="hidden" name="category_id" value="{{ $user_category['category_id'] }}">
                {{ Form::close() }}
            @endforeach
        @else
            カテゴリがありません
        @endif
    </div>


@endsection
