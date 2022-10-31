@extends('layouts.layout')

@section('content')

<div class="block-edit-index">
    <div class="container">
        {{ Form::open(['url' => '/post/save', 'enctype' => 'multipart/form-data']) }}
            <div class="form-group form-inline input-group-sm">
                <label for="name" class="col-md-2 control-label">カテゴリ選択</label>
                <input type="text" class="form-control col-md-5" id="name" name="name" placeholder="書籍名">
                <label for="isbn" class="col-md-2 control-label">ISBNコード</label>
                <input type="text" class="form-control col-md-3" id="isbn" name="isbn" placeholder="ISBNコード">
            </div>
            <div class="form-group form-inline input-group-sm">
                <label for="price_from" class="col-md-2 control-label">価格</label>
                <input type="number" class="form-control col-md-2" id="price_from" name="price_from" placeholder="下限">
                <label class="col-md-1 control-label">～</label>
                <input type="number" class="form-control col-md-2" id="price_to" name="price_to" placeholder="上限">
                  <label for="publisher" class="col-md-2 control-label">出版社</label>
                <input type="text" class="form-control col-md-3" id="publisher" name="publisher" placeholder="出版社">
            </div>
            <div class="form-group form-inline input-group-sm">
                <label for="price_from" class="col-md-2 control-label">出版年月日</label>
                <input type="date" class="form-control col-md-3" id="publication_date_from" name="publication_date_from" placeholder="From">
                <label class="col-md-1 control-label">～</label>
                <input type="date" class="form-control col-md-3" id="publication_date_to" name="publication_date_to" placeholder="To">
                <div class="col-md-3"></div>
            </div>
            <div class="text-center">
                <button class="btn btn-sm btn-outline-secondary" type="submit">検索</button>
            </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
