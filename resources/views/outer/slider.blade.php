@php( $sliders = \App\Models\Slider::getSliders())
<style>
    .carousel-control-prev {
        width: 5% !important;
    }

    .carousel-caption {
        right: none !important;
        text-align: left !important;
    }
    .carousel-caption {
        bottom: 5.25rem!important;
        left: 10%!important;
    }
    .slick-slide {
        margin: 10px;
        padding: 20px;
        min-width: 200px!important;
    }
    /********** SLICK THEME CSS *************/

.slick-loading .slick-list{background:#fff url(./ajax-loader.gif) center center no-repeat}@font-face{font-family:'slick';font-weight:400;font-style:normal;src:url(./fonts/slick.eot);src:url('./fonts/slick.eot?#iefix') format('embedded-opentype'),url(./fonts/slick.woff) format('woff'),url(./fonts/slick.ttf) format('truetype'),url('./fonts/slick.svg#slick') format('svg')}.slick-prev,.slick-next{font-size:0;line-height:0;position:absolute;top:75%;display:block;width:20px;height:20px;margin-top:-10px;padding:0;cursor:pointer;color:#fff0;border:none;outline:none;background:#fff0}.slick-prev:hover,.slick-prev:focus,.slick-next:hover,.slick-next:focus{color:#fff0;outline:none;background:#fff0}.slick-prev:hover:before,.slick-prev:focus:before,.slick-next:hover:before,.slick-next:focus:before{opacity:1}.slick-prev.slick-disabled:before,.slick-next.slick-disabled:before{opacity:.25}.slick-prev:before,.slick-next:before{font-family:'slick';font-size:100px;line-height:1;opacity:.75;color:#000;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.slick-prev{left:-9%}[dir='rtl'] .slick-prev{right:-25px;left:auto}.slick-prev:before{content:'←'}[dir='rtl'] .slick-prev:before{content:'→'}.slick-next{right:-25px}[dir='rtl'] .slick-next{right:auto;left:-25px}.slick-next:before{content:'→'}[dir='rtl'] .slick-next:before{content:'←'}.slick-slider{margin-bottom:30px}.slick-dots{position:absolute;bottom:-45px;display:block;width:100%;padding:0;list-style:none;text-align:center}.slick-dots li{position:relative;display:inline-block;width:20px;height:20px;margin:0 5px;padding:0;cursor:pointer}.slick-dots li button{font-size:0;line-height:0;display:block;width:20px;height:20px;padding:5px;cursor:pointer;color:#fff0;border:0;outline:none;background:#fff0}.slick-dots li button:hover,.slick-dots li button:focus{outline:none}.slick-dots li button:hover:before,.slick-dots li button:focus:before{opacity:1}.slick-dots li button:before{font-family:'slick';font-size:6px;line-height:20px;position:absolute;top:0;left:0;width:20px;height:20px;content:'•';text-align:center;opacity:.25;color:#000;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.slick-dots li.slick-active button:before{opacity:.75;color:#000}
</style>
<div id="rs-slider" class="rs-slider slider3">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach( $sliders as $k => $v)
                <button type="button" 
                    data-bs-target="#carouselExampleIndicators" 
                    data-bs-slide-to="{{ $k }}" 
                    @if($k == 0 )
                    class="active" 
                    aria-current="true" 
                    @endif
                    aria-label="Slide {{ $k + 1 }}">
                </button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach( $sliders as $index => $slider)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ $slider->image }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="sl-subtitle">{{ $slider->prefix }}</div>
                    <h1 class="sl-title"> {{ $slider->title }}</h1>
                    <div class="desc">{{ $slider->description }}</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="{{ $slider->url }}">{{ $slider->button_text }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@php( $calendarMonths = \App\Models\TaxCalendar::getCalendar()  )

@php( $currentMonth = 0 )
@foreach( $calendarMonths as $iter => $cal)
    @if( date("Y") == $cal->year && intval(date("m")) == intval($cal->month))
        @php( $currentMonth = $iter )
    @endif
@endforeach

<div class="rs-services home-style2 gray-bg pt-50 pb-20 md-pt-70 md-pb-70" id="step-one">
    <div class="container">
        <div class="sec-title2 text-center md-left mb-20">
            <h2 class="title">Tax Calendar</h2>
            <div class="text-secondary">Don't miss any Tax filing deadlines and events no more.</div>
        </div>
        <div id="tax-calendar" data-slick='{"slidesToShow": 5, "slidesToScroll": 1, "initialSlide": <?=$currentMonth == 0 ? 0 :$currentMonth-1 ?>}'>
            @foreach( $calendarMonths as $index => $calendar)
            @if($index === $currentMonth )
            <div class="card" style="background-color:#c8e3fd;">
                <a href="{{route('w.tax.calendar', ['month' => $calendar->id])}}" class="">
                    <img src="{{ $calendar->art_work }}" class="card-img-top" alt="..." style="height: 150px;">
                    <div class="card-body" style="background-color: #c8e3fd;">
                        <p class="card-text">{{ \App\Models\TaxCalendar::monthName($calendar->month) }} {{ $calendar->year }}</p>
                    </div>
                </a>
            </div>
            @else
            <div class="card">
                <a href="{{route('w.tax.calendar', ['month' => $calendar->id])}}" class="">
                    <img src="{{ $calendar->art_work }}" class="card-img-top" alt="..." style="height: 150px;">
                    <div class="card-body" style="background-color: #fff;">
                        <p class="card-text">{{ \App\Models\TaxCalendar::monthName($calendar->month) }} {{ $calendar->year }}</p>
                    </div>
                </a>
            </div>
            @endif
            @endforeach
        </div>
        <div class="sec-title2 text-center md-left">
            <a class="consultant view-more" href="{{route('w.tax.calendar')}}">View More</a>
        </div>
    </div>
</div>
