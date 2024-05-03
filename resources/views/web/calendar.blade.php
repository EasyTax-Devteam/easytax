@extends('layouts.outer')

@section('navigation')
    @include('outer.nav')
@endsection


@section('slider')
<style>
  table.calendar{width:100%; border:1px solid #efefef;}
  td.day{width: 14%; height: 90px; border: 1px solid #efefef; vertical-align: top;text-align: center; padding: 5px;}
  td.day span.day-date{font-size: 14pt; font-weight: 700;}
  td.day span.holiday{font-size: 12pt; color: #f56934;}
  th.header{background-color: #6fabe8; color: #fff; font-size: 14pt; padding: 5px; text-align: center;}
  .not-month{background-color: #ededed;}
  td.today {background-color:#72d5f0;}
  td.day span.today-date{font-size: 16pt;}
  .has-evt{
    color: #fff;
    background-color: #6fabe8;
    border-color: #6fabe8;
    text-align: center;
    float: right;
    font-weight: 500;
    min-width: 80px;
    margin: 0px 0px 0px 10px;
  }
  .has-del{
    color: #ff0000;
    background-color: #fff;
    border-color: #ff0000;
    text-align: center;
    float: right;
    font-weight: 500;
  }
  .nav-link-a {
    display: inline!important;
  }
  .has-e{
    color: #ED2224!important;
  }
 </style>
<style>
    .carousel-caption {
        color: #fff;
        text-align: left;
        width: 35%;
        left: 13%;
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
    .padded{
        background: rgb(0,0,0,0.9);
        padding: 10px;
    }
    .carousel-control-prev {
        opacity: .9;
    } 
    .carousel-control-next {
        opacity: .9;
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
            <a class="carousel-control-prev" href="{{ route('w.tax.calendar', ['month' => $prev]) }}" data-bs-slide="prev">
                <div class="padded">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </div>
            </a>
            <a class="carousel-control-next" href="{{ route('w.tax.calendar', ['month' => $next]) }}" data-bs-slide="next">
                <div class="padded">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="rs-services home-style2 gray-bg pt-60 pb-60 md-pt-20 md-pb-20" id="step-one">
    <div class="container-fluid">
        <div class="row y-middle">
            <div class="col-lg-6 md-mb-50">
                <div>
                    {!! \App\Models\TaxCalendar::buildCalendar($calendar) !!}
                </div>
            </div>
            <div class="col-lg-6 md-mb-50">
                <div>
                    {!! $calendar->description !!}
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

