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
                <form method="post" action="{{ route('w.f.post.nill') }}">
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
                                        <label>KRA PIN</label>
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
                                        <label>iTax Password *</label>
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
                                        <label>First Name *</label>
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
                                        <label>Last Name</label>
                                        <input id="lastName" name="lastName" class="form-control-mod @error('lastName') is-invalid @enderror" type="text" required value="{{ old('lastName') }}">
                                        @error('lastName')
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
                                        <label>Phone number</label>
                                        <input id="phoneNumber" name="phoneNumber" class="form-control-mod @error('phoneNumber') is-invalid @enderror" type="text" required value="{{ old('phoneNumber') }}">
                                        @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input id="emailAddress" name="emailAddress" class="form-control-mod @error('emailAddress') is-invalid @enderror" type="email" required value="{{ old('emailAddress') }}">
                                        @error('emailAddress')
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
                        <div class="top-area">
                            <div class="payment-co">
                                <input required name="noTaxIncome" class="form-check-input" type="checkbox" value="Yes" id="termscheckbox">
                                <label class="form-check-label" for="termscheckbox">Confirm you had no taxable income for the year of income
                                </label>
                            </div>
                        </div>
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
