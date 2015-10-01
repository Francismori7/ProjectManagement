@extends('layout')

@section('page-title', 'Login')

@section('page-content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="well well-lg">
                @include('partials.errors')

                <form action="{{ route('auth.login') }}" method="post" role="form">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                               value="{{ old('username') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me?
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="{{ route('auth.password.email') }}" class="btn btn-link">I lost my password</a>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('auth.register') }}" class="btn btn-info">Register a new account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection