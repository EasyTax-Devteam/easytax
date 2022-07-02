@extends('layouts.outer')

@section('navigation')
@include('outer.nav')
@endsection


@section('slider')
<style>
    .animate-style {
        display: none !important;
    }
</style>
<div class="rs-about style2 pt-50 pb-50 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="sec-title">
                    <h2 class="title pb-22">
                        {{
                            $serviceData->name 
                        }}
                    </h2>
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
                    <h2 class="title pb-22">Let's Help you with {{ $serviceData->name }} </h2>
                </div>
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