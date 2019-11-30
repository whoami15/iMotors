@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>i</b>Motors</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in</p>
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                @if(session('success'))
                <div class="alert alert-success">
                    <strong>{!! session('success') !!}</strong>
                </div>
                @endif
                @if(session('danger'))
                <div class="alert alert-danger">
                    <strong>{!! session('danger') !!}</strong>
                </div>
                @endif
                @if ($errors->any())
                    <strong>
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                    </strong>
                @endif
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="you@email.com" autocapitalize="off" autocorrect="off" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Your password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
            </div>
            <p class="mb-0 text-center">
                <a href="{{ url('/register') }}" class="text-center">Create account</a>
            </p>
        </div>
    </div>
</div>
@endsection