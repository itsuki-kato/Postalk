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
                {{ Form::select('user_category', $user_category_list, old('user_category', $Post->category_id), ['class' => 'user_category', 'id' => 'user_category', 'required' => 'required']) }}
            </div>

            {{-- タイトル --}}
            <div class="form-group form-inline input-group-sm mt-5">
                @error('post_title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="post_title" class="col-md-2 control-label">タイトル</label>
                {{ Form::text('post_title', old('post_title', $Post->post_title), ['class' => 'post_title', 'id' => 'post_title']) }}
            </div>

            {{-- 記事内容 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                @error('post_text')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="post_text" class="col-md-2 control-label">本文</label>
                <div class="">
                    {{ Form::textarea('post_text', old('post_text', $Post->post_text), ['class' => 'post_title', 'id' => 'post_title']) }}
                </div>
            </div>

            {{-- 編集時に画像がアップロードされていたら表示 --}}
            @if($Post->post_img_url)
                <div class="form-group form-inline input-group-sm mt-5">
                    <p>追加済みの画像</p>
                    <img src="{{ asset('uploads/'.$Post->user_id.'/'.$Post->post_img_url) }}" alt="">
                </div>
            @endif

            {{-- 画像選択 --}}
            <div class="form-group form-inline input-group-sm mt-5">
                @error('post_img_url')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="post_img_url" class="col-md-2 control-label">画像選択</label>
                {{ Form::file('post_img_url') }}
            </div>

            {{-- 作成ボタン --}}
            <div class="text-center mt-5">
                @if(isset($Post->post_id))
                    <button class="btn btn-sm btn-outline-secondary" type="submit" name="mode" value="edit">編集保存</button>
                    <input type="hidden" name="post_id" value="{{ $Post->post_id }}">
                @else
                    <button class="btn btn-sm btn-outline-secondary" type="submit" name="mode" value="create">新規作成</button>
                @endif
            </div>
        </form>
        {{ Form::close() }}
    </div>
</div>

@endsection
