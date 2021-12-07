@extends('layouts.outer')

@section('navigation')
    @include('outer.nav')
@endsection


@section('slider')
<style>
    .form-container{
        max-width: 700px;
    }
</style>
<div id="rs-checkout" class="rs-checkout pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container form-container">
        <div class="full-grid">
            <form method="post" action="{{ route('w.f.payment') }}">
                @csrf
                {{ \App\Models\User::showFormNotice($errors) }}
                <p class="mt-4">Your Mpesa will be debited <b>KES {{ number_format($amount, 0)}}</b></p>
                <div class="billing-fields">
                    <div class="checkout-title"> <h3>Mpesa Payment</h3></div>
                    <input name="bill" type="hidden" value="{{ $bill }}"/>
                    <div class="form-content-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Enter mpesa phone number</label>
                                    <input id="MpesaPhone" name="MpesaPhone" class="form-control-mod @error('MpesaPhone') is-invalid @enderror" type="text" required value="{{ old('MpesaPhone') }}">
                                    @error('MpesaPhone')
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
                        <button class="add-btn" type="submit">Make Payment</button>
                        <button class="btn-link btn check-status" style="display: none;" onclick="checkStatus()">Check payment status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Checkout section end -->
@endsection
