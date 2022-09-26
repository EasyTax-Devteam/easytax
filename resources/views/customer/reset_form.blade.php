@extends('layouts.outer')

@section('navigation')
@include('outer.nav')
@endsection


@section('slider')
<style>
    .form-container {
        max-width: 700px;
    }

    .small {
        font-size: 9px;
    }
</style>
<div id="rs-checkout" class="rs-checkout pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container form-container">
        <div class="full-grid">
            <form method="post" action="{{ route('w.u.post_change_pwd') }}">
                @csrf
                {{ \App\Models\User::showFormNotice($errors) }}
                <div class="billing-fields">
                    <div class="checkout-title">
                        <h3>Reset Your Password</h3>
                    </div>
                    <div class="form-content-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <small><br></small>
                                    <input type="hidden" name="token" value="{{ $token }}" />

                                    <input id="password" name="password" class="form-control-mod @error('password') is-invalid @enderror" type="password" required value="{{ old('password') }}" placeholder="**********">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Re-enter New Password </label>
                                    <small class="small">Use the password that was sent to you via email/sms</small>
                                    <input id="password_confirmation" name="password_confirmation" class="form-control-mod @error('password_confirmation') is-invalid @enderror" type="password" required value="{{ old('password_confirmation') }}" placeholder="**********">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-method mt-40 md-mt-20 row">
                    <div class="col-md-6">
                        <button class="add-btn" type="submit">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Checkout section end -->
@endsection