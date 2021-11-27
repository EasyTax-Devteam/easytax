@php( $glabal_services = \App\Models\User::getServices() )
<style>
    .gray-bg {
        background: #fffefe;
    }
    .rs-services.home-style2 .services-item .services-icon img {
        height: 120px;
        width: 120px;
        max-width: unset;
    }
    .readon.consultant {
        border: solid 1px #800000;
    }
    .rs-services.home-style2 .services-item {
        display: block;
    }
</style>
<div class="rs-services home-style2 gray-bg pt-100 pb-100 md-pt-70 md-pb-70" id="step-one">
    <div class="container">
        <div class="sec-title2 text-center md-left mb-40">
            <div class="sub-text">Step 1 - choose a service</div>
            <h2 class="title">Services Offered</h2>
            <br>
        </div>
        <div class="row y-middle">
            @foreach( $glabal_services as $_service  )
                <div class="col-lg-3  md-mb-50">
                    <div class="services-item mb-45 text-center">
                        <div class="services-icon">
                            <img src="{{ $_service['artwork'] }}" alt="Images">
                            <div class="services-text">
                                <br>
                                <h3 class="title"><a href="#">{{ $_service['name'] }}</a></h3>
                                <p class="services-txt">@ <b>KES {{ number_format($_service['price'], 0) }}</b> per return</p>
                                <br>
                                <a class="readon consultant discover" href="{{ route('w.f.return', ['id' => $_service['id'] ]) }}">
                                    File Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>