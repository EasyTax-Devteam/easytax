@extends('layouts.outer')

@section('navigation')
    @include('outer.nav')
@endsection


@section('slider')
<style>
    .carousel-caption {
        color: #fff;
        text-align: left;
        width: 35%;
        left: 5%;
        bottom: 45%;
    }
    .cap-inn{
        background-color: #ED2224;
        height: 100px;
        padding: 15px;
    }
    .cap-inn-2{
        background-color: #000000;
        height: 70px;
        padding: 15px;
    }
    .grey-bg{
        background: #cbcbcb;
    }
    .key-dates{
        font-size: 42px;
        line-height: 50px;
        font-weight: 400;
        margin-top: 18px;
    }
    .dates-title{
        font-weight: 500;
        font-size: 20px;
        color: {{ $calendar->theme }};
    }
</style>
<div id="rs-slider" class="rs-slider slider3">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ $calendar->art_work }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="cap-inn">
                        <h3 style="color: #fff;font-size:3.75rem; line-height:1.25em; font-weight:400">{{ $month_name }} {{ $calendar->year }}</h3>
                    </div>
                    <div class="cap-inn-2">
                        <h3 style="color: #fff;font-size:1.75rem; line-height:1.05em; font-weight:400">{{ $calendar->title }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach( $events as $key => $group )
<div class="rs-services home-style2 grey-bg pt-20 pb-20 md-pt-20 md-pb-20" id="step-one">
    <div class="container">
        <div class="sec-title2 text-center md-left mb-20">
            <h2 class="key-dates">Key dates to consider</h2>
        </div>
    </div>
</div>
@php($items = $group['events'] )
<div class="rs-services home-style2 gray-bg pt-50 pb-50 md-pt-50 md-pb-50" id="step-one">
    <div class="container-fluid">
        <div class="row y-middle">
            @foreach( $items as $it => $event )
            <div class="col-lg-4 md-mb-50">
                <p class="dates-title">{{ $event['title'] }}</p>
                <div>
                    {!! $event['content'] !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

@endsection

