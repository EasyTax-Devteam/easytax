@php( $glabal_settings = \App\Models\User::getSettings() )
@php( $glabal_groups = \App\Models\User::getServiceGroups() )
<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- meta tag -->
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">
    <!-- responsive tag -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">
    <!-- Bootstrap v4.4.1 css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- flaticon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/flaticon.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.css') }}">
    <!-- off canvas css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/off-canvas.css') }}">
    <!-- magnific popup css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- Main Menu css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rsmenu-main.css') }}">
    <!-- nivo slider CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/inc/custom-slider/css/nivo-slider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/inc/custom-slider/css/preview.css') }}">
    <!-- spacing css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/rs-spacing.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"> <!-- This stylesheet dynamically changed from style.less -->
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <style>
        h1 {
            color: #ffffff;
            font-size: 60px !important;
        }

        .rs-slider.slider3 .content-part .sl-subtitle {
            color: #ffffff;
        }

        @media only screen and (max-width: 991px) {
            .logo-hd-holder {
                height: 100px !important;
            }
        }

        .nivo-directionNav {
            display: none !important;
        }

        .full-width-header .rs-header.style2 .topbar-area {
            background-color: #1f3369 !important;
        }

        .rs-slider.slider3 .desc {
            color: #f3f3f1;
        }

        .readon.consultant {
            border-radius: 18px 0px 20px 0px;
            color: #1e3666;
            background: #fffefe;
            font-size: 18px !important;
        }

        .service-bx {
            background: #f2f2f2;
            padding: 10px;
            height: 461px;
            border-radius: 10px;
        }

        .full-width-header .rs-header .menu-area .logo-area img {
            max-height: 60px;
        }

        .rs-services.home-style2 .services-item .services-icon img {
            height: 200px !important;
            width: 300px !important;
            border: solid 1px #ddd;
            border-radius: 10px;
        }

        @media only screen and (max-width: 991px) {
            .rs-header .menu-area .logo-area {
                top: 4px !important;
            }
        }

        @media only screen and (min-width: 991px) {
            .label-wrap {
                min-height: 20px;
            }

            .full-width-header .rs-header .menu-area .main-menu .rs-menu ul.nav-menu li a {
                height: 40px !important;
                line-height: 32px;
                border-radius: 0px !important;
                margin-top: 0px !important;
            }
        }

        .label-hint {
            font-style: italic;
            color: #498aca;
        }

        .input-hint {
            color: #f87601;
        }

        .mandaory-note {
            color: #ed2526;
            font-weight: 600;
        }

        .service-button {
            background-color: #1f3766 !important;
            border-color: #1f3766 !important;
            padding: 8px 30px !important;
            border-radius: 20px !important;
        }


        .rs-services.style3 .services-item .services-content .services-title,
        .rs-services.style5 .flip-box-inner .flip-box-wrap .front-part .front-content-part .front-title-part .title,
        .rs-services.style5 .flip-box-inner .flip-box-wrap .back-part .back-front-content .back-title-part .back-title,
        .rs-services.home-style2 .services-item .services-text .title,
        .rs-services.main-home .services-item .services-text .title {
            max-height: 70px;
            font-size: 17px;
        }

        .rs-checkout .full-grid .form-content-box .form-group .form-control-mod {
            border-bottom: 2px solid #dbd9d9 !important;
            border-radius: 50px !important;
            border-top: none !important;
            border-left: none !important;
            border-right: solid 2px #dbd9d9 !important;
        }

        .sec-sub-title {
            font-size: 18px;
            line-height: 30px;
            font-weight: 700;
            color: #498aca;
            margin: 0;
            position: relative;
            padding-top: 28px;
        }

        .required {
            color: red;
        }

        ::placeholder {
            color: #d0cccc !important;
        }


        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .my-float {
            margin-top: 16px;
        }
    </style>

</head>

