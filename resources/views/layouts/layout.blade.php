<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Postalk</title>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/post_index.js'])
        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/c00c4bbdb5.js" crossorigin="anonymous"></script>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
        <link rel="stylesheet" href="{{ asset('/css/post.css')  }}" >
    </head>
    <style>
        .layout-footer-fixBox {
            min-height: 100vh; /* ←コンテンツの高さの最小値＝ブラウザの高さに指定 */
            position: relative;/* ←相対位置 */
            padding-bottom: 60px; /* ←フッターの高さを指定 */
            box-sizing: border-box;
        }

        /* メインのコンテンツ全体を中央寄せにする。 */
        .layout-mainContent {
            width: 1120px;
            margin: auto;
            margin-top: 50px;
        }

        .layout-footer {
            position: absolute;/* ←絶対位置 */
            bottom: 0;
            display: block;
            width: 100%;
        }
    </style>
    <body>
        <div class="layout-footer-fixBox">
            <!-- header -->
            <div class="layout-header">
                @include('header')
            </div>
            <!-- main-content -->
            <div class="layout-mainContent">
                @yield('content')
            </div>
            <!-- footer -->
            <div class="layout-footer">
                @include('footer')
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
