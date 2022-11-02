@extends('layouts.layout')

@section('content')

<div class="block-edit-index">
    <div class="container">

        {{-- フラッシュメッセージの表示 --}}
        @if(Session::has('flush_message'))
            メッセージ：{{ session('flush_message') }}
        @endif

        {{ Form::open(['route' => ['post.valid'], 'method' => 'post', 'files' => true]) }}
            {{-- カテゴリ選択 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="user_category" class="col-md-2 control-label">カテゴリ選択</label>
                {{ Form::select('user_category', $user_category_list, old('user_category', $Post->user_category), ['class' => 'user_category', 'id' => 'user_category', 'required' => 'required']) }}
            </div>

            {{-- タイトル --}}
            <div class="form-group form-inline input-group-sm mt-5">
                @error('post_title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="post_title" class="col-md-2 control-label">タイトル</label>
                {{ Form::text('post_title', null, old('post_title', $Post->post_title), ['class' => 'post_title', 'id' => 'post_title']) }}
            </div>

            {{-- 記事内容 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                @error('post_text')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="post_text" class="col-md-2 control-label">本文</label>
                <div class="">
                    {{ Form::textarea('post_text', null, old('post_text', $Post->post_text), ['class' => 'post_title', 'id' => 'post_title']) }}
                </div>
            </div>

            {{-- 画像選択 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                <label for="post_img_url" class="col-md-2 control-label">画像選択</label>
                {{-- TODO：編集だったら画像を表示する。 --}}
                {{ Form::file('post_img_url', ['class' => 'post_img_url', 'id' => 'post_img_url'] ) }}
            </div>

            {{-- 作成ボタン --}}
            <div class="text-center mt-5">
                @if(isset($Post->post_id))
                    <button class="btn btn-sm btn-outline-secondary" type="submit" name="mode" value="edit">編集保存</button>
                @else
                    <button class="btn btn-sm btn-outline-secondary" type="submit" name="mode" value="create">新規作成</button>
                @endif
            </div>
        {{ Form::close() }}
    </div>
</div>

@endsection
