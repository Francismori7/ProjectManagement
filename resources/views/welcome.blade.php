@extends('layout')

@section('page-title', 'Welcome')

@section('page-content')
    @foreach($users as $user)
        {{ var_dump($user) }}
    @endforeach
@endsection