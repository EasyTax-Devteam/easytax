@extends('layouts.auth')

@section('form')
<div class="app-auth-body mx-auto">	
    <div class="app-auth-branding mb-4">
        <a class="app-logo" href="{{ route('w.index') }}">
            <img class="logo-icon me-2" src="{{ asset('assets/images/logo-dark.png') }}" alt="logo">
        </a>
    </div>
    <h2 class="auth-heading text-center mb-5">Request Password Reset</h2>
    <div class="auth-form-container text-start">
        <form class="auth-form login-form" action="{{ route('password.email') }}" method="post">  
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

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

            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Send Password Reset Link</button>
            </div>
        </form>
        
    </div>	
</div>
@endsection
