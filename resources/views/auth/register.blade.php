@extends('layout')

@section('page-title', 'Register')

@section('page-content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="well well-lg">
                @include('partials.errors')

                <form action="{{ route('auth.register') }}" method="post" role="form">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       placeholder="First Name" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       placeholder="Last Name" value="{{ old('last_name') }}">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                               value="{{ old('username') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email address"
                               value="{{ old('email') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Password (confirmation)</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       id="password_confirmation"
                                       placeholder="Password (confirmation)">
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Register my account</button>
                    <a href="{{ route('auth.login') }}" class="btn btn-link">Login to my account</a>

                </form>
            </div>
        </div>
    </div>
@endsection