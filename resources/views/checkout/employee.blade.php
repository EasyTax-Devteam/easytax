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
                <form method="post" action="{{ route('w.f.post.employee') }}" enctype="multipart/form-data">
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
                                <div class="col-md-12 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Do you personally pay  for kenyan Insurance Policies?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input insupolicies" type="radio" name="paying_kenyan_insurance_policies" id="inlineRadio1" value="Yes" {{ old('paying_kenyan_insurance_policies') == 'Yes' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                         </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input insupolicies" type="radio" name="paying_kenyan_insurance_policies" id="inlineRadio2" value="No" {{ old('paying_kenyan_insurance_policies') == 'No' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 mt-4 col-xs-12 showhide" style="display:none;">
                                    <div class="form-group">
                                        <label>If yes, which kenyan Insurance Policies?</label>
                                        <div class="form-check">
                                            <input class="form-check-input kip" name="kenyan_insurance_policies_paid[]" type="checkbox" value="Life Policy" id="lifep">
                                            <label class="form-check-label" for="lifep">Life Policy</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input kip" name="kenyan_insurance_policies_paid[]" type="checkbox" value="Medical Policy" id="medicalp">
                                            <label class="form-check-label" for="medicalp"> Medical Policy</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input kip" name="kenyan_insurance_policies_paid[]" type="checkbox" value="Education policy with a term of more than 10 years" id="educationp">
                                            <label class="form-check-label" for="educationp">
                                                Education policy with a term of more than 10 years
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>For the year of income, did you ever pay for a mortgage from a Kenyan bank?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paid_mortgage_for_tax_year" id="payingMortgagea" value="Yes" {{ old('paid_mortgage_for_tax_year') == 'Yes' ? 'checked' : ''}} >
                                            <label class="form-check-label" for="payingMortgagea">Yes</label>
                                         </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paid_mortgage_for_tax_year" id="payingMortgageb" value="No" {{ old('paid_mortgage_for_tax_year') == 'No' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="payingMortgageb">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 mt-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Attach P9 tax deduction form</label>
                                        <input id="p_nine_form" name="p_nine_form" class="form-control-mod @error('p_nine_form') is-invalid @enderror" type="file" required/>
                                        @error('p_nine_form')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
