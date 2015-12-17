<!DOCTYPE html>
<html lang="en" ng-app="creaperio">
<head>
    <meta charset="UTF-8">
	<title>Creaperio</title>
	<meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}"/>

    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body style="display:flex;">
    <!--[if lt IE 10]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="dashboard" layout="row" flex>
        <div ui-view="sidenav" layout="column"></div>
        <div class="main" layout="column" flex>
            <div ui-view="topnav"></div>
            <div ui-view="main" layout="row" flex></div>
        </div>
    </div>

    <script src="{{ asset('js/vendor.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
    <script src="{{ asset('views/templateCacheHtml.js') }}" charset="utf-8"></script>
    
    {{--livereload--}}
    @if ( env('APP_ENV') === 'local' )
        <script type="text/javascript">
            document.write('<script src="'+ location.protocol + '//' + (location.host || 'localhost') +':35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
        </script>
    @endif
</body>
</html>
