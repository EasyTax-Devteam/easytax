@extends('layouts.outer')

@section('navigation')
@include('outer.nav')
@endsection


@section('slider')
<style>
    .animate-style {
        display: none !important;
    }

    .title-price {
        font-size: 20px;
        font-weight: 500;
        color: #478aca;
    }

    .price-bolder {
        font-size: 20px;
        font-weight: 700;
    }
</style>
<div class="rs-about style2 pt-50 pb-50 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="sec-title">
                    <h2 class="title pb-3">
                        {{
                            $serviceData->name 
                        }}
                    </h2>


                    @if(intval($serviceData->price) == 0 )
                    <h2 class="title-price pb-2">
                        You'll pay <span class="price-bolder">
                            KES {{ number_format($serviceData->deposit, 0) }}
                        </span> commitment fee. The final fee quotation shall be based on matter.
                    </h2>
                    @else

                    <h2 class="title-price pb-2">
                        Price: <span class="price-bolder">
                            KES {{ number_format($serviceData->price, 0) }}
                        </span>
                    </h2>

                    @endif


                    {!!
                    $serviceData->description
                    !!}
                    <div class="btn-part mt-45 md-mt-30">
                        <!-- <a class="readon consultant discover" href="#">Get Started</a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-12 ">
                <div class="sec-title">
                    <h2 class="title pb-10">Let's Help you with {{ $serviceData->name }} </h2>
                    <h4 class="sec-sub-title mt-22">Fill the form below to get started. Refer to the above service description for required fields</h4>
                    <p class="mandaory-note"><b class="required">*</b> Indicates that the field is mandatory</p>
                </div>
                <br>
                <form class="row" method="post" enctype="multipart/form-data" action="{{ route('w.s.service.send') }}">
                    @csrf
                    {{ \App\Models\User::showFormNotice($errors) }}
                    <div class="mb-5 col-md-3">
                        <input type="hidden" name="service" value="{{ $serviceData->id }}" />
                        @if(intval($serviceData->price) == 0 )
                        <input type="hidden" name="amount" value="{{ $serviceData->deposit }}" />
                        @else
                        <input type="hidden" name="amount" value="{{ $serviceData->price }}" />
                        @endif
                        <div class="label-wrap"> <label class="form-label"><sup class="required">*</sup> Email Address </label></div>
                        <input required type="email" placeholder="jane.doe@example.com" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-5 col-md-3">
                        <div class="label-wrap"> <label class="form-label"><sup class="required">*</sup> First Name </label></div>
                        <input required type="text" placeholder="Jane" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}">
                        @error('fname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-5 col-md-3">
                        <div class="label-wrap"> <label class="form-label"><sup class="required">*</sup> Last Name </label></div>
                        <input required type="text" placeholder="Doe" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}">
                        @error('lname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-5 col-md-3">
                        <div class="label-wrap"> <label class="form-label"><sup class="required">*</sup> Phone Number </label></div>
                        <input required type="text" placeholder="+254722222200" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @foreach( $requestForm as $_form )

                    @php($required = $_form['field_is_required'])
                    @php($field_is_multiple = $_form['field_is_multiple'])
                    @php($field_label = \App\Models\User::formatViewable($_form['field_label']))
                    @php( $field_name = $_form['field_name'] )
                    @if($_form['field_type'] == 'text')
                    <div class="mb-5 col-md-6">
                        <div class="label-wrap"><label class="form-label">
                                {!! $required == 1 ? '<sup class="required">*</sup>' : '' !!}
                                {!! $field_label !!}</label></div>
                        <input {{ $required == 1 ? "required" : "" }} type="{{ $_form['field_type'] }}" placeholder="{{ strtoupper($_form['field_placeholder']) }}" name="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" value="{{ old($field_name) }}">
                        @error($field_name)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @elseif($_form['field_type'] == 'file')
                    <div class="mb-5 col-md-6">
                        <div class="label-wrap">
                            <label class="form-label">
                                {!! $required == 1 ? '<sup class="required">*</sup>' : '' !!}
                                {!! $field_label !!}
                            </label>
                        </div>
                        <input {{ $required == 1 ? "required" : "" }} type="file" name="{{ $field_name }}{{ $field_is_multiple == 1 ? '[]' : '' }}" class="form-control" {{ $field_is_multiple == 1 ? "multiple" : "" }}>
                        <small class="input-hint">Select up to {{ $_form['field_max_uploads'] }} file(s) of up to 2MB each.</small>
                    </div>
                    @elseif($_form['field_type'] == 'select')
                    @php( $selectOptions = json_decode($_form['field_options_json'], true) )
                    <div class="mb-5 col-md-6">
                        <div class="label-wrap">
                            <label class="form-label">
                                {!! $required == 1 ? '<sup class="required">*</sup>' : '' !!}
                                {!! $field_label !!}
                            </label>
                        </div>
                        <select {{ $required == 1 ? "required" : "" }} name="{{ $field_name }}" id="{{ $field_name }}_id" class="form-control @error($field_name) is-invalid @enderror">
                            <option value="">Choose one</option>
                            @foreach($selectOptions as $value )
                            <option value="{{ $value['value'] }}">{{ strtoupper($value['label']) }}</option>
                            @endforeach
                        </select>
                        @error($field_name)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @else
                    @endif
                    @endforeach
                    <div class="mb-5 col-md-12">
                        <label class="form-label">Any other specific instructions you may have for us</label>
                        <textarea rows="4" class="form-control @error('additional_instructions') is-invalid @enderror" name="additional_instructions">{{ old('additional_instructions') }}</textarea>
                        @error('additional_instructions')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-5 col-md-12">
                        <button type="submit" name="request_service" class="btn btn-primary service-button">Proceed to Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="rs-animation">
        <div class="animate-style">
            <img class="scale" src="{{ asset('assets/images/about/tri-circle-1.png') }}" alt="About">
        </div>
    </div>
</div>
@endsection