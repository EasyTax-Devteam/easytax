@php( $glabal_settings = \App\Models\User::getSettings() )
@php( $glabal_services = \App\Models\User::getServices() )
<header id="rs-header" class="rs-header style2 header-transparent">
    <style>
        .truncate {
            max-width: 100px;
            display: inline-block;
            /* overflow: hidden; */
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .customer-login{
            padding: 13px!important;
            border: solid 1px #800000!important;
            color:  #800000!important;
        }
        .staff-login{
            padding: 13px!important;
            border: solid 0px #800000!important;
            color:  #800000!important;
        }
        .full-width-header .rs-header .menu-area .main-menu .rs-menu ul.nav-menu li a {
            height: 55px;
            line-height: 32px;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
    <!-- Topbar Area Start -->
    <div class="topbar-area style1">
        <div class="container custom">
            <div class="row y-middle">
                <div class="col-lg-7">
                    <div class="topbar-contact">
                        <ul>
                            <li>
                                <i class="flaticon-email"></i>
                                <a href="mailto:{{ $glabal_settings->email }}">{{ $glabal_settings->email }}</a>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <a href="tel:{{ $glabal_settings->phone }}"> {{ $glabal_settings->phone }}</a>
                            </li>
                            <li>
                                <span class="truncate">
                                    <i class="flaticon-location"></i>
                                    {{ $glabal_settings->address }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 text-right">
                    <div class="toolbar-sl-share">
                        <ul>
                            <li class="opening"> <em><i class="flaticon-clock"></i>{{ $glabal_settings->working_hours }}</em> </li>
                            <li><a href="{{ $glabal_settings->facebook }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ $glabal_settings->twitter }}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ $glabal_settings->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar Area End -->

    <!-- Menu Start -->
    <div class="menu-area menu-sticky">
        <div class="container custom">
            <div class="row-table">
                <div class="col-cell header-logo">                                  
                    <div class="logo-area">
                        <a href="{{ route('w.index') }}">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo">  
                        </a>
                    </div>
                </div>
                <div class="col-cell">
                    <div class="rs-menu-area">
                        <div class="main-menu">
                            <nav class="rs-menu hidden-md">
                                <ul class="nav-menu">
                                    <li class="">
                                        <a href="{{ route('w.index') }}">Home</a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Services</a>
                                        <ul class="sub-menu">
                                            @foreach( $glabal_services as $_service  )
                                                <li><a href="{{ route('w.f.return', ['id' => $_service['id'] ]) }}">{{ $_service['name'] }}</a></li>
                                            @endforeach
                                            <li><a href="{{ route('w.f.return', ['id' => 0]) }}">View all services</a></li>
                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('w.about') }}">About</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('w.index') }}">Blog</a>
                                    </li>
                                    <li >
                                        <a class="staff-login" target="_blank" href="https://web.mail.eu-west-1.awsapps.com/">Staff Mail</a>
                                    </li>
                                    <li >
                                        <a class="customer-login" href="{{ route('w.u.login') }}">Client Area</a>
                                    </li>
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-cell">
                    <div class="expand-btn-inner">
                        <ul>
                            <li class="humburger">
                                <a id="nav-expander" class="nav-expander bar" href="#">
                                    <div class="bar">
                                        <span class="dot1"></span>
                                        <span class="dot2"></span>
                                        <span class="dot3"></span>
                                        <span class="dot4"></span>
                                        <span class="dot5"></span>
                                        <span class="dot6"></span>
                                        <span class="dot7"></span>
                                        <span class="dot8"></span>
                                        <span class="dot9"></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->
    <!-- Canvas Menu start -->
    <nav class="right_menu_togle hidden-md">
        <div class="close-btn">
            <a id="nav-close" class="nav-close">
                <div class="line">
                    <span class="line1"></span>
                    <span class="line2"></span>
                </div>
            </a>
        </div>
        <div class="canvas-logo">
            <a href="{{ route('w.index') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="logo"></a>
        </div>
        <div class="offcanvas-text">
            <p>We make tax filing a click away. All you have to do is tell us what kind of returns you would like to file, then our team will get to work.</p>
        </div>
        <div class="media-img">
            <img src="{{ asset('assets/images/off2.jpg') }}" alt="Images">
        </div>
        <div class="canvas-contact">
            <div class="address-area">
                <div class="address-list">
                    <div class="info-icon">
                        <i class="flaticon-location"></i>
                    </div>
                    <div class="info-content">
                        <h4 class="title">Address</h4>
                        <em>{{ $glabal_settings->address }}</em>
                    </div>
                </div>
                <div class="address-list">
                    <div class="info-icon">
                        <i class="flaticon-email"></i>
                    </div>
                    <div class="info-content">
                        <h4 class="title">Email</h4>
                        <em><a href="mailto:{{ $glabal_settings->support_email }}">{{ $glabal_settings->support_email }}</a></em>
                    </div>
                    </div>
                <div class="address-list">
                    <div class="info-icon">
                        <i class="flaticon-call"></i>
                    </div>
                    <div class="info-content">
                        <h4 class="title">Phone</h4>
                        <em>{{ $glabal_settings->phone }}</em>
                    </div>
                </div>
            </div>
            <ul class="social">
                <li><a href="{{ $glabal_settings->facebook }}"><i class="fa fa-facebook"></i></a></li>
                <li><a href="{{ $glabal_settings->twitter }}"><i class="fa fa-twitter"></i></a></li>
                <li><a href="{{ $glabal_settings->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
    </nav>
    <!-- Canvas Menu end -->

    <!-- Canvas Mobile Menu start -->
    <nav class="right_menu_togle mobile-navbar-menu" id="mobile-navbar-menu">
        <div class="close-btn">
            <a id="nav-close2" class="nav-close">
                <div class="line">
                    <span class="line1"></span>
                    <span class="line2"></span>
                </div>
            </a>
        </div>
        <ul class="nav-menu">
            <li class="">
                <a href="{{ route('w.index') }}">Home</a>
            </li>
            <li class="">
                <a href="{{ route('w.f.return', ['id' => 0]) }}">File Returns</a>
            </li>
            <li class="">
                <a href="{{ route('w.about') }}">About</a>
            </li>
            <li class="">
                <a href="{{ route('w.index') }}">Blog</a>
            </li>
            <li >
                <a class="staff-login" target="_blank" href="https://web.mail.eu-west-1.awsapps.com/">Staff Mail</a>
            </li>
            <li>
                <a class="customer-login" href="{{ route('w.u.login') }}">Client Area</a>
            </li>
        </ul> 
        
        <div class="canvas-contact">
                <div class="address-area">
                    <div class="address-list">
                        <div class="info-icon">
                            <i class="flaticon-location"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="title">Address</h4>
                            <em>{{ $glabal_settings->address }}</em>
                        </div>
                    </div>
                    <div class="address-list">
                        <div class="info-icon">
                            <i class="flaticon-email"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="title">Email</h4>
                            <em><a href="mailto:{{ $glabal_settings->support_email }}">{{ $glabal_settings->support_email }}</a></em>
                        </div>
                    </div>
                    <div class="address-list">
                        <div class="info-icon">
                            <i class="flaticon-call"></i>
                        </div>
                        <div class="info-content">
                            <h4 class="title">Phone</h4>
                            <em>{{ $glabal_settings->phone }}</em>
                        </div>
                    </div>
                </div>
        </div>
    </nav>
    <!-- Canvas Menu end -->
</header>