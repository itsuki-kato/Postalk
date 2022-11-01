@extends('layouts.layout')

@section('content')

<div class="block-edit-index">
    <div class="container">
        {{ Form::open(['route' => ['post.create'], 'method' => 'post', 'files' => true]) }}
            {{-- カテゴリ選択 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="user_category" class="col-md-2 control-label">カテゴリ選択</label>
                {{ Form::select('user_category', $user_category_list, old('user_category'), ['class' => 'user_category', 'id' => 'user_category', 'required' => 'required']) }}
            </div>

            {{-- タイトル --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="post_title" class="col-md-2 control-label">タイトル</label>
                {{ Form::text('post_title', null, old('post_title'), ['class' => 'post_title', 'id' => 'post_title']) }}
            </div>

            {{-- 記事内容 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="post_text" class="col-md-2 control-label">本文</label>
                <div class="">
                    {{ Form::textarea('post_text', null, old('post_text'), ['class' => 'post_title', 'id' => 'post_title']) }}
                </div>
            </div>

            {{-- 画像選択 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="post_img_url" class="col-md-2 control-label">画像選択</label>
                {{ Form::file('post_img_url', ['class' => 'post_img_url', 'id' => 'post_img_url'] ) }}
            </div>

            {{-- 作成ボタン --}}
            <div class="text-center mt-5">
                <button class="btn btn-sm btn-outline-secondary" type="submit">作成</button>
            </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
