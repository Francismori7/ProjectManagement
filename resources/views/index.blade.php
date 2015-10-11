<!DOCTYPE html>
<html lang="en" ng-app="creaperio">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Creaperio</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}"/>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="site">
    <div class="nav" ui-view="navigation"></div>
    <div class="body">
      <div class="sidebar" ui-view="sidebar">
          <ul>
              <li><a href="#" class="active"><span class="fa fa-compass fa-fw fa-lg"></span></a></li>
              <li><a href="#"><span class="fa fa-trash fa-fw fa-lg"></span></a></li>
          </ul>
      </div>
      <div class="main" ui-view="main"></div>
    </div>
    <div class="footer" ui-view="footer"></div>

    <script src="{{ asset('js/vendor.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
</body>
</html>
