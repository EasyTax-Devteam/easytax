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
            <form method="post" action="{{ route('w.u.post_reset_link') }}">
                @csrf
                {{ \App\Models\User::showFormNotice($errors) }}
                <div class="billing-fields">
                    <div class="checkout-title">
                        <h3>Password Reset</h3>
                    </div>
                    <div class="form-content-box">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Enter Your Email Addres</label>
                                    <small><br></small>
                                    <input id="emailAddress" name="emailAddress" class="form-control-mod @error('emailAddress') is-invalid @enderror" type="text" required value="{{ old('emailAddress') }}">
                                    @error('emailAddress')
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
                    <div class="col-md-4">
                        <button class="add-btn" type="submit">Get Link</button>
                    </div>
                    <div class="col-md-6">
                        <!-- <button class="btn btn-link" type="submit">Reset Password</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Checkout section end -->
@endsection