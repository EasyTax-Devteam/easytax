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
        <form class="auth-form login-form" action="{{ route('custom.password.update') }}" method="post">

            @csrf
            {{ \App\Models\User::showFormNotice($errors) }}


            <input type="hidden" name="token" value="{{ $token }}" />

            <div class="email mb-3">
                <label class="sr-only" for="email">Email</label>
                <input id="email" name="email" value="{{ $email ?? old('email') }}" type="email" class="form-control signin-email @error('email') is-invalid @enderror" placeholder="Email address" required="required">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="email mb-3">
                <label class="sr-only" for="password">Password</label>
                <input id="password" name="password" value="12345678" type="password" class="form-control signin-email @error('password') is-invalid @enderror" required="required">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="email mb-3">
                <label class="sr-only" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" value="12345678" type="password" class="form-control signin-email @error('password_confirmation') is-invalid @enderror" required="required">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Reset Password</button>
            </div>
        </form>

    </div>
</div>
@endsection