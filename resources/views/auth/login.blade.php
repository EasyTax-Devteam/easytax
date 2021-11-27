@extends('layouts.auth')

@section('form')
<div class="app-auth-body mx-auto">	
    <div class="app-auth-branding mb-4">
        <a class="app-logo" href="{{ route('w.index') }}">
            <img class="logo-icon me-2" src="{{ asset('assets/images/logo-dark.png') }}" alt="logo">
        </a>
    </div>
    <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
    <div class="auth-form-container text-start">
        <form class="auth-form login-form" action="{{ route('login') }}" method="post">         
            @csrf
            <div class="email mb-3">
                <label class="sr-only" for="email">Email</label>
                <input id="email" name="email" value="{{ old('email') }}" type="email" class="form-control signin-email @error('email') is-invalid @enderror" placeholder="Email address" required="required">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="password mb-3">
                <label class="sr-only" for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control signin-password @error('password') is-invalid @enderror" placeholder="Password" required="required">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="extra mt-3 row justify-content-between">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="RememberPassword">
                            Remember me
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                    @if (Route::has('password.request'))
                        <div class="forgot-password text-end">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    @endif
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
            </div>
        </form>
        
        <!-- <div class="auth-option text-center pt-5">No Account? Sign up 
            <a class="text-link" href="signup.html" >here</a>.
        </div> -->
    </div>	

</div>
@endsection
