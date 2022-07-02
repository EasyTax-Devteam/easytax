@php( $glabal_groups = \App\Models\User::getServiceGroups() )
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
        border: solid 1px #1e3666;
    }

    .rs-services.home-style2 .services-item {
        display: block;
    }

    .service-group {
        font-size: 33px !important;
        color: #478aca !important;
        font-weight: 500;
    }

    hr:not([size]) {
        height: 1.5px;
    }

    hr {
        background-color: #cdcdcd;
    }

    .view-more {
        border-radius: 20px !important;
        padding: 6px 19px !important;
        max-width: 352px !important;
        font-size: 15px !important;
        text-align: center !important;
        color: #ed2425 !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-left: 0px !important;
        border-color: #ed2425;
        border: solid;
    }
</style>
<div class="rs-services home-style2 gray-bg pt-100 pb-100 md-pt-70 md-pb-70" id="step-one">
    <div class="container">
        <div class="sec-title2 text-center md-left mb-20">
            <div class="sub-text">Step 1 - choose a service</div>
            <h2 class="title">Services Offered</h2>
        </div>
    </div>
    @foreach( $glabal_groups as $_group )
    @php( $group_services = \App\Models\User::getServicesByGroup($_group['id']) )
    <div class="container">
        <div class="sec-title2 md-left mb-40">
            <a href="{{ route('w.s.category', ['id' => $_group['id']]) }}">
                <h2 class="title service-group">{{ $_group['name'] }}</h2>
            </a>

            <hr>
        </div>
        <div class="row y-middle">
            @foreach( $group_services as $key => $_service )
            @if( $key <= 2 ) <div class="col-lg-4  md-mb-50">
                <div class="services-item mb-45 text-center">
                    <div class="services-icon service-bx">
                        <img src="{{ $_service['artwork'] }}" alt="Images">
                        <div class="services-text">
                            <br>
                            <h3 class="title"><a href="{{ route('w.s.service', ['id' => $_service['id']]) }}">{{ $_service['name'] }}</a></h3>
                            <p class="services-txt">from <b>KES {{ number_format($_service['price'], 0) }}</b></p>
                            <br>
                            <a class="readon consultant discover" href="{{ route('w.s.service', ['id' => $_service['id']]) }}">
                                Request Service
                            </a>
                        </div>
                    </div>
                </div>
        </div>
        @endif

        @if($key == count($group_services) - 1)
        <div class="sec-title2 text-center md-left">
            <a class="consultant view-more" href="{{ route('w.s.category', ['id' => $_group['id']]) }}"> View More Services in this group</a>
        </div>

        @endif
        @endforeach
    </div>
</div>
<br>
<br>
@endforeach

</div>