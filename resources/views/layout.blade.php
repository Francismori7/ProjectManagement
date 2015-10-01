<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('page-title') - Project Management</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.navigation')

    <div class="container">
        <h1>@yield('page-title')</h1>

        @yield('page-content')
    </div>

    <script type="text/javascript" src="{{ asset('js/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>