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
            <form method="post" action="{{ route('w.u.post_login') }}">
                @csrf
                {{ \App\Models\User::showFormNotice($errors) }}
                <div class="billing-fields">
                    <div class="checkout-title">
                        <h3>Returning Customer</h3>
                    </div>
                    <div class="form-content-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Enter Your KRA PIN</label>
                                    <small><br></small>
                                    <input id="KraPin" name="KraPin" class="form-control-mod @error('KraPin') is-invalid @enderror" type="text" required value="{{ old('KraPin') }}" placeholder="A006234985H">
                                    @error('KraPin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Enter Password </label>
                                    <small class="small">Use the password that was sent to you via email/sms</small>
                                    <input id="password" name="password" class="form-control-mod @error('password') is-invalid @enderror" type="password" required value="{{ old('password') }}" placeholder="**********">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-method mt-40 md-mt-20">
                    <div class="bottom-area">
                        <p class="mt-15"></p>
                        <button class="add-btn" type="submit">Proceed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Checkout section end -->
@endsection