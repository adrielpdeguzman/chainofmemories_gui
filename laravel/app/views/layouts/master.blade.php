<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chain of Memories @yield('title')</title>

    {{ HTML::style('css/bootstrap.min.css') }}

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

    {{ HTML::script('js/jquery-1.11.3.min.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}

    <script>
    $('.alert').not('.alert-important').delay(2500).slideUp(500);

    @yield('scripts')
    </script>
</body>
</html>