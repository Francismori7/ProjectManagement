@extends('layout')

@section('page-title', 'Welcome')

@section('page-content')
    <ul>
        @foreach($users as $user)
            <pre>
            {{ var_dump($user->getPermissions()) }}
            </pre>
        @endforeach
    </ul>
@endsection