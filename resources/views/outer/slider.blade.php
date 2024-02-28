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