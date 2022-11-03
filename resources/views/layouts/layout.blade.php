<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Postalk</title>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js'])
        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/c00c4bbdb5.js" crossorigin="anonymous"></script>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
        <link rel="stylesheet" href="{{ asset('/css/post.css')  }}" >
    </head>
    <style>
        /* メインのコンテンツ全体を中央寄せにする。 */
        .layout-main-content {
            width: 1120px;
            margin: auto;
        }

        .layout-main-content {
            margin-top: 50px;
        }
    </style>
    <body>
        <!-- header -->
        @include('header')

        <!-- main-content -->
        <div class="layout-main-content">
            @yield('content')
        </div>

    <!-- footer -->
        @include('footer')

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
