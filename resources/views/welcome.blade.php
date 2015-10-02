@extends('layout')

@section('page-title', 'Welcome')

@section('page-content')
    <ul>
        @foreach($users as $user)
                {{ $user->getUsername() }} - {{ print_r($user->getPermissions()->toArray(), true) }}
                @if($user->hasPermission('users.update'))
                    -> CAN MODIFY USERS
                @endif<br />
        @endforeach
    </ul>
@endsection