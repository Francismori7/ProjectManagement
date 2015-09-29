<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
    </head>
    <body>
        @foreach($users as $user)
            {{ $user->getId() }}<br />
        @endforeach
    </body>
</html>
