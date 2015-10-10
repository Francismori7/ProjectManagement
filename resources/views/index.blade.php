<!DOCTYPE html>
<html lang="en" ng-app="creaperio">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Creaperio</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}"/>

<<<<<<< HEAD
    <!-- <link rel="stylesheet" href="{{ asset('css/vendor.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="site">
    <div class="nav" ui-view="navigation"></div>
    <div class="main" ui-view="main"></div>
    <div class="footer" ui-view="footer"></div>
=======
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    <header class="top-nav">
        <div class="logo">
            <a href="#">
                <img src="{{ asset('images/icon.png') }}">
            </a>
        </div>
        <div class="navigation">
            <ul>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Clients</a></li>
                <li><a href="#" class="active">Billing</a></li>
                <li><a href="#">Users</a></li>
            </ul>
        </div>
        <div class="user-navigation">
            <ul>
                <li><a href="#"><span class="fa fa-search fa-lg fa-fw"></span></a></li>
                <li><a href="#"><span class="fa fa-cog fa-lg fa-fw"></span></a></li>
                <li><a href="#"><span class="fa fa-refresh fa-lg fa-fw"></span></a></li>
                <li><a href="#"><span class="fa fa-sign-out fa-lg fa-fw"></span></a></li>
            </ul>
        </div>
    </header>
>>>>>>> 422ec2bfb1d08789dee7023b2adfd700c18dae91

    <script src="{{ asset('js/vendor.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
</body>
</html>
