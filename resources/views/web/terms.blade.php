@extends('layouts.outer')

@php( $settings = \App\Models\Site::getSettings())

@section('navigation')
@include('outer.nav')
@endsection


@section('slider')
<div class="rs-about style2 pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-6 pr-33 md-pr-15 md-mb-50">
                <div class="images-part">
                    <img src="{{ asset('assets/images/about/about-3.png') }}" alt="Images">
                </div>
            </div> -->
            <div class="col-lg-12 ">
                <div class="sec-title">
                {!! $settings->terms !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection