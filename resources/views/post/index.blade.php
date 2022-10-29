@extends('layouts.layout')

@section('content')
    <div class="block-post-create">
        {{ Form::open(['url' => '/post/save']) }}
            <div class="form-group">
                <label for="">ユーザーID</label>
                <input type="text" name="user_id">
                <label for="">記事テキスト</label>
                <input type="text" name="post_text">
                <label for="">カテゴリID</label>
                <input type="text" name="category_id">
                <label for="">投稿ID</label>
                <input type="text" name="post_id">
            </div>
            <button>送信</button>
        {{ Form::close() }}
    </div>
@endsection
