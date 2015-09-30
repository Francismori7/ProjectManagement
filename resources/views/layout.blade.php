<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('page-title') - Project Management</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
    <div class="container">
        <h1 class="page-header">@yield('page-title')
            @if(Auth::user())
                <span class="small">{{ Auth::user()->getFirstName() }} - <a href="{{ route('auth.logout') }}">Logout</a></span>
            @else
                <span class="small"><a href="{{ route('auth.login') }}">Login</a></span>
            @endif
        </h1>

        @yield('page-content')
    </div>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>