@extends('layouts.layout')

@section('content')

<div class="block-edit-index">
    <h1 class="mb-5 text-center">TimeLine</h1>
    @foreach($Posts as $Post)
        <div class="row mb-5">
            <div class="col">
                <div class="border shadow-sm">
                    <div class="card-open card flex-md-row h-md-250">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary">{{ $Post->category->category_name }}</strong>
                            <h3 class="mb-0">{{ $Post->post_title }}</h3>
                            <div class="mb-1 text-muted">{{ $Post->create_at }}</div>
                        </div>
                        <div class="post-card-thum-wrapper">
                            <img class="post-card-thum card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [250x250]" src="{{ asset('storage/post/'.$Post->user->user_id.'/'.$Post->post_img_url) }}" data-holder-rendered="true">
                        </div>
                    </div>
                    <div class="card-inner card">
                        <div class="post-card-contentWrapper">
                            <div class="">
                                <img src="{{ asset('storage/post/'.$Post->user->user_id.'/'.$Post->post_img_url) }}" alt="">
                            </div>
                            <p>{{ $Post->post_text }}</p>
                            <span class="ajax_error_message"></span>
                            @if($Post->isMyFavorite($user_id) == true)
                                <i class="post_favorite_btn fa-solid fa-heart post_favorite_btn_added" 
                                    data-favorite-post-id="{{ $Post->id }}" 
                                    data-favorite-user-id="{{ Auth::user()->id }}"></i>
                            @else
                                <i class="post_favorite_btn fa-solid fa-heart"
                                 data-favorite-post-id="{{ $Post->id }}" 
                                 data-favorite-user-id="{{ Auth::user()->id }}"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
