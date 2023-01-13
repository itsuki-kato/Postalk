@section('header')
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4"></div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">とりあえず各機能のリンクを表示</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/create') }}" class="text-white">ユーザー登録</a></li>
                            <li><a href="{{ url('/login') }}" class="text-white">ログイン</a></li>
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white">
                                ログアウト
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            <li><a href="{{ route('post.list') }}" class="text-white">タイムライン</a></li>
                            <li><a href="{{ route('post.index') }}" class="text-white">投稿作成</a></li>
                            <li><a href="{{ route('post.editIndex', ['post_id' => 1]) }}" class="text-white">投稿編集</a></li>
                            <li><a href="{{ route('notify.unreadList') }}" class="text-white">通知画面</a></li>
                            <li><a href="{{ route('search.index') }}" class="text-white">検索</a></li>
                            <li><a href="{{ route('mypage.profileIndex') }}" class="text-white">マイページ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                    <strong>Postalk</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </div>
    </header>
@show
