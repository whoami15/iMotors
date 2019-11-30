@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="register-box" style="width:600px!important;">
    <div class="register-logo">
        <a href="{{ url('/') }}"><b>i</b>Motors</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register</p>
            <form method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}
                @if(session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
                @endif
                @if(session('danger'))
                <div class="alert alert-danger">
                    {!! session('danger') !!}
                </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="mb-1 text-danger">{{ $error }}</p>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" placeholder="First Name" value="{{ old('first_name') }}" name="first_name" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Middle Name" value="{{ old('middle_name') }}" name="middle_name" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Last Name" value="{{ old('last_name') }}" name="last_name" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="tel" placeholder="Mobile Number" value="{{ old('mobile') }}" name="mobile" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="gender" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="MALE" {{ (old('gender')) == 'MALE' ? 'selected' : '' }}>MALE</option>
                                <option value="FEMALE" {{ (old('gender')) == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-venus-mars"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="tel" placeholder="Barangay" value="{{ old('barangay') }}" name="barangay" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="tel" placeholder="Province" value="{{ old('province') }}" name="province" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" placeholder="Birthdate" name="birth_date" max="2005-01-01" min="1930-01-01" format="yyyy-mm-dd" id="birth_date" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" placeholder="you@email.com" value="{{ old('email') }}" name="email" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div> 
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Username" value="{{ old('username') }}" name="username" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Your password" name="password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Re-type your password" name="password_confirmation" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="tel" placeholder="Municipal" value="{{ old('municipal') }}" name="municipal" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="nearest_branch" required>
                                <option value="" selected disabled>Select Nearest Branch</option>
                                @if($nearest_branch)
                                @foreach($nearest_branch as $branch)
                                <option value="{{ $branch->branch_name }}" {{ (old('nearest_branch')) == $branch->branch_name ? 'selected' : '' }}>{{ $branch->description }}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-venus-mars"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
            </div>
            <p class="mb-0 text-center">
                <a href="{{ url('/login') }}" class="text-center">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection