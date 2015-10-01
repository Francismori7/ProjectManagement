@extends('layout')

@section('page-title', 'Password reset')

@section('page-content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="well well-lg">
                @include('partials.errors')

                <form action="{{ route('auth.password.email') }}" method="post" role="form">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="username">Email address</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email address"
                               value="{{ old('email') }}">
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">Reset my password</button>
                    <a href="{{ route('auth.login') }}" class="btn btn-link">Go back</a>
                </form>
            </div>
        </div>
    </div>
@endsection