<style>
    .carousel-control-prev {
        width: 5% !important;
    }

    .carousel-caption {
        right: none !important;
        text-align: left !important;
    }
</style>
<div id="rs-slider" class="rs-slider slider3">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/images/slider/slider1.jpg') }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="sl-subtitle">Led By</div>
                    <h1 class="sl-title"> Experts <br> in Tax Services</h1>
                    <div class="desc">At EasyTax, we help individuals & corporates with all their tax needs.</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="#step-one">Browse Our services</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/slider/slider2.jpg') }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="sl-subtitle">We Are</div>
                    <h1 class="sl-title">Leaders <br> in Tax Solutions</h1>
                    <div class="desc">EasyTax offers a wide range of tax services to individuals & corporates.</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="#step-one">Request Tax Service</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/slider/slider3.jpg') }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="sl-subtitle">We Are A</div>
                    <h1 class="sl-title">Great Team<br> of Specialists</h1>
                    <div class="desc">Ready to get your tax needs sorted. We do filings, refunds, declaration among other services</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="#step-one">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/slider/slider4.jpg') }}" class="d-block w-100" alt="EasyTax offers">
                <div class="carousel-caption d-none d-md-block">
                    <div class="sl-subtitle">We Are</div>
                    <h1 class="sl-title">Region's <br> Preferred Firm</h1>
                    <div class="desc">When it comes to tax solutions, EasyTax is the most preferred by individuals and corporates in the region.</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="#step-one">Browse Our services</a>
                    </div>
                </div>
            </div>
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

    <!-- <div class="bend niceties">
        <div id="nivoSlider" class="slides">
            <img src="{{ asset('assets/images/slider/slider1.jpg') }}" alt="" title="#slide-1" />
        </div>
        <div id="slide-1" class="slider-direction">
            <div class="content-part">
                <div class="container">
                    <div class="slider-des">
                        <div class="sl-subtitle">We Are</div>
                        <h1 class="sl-title">Leaders <br> in Tax Solutions</h1>
                    </div>
                    <div class="desc">EasyTax offers a wide range of tax services to individuals & corporates.</div>
                    <div class="slider-bottom ">
                        <a class="readon consultant slider" href="#step-one">Browse Our services</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>