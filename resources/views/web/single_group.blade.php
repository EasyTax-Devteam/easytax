@extends('layouts.outer')

@section('navigation')
@include('outer.nav')
@endsection


@section('slider')
<style>
    .animate-style {
        display: none !important;
    }

    .service-list {
        border-radius: 0px 47px 0px 0px;
        color: #1e3666;
        background: #dddddd;
        font-size: 18px !important;
        padding: 15px 40px 15px 40px;
    }
</style>
<div class="rs-about style2 pt-50 pb-50 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ">
                <div class="sec-title">
                    <h2 class="title pb-22">
                        {{
                            $categoryData->name 
                        }}
                    </h2>
                    {!!
                    $categoryData->description
                    !!}
                    <div class="btn-part mt-45 md-mt-30">
                        <!-- <a class="readon consultant discover" href="#">Get Started</a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pr-33 md-pr-15 md-mb-50">
                <div class="images-part">
                    <img src="{{ $categoryData->artwork }}" alt="Images">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="sec-title">
                    <h2 class="title pb-30">Click on any service to learn more</h2>
                    <ul>
                        @foreach( $services as $_list )
                        <li class="service-list mt-20">
                            <a class="" href="{{ route('w.s.service', ['id' => $_list['id']]) }}">{{ $_list['name'] }}</a>
                        </li>

                        @endforeach
                    </ul>

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