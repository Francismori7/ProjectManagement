@extends('layout')

@section('page-title', 'Profile')

@section('page-content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="well well-lg">
                @include('partials.errors')

                <form action="{{ route('profile.update') }}" method="post" role="form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       placeholder="First Name" value="{{ old('first_name') ?: $user->getFirstName() }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       placeholder="Last Name" value="{{ old('last_name') ?: $user->getLastName() }}">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                               value="{{ old('username') ?: $user->getUserName() }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email address"
                               value="{{ old('email') ?: $user->getEmail() }}">
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">Update my profile</button>
                </form>
            </div>
        </div>
    </div>
@endsection