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
        <div class="coupon-toggle">
            <div id="accordion" class="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <div class="card-title">
                            <span><i class="fa fa-window-maximize"></i> Filing {{ $service->name }}</span>
                            <a class="accordion-toggle" href="{{ route('w.f.return', ['id' => 0]) }}">Click here to choose a different one</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="full-grid">
                <form method="post" action="{{ route('w.f.post.company') }}" enctype="multipart/form-data">
                    @csrf
                    {{ \App\Models\User::showFormNotice($errors) }}
                    <div class="billing-fields">
                        <!-- <div class="checkout-title"> <h3>Billing details</h3></div> -->
                        <input name="service" type="hidden" value="{{ $service->id }}"/>
                        <input name="amount" type="hidden" value="{{ $service->price }}"/>
                        <div class="form-content-box">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Company KRA PIN</label>
                                        <input id="kraPin" name="kraPin" class="form-control-mod @error('kraPin') is-invalid @enderror" type="text" required value="{{ old('kraPin') }}">
                                        @error('kraPin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Company iTax Password *</label>
                                        <input id="itaxPassword" name="itaxPassword" class="form-control-mod @error('itaxPassword') is-invalid @enderror" type="text" required value="{{ old('itaxPassword') }}">
                                        @error('itaxPassword')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Company Registered Name *</label>
                                        <input id="firstName" name="firstName" class="form-control-mod @error('firstName') is-invalid @enderror" type="text" required value="{{ old('firstName') }}">
                                        @error('firstName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Company Phone number</label>
                                        <input id="phoneNumber" name="phoneNumber" class="form-control-mod @error('phoneNumber') is-invalid @enderror" type="text" required value="{{ old('phoneNumber') }}">
                                        @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Company Email Address</label>
                                        <input id="emailAddress" name="emailAddress" class="form-control-mod @error('emailAddress') is-invalid @enderror" type="email" required value="{{ old('emailAddress') }}">
                                        @error('emailAddress')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Attach financial statements</label>
                                        <input id="financial_statements" name="financial_statements[]" class="form-control-mod @error('financial_statements') is-invalid @enderror" type="file" required multiple/>
                                        @error('financial_statements')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small>Can select up to 10 files</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Choose Tax Return Year</label>
                                        <select name="year" class="d-block form-control-mod @error('year') is-invalid @enderror" required>
                                            @foreach( \App\Models\User::getYears() as $year )
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-method mt-40 md-mt-20">
                        <div class="bottom-area">
                            <p class="mt-15"></p>
                            <button class="add-btn" type="submit">Continue to payment</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
<!-- Checkout section end -->
@endsection
