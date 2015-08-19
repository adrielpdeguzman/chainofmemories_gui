<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chain of Memories</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    {{ HTML::style('css/main.css') }}

    <style>
        @yield('styles')
    </style>
</head>
<body>
    <header>
        @include('includes.header')
    </header>

    <div id="main" class="container">
        @yield('content')
    </div>

    <footer>
        @include('includes.footer')
    </footer>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        @yield('scripts')
    </script>
</body>
</html>