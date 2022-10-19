<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Postalk</title>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js'])
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css" >
    </head>
    <body>
        <!-- header -->
        @include('header')

        <!-- main-content -->
        @yield('top')

        <!-- footer -->
        @include('footer')

        <!-- 以下よくわからん定義 -->
        <script src="../../assets/js/vendor/holder.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script>
            window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="/docs/4.3/assets/js/vendor/anchor.min.js"></script>
        <script src="/docs/4.3/assets/js/vendor/clipboard.min.js"></script>
        <script src="/docs/4.3/assets/js/vendor/bs-custom-file-input.min.js"></script>
        <script src="/docs/4.3/assets/js/src/application.js"></script>
        <script src="/docs/4.3/assets/js/src/search.js"></script>
        <script src="/docs/4.3/assets/js/src/ie-emulation-modes-warning.js"></script>
    </body>
</html>
