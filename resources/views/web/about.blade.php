@extends('layouts.outer')

@section('navigation')
    @include('outer.nav')
@endsection


@section('slider')
    <div class="rs-about style2 pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pr-33 md-pr-15 md-mb-50">
                    <div class="images-part">
                        <img src="{{ asset('assets/images/about/about-3.png') }}" alt="Images">
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="sec-title">
                        <h2 class="title pb-22">
                            We help you file your returns effortlessly
                        </h2>
                        <span class="sub-text big">We make tax filing a click away. All you have to do is tell us what kind of returns you would like to file, then our team will get to work.</span>

                        <p class="margin-0 pt-15">We make tax filing a click away. All you have to do is tell us what kind of returns you would like to file, then our team will get to work.</p>
                        <div class="btn-part mt-45 md-mt-30">
                            <a class="readon consultant discover" href="{{ route('w.f.return', ['id' => 0]) }}">Get Started</a>
                        </div>
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

