@extends('user.mypage.mypage_header')

@section('mypage_content')

    <h1>マイカテゴリ(複数選択可能)</h1>
    {{-- フラッシュメッセージの表示 --}}
    @if(Session::has('flush_message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ session('flush_message') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{ Form::open(['route' => ['mypage.updateUserCategory'], 'method' => 'post']) }}
        <div>
            <span>マイカテゴリ</span>
            @foreach($UserCategories as $UserCategory)
                <div>
                    <input type="checkbox"
                        id="category_id_{{ $UserCategory->category->id }}"
                        class="my_category"
                        data-category-id="{{ $UserCategory->category_id }}" 
                        name="category_ids[]"
                        value="{{ $UserCategory->category->id }}"
                    >
                    <label for="category_id_{{ $UserCategory->category_id }}">
                        {{ $UserCategory->category->category_name }}
                    </label>
                </div>
            @endforeach
        </div>
        <br>
        <div>
            <span>全カテゴリ</span>
            @foreach($Categories as $Category)
                <div>
                    <input type="checkbox" 
                        id="category_id_{{ $Category->id }}"
                        name="category_ids[]"
                        value="{{ $Category->id }}"
                    >
                    <label for="category_id_{{ $Category->id }}">
                        {{ $Category->category_name }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" id="user-category-update-btn" class="btn btn-primary mt-5">更新</button>
    {{ Form::close() }}

@endsection