<body class="defult-home">

    <div class="offwrap"></div>

    <!--Preloader start here-->
    <div id="pre-load">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class='loader-icon'><img src="{{ asset('assets/images/fav.png') }}" alt="Bizup Consulting Business"></div>
            </div>
        </div>
    </div>
    <!--Preloader area end here-->

    <!-- Main content Start -->
    <div class="main-content">


        <!--Full width header Start-->
        <div class="full-width-header">
            <!--Header Start-->
            @yield('navigation')
            <!--Header End-->
        </div>
        <!--Full width header End-->

        <!-- Slider Start -->
        @yield('slider')
        <!-- Slider End -->

        <!-- Premium Services Section Start -->
        @yield('premium')
        <!-- Premium Services Section End -->

        <!-- Services Section Start -->
        @yield('services')
        <!-- Services Section End -->

        <!-- About Section Start -->
        @yield('about')
        <!-- About Section Start -->

        <!-- Project Section Start -->
        @yield('works')
        <!-- Project Section End -->

        <!-- Testimonial Section Start -->
        @yield('reviews')
        <!-- Testimonial Section End -->


        <!-- Contact Section Start -->
        @yield('contactform')
        <!-- Contact Section End -->

    </div>
    <!-- Main content End -->

    <!-- Footer Start -->
    <footer id="rs-footer" class="rs-footer style1">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 md-mb-10">
                        <div class="footer-logo mb-40">
                            <a href="{{ route('w.index') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a>
                        </div>
                        <div class="textwidget white-color pb-40">
                            <p>We make tax filing a click away. All you have to do is tell us what kind of returns you would like to file, then our team will get to work</p>
                        </div>
                        <ul class="footer-social md-mb-30">
                            <li>
                                <a href="{{ $glabal_settings->facebook }}" target="_blank"><span><i class="fa fa-facebook"></i></span></a>
                            </li>
                            <li>
                                <a href="{{ $glabal_settings->twitter }}" target="_blank"><span><i class="fa fa-twitter"></i></span></a>
                            </li>

                            <li>
                                <a href="{{ $glabal_settings->linkedin }}" target="_blank"><span><i class="fa fa-linkedin"></i></span></a>
                            </li>

                            <li>
                                <a href="{{ $glabal_settings->instagram }}" target="_blank"><span><i class="fa fa-instagram"></i></span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 md-mb-10 pl-55 md-pl-15">
                        <h3 class="footer-title">Our Services</h3>
                        <ul class="site-map">
                            @foreach( $glabal_groups as $_one )
                            <li><a href="{{ route('w.s.category', ['id' => $_one['id']]) }}">{{ $_one['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 md-mb-10">
                        <h3 class="footer-title">Contact Info</h3>
                        <ul class="address-widget">
                            <li>
                                <i class="flaticon-location"></i>
                                <div class="desc">{{ $glabal_settings->address }}</div>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <div class="desc">
                                    <a href="tel:{{ $glabal_settings->phone }}">{{ $glabal_settings->phone }}</a>
                                </div>
                            </li>
                            <li>
                                <i class="flaticon-email"></i>
                                <div class="desc">
                                    <a href="mailto:{{ $glabal_settings->support_email }}">{{ $glabal_settings->support_email }}</a>
                                </div>
                            </li>
                            <li>
                                <i class="flaticon-clock-1"></i>
                                <div class="desc">
                                    {{ $glabal_settings->working_hours }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12">
                        <h3 class="footer-title">Newsletter</h3>
                        <p class="widget-desc white-color">Stay up to update with our latest news and products.</p>
                        <p>
                            <input type="email" name="EMAIL" placeholder="Your email address" required="">
                            <input type="submit" value="Subscribe Now">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-6 md-mb-10 text-lg-end text-center order-last">
                        <!-- <ul class="copy-right-menu">
                            <li><a href="{{ route('w.index') }}">Home</a></li>
                            <li><a href="{{ route('w.about') }}">About</a></li>
                            <li><a href="{{ route('w.u.login') }}">Client Area</a></li>
                            <li><a href="https://web.mail.eu-west-1.awsapps.com">Staff Mail</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul> -->
                    </div>
                    <div class="col-lg-6">
                        <div class="copyright text-lg-start text-center ">
                            <p>© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->


    <a href="https://api.whatsapp.com/send?phone={{ config('app.whatsapp') }}&text=Hi%20Admin%2C%20I%20need%20help%20with" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>

    <!-- start scrollUp  -->
    <div id="scrollUp" class="orange-color">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- End scrollUp  -->

    <!-- Search Modal Start -->
    <div class="modal fade search-modal" id="searchModal" tabindex="-1">
        <button type="button" class="close" data-bs-dismiss="modal">
            <span class="flaticon-cross"></span>
        </button>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="search-block clearfix">
                    <form>
                        <div class="form-group">
                            <input class="form-control" placeholder="Search Here..." type="text">
                            <button type="submit" value="Search"><i class="flaticon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal End -->


    <!-- modernizr js -->
    <script src="{{ asset('assets/js/modernizr-2.8.3.min.js') }}"></script>
    <!-- jquery latest version -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap v4.4.1 js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- op nav js -->
    <script src="{{ asset('assets/js/jquery.nav.js') }}"></script>
    <!-- isotope.pkgd.min js -->
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Skill bar js -->
    <script src="{{ asset('assets/js/skill.bars.jquery.js') }}"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- waypoints.min js -->
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <!-- counterup.min js -->
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <!-- magnific popup js -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Nivo slider js -->
    <script src="{{ asset('assets/inc/custom-slider/js/jquery.nivo.slider.js') }}"></script>
    <!-- contact form js -->
    <script src="{{ asset('assets/js/contact.form.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>


    <script>
        $('.insupolicies').change(function() {
            if (this.value === 'Yes') {
                $('.showhide').show();
            } else {
                $('.showhide').hide();
                $(".kip:checkbox").prop('checked', false);
            }
        });
        //
        setTimeout(() => {
            $('.check-status').show();
        }, 15000);

        checkStatus = function() {
            $.LoadingOverlay('show');
            $.ajax({
                method: 'post',
                data: 'data=none',
                url: "{{ route('w.f.checkStatus') }}",
                success: function(data) {
                    $.LoadingOverlay('hide');
                    if (data.hasOwnProperty('Url')) {
                        window.location.href = data.Url;
                        return;
                    }
                    if (data.hasOwnProperty('Err')) {
                        alert(data.Err);
                        return;
                    }
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay('hide');
                    console.log('ajax errors', xhr, status, error);
                    alert(error);
                }
            });
        }
    </script>

</body>

</html>