<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="descrtiption" content="">
    <meta name="author" content="">
    <!--Start Use for sharing-->
    <meta property="fb:app_id" content="1021079168241951" />
    <meta property="og:title" content="@yield('ogtitle')">
    <meta property="og:type" content="article" />
    <meta property="og:description" content="@yield('ogdescription')">
    <meta property="og:image:url" content="@yield('ogimg')">
    <meta property="og:image:alt" content="@yield('ogproduct')">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:type" content="image/gif">
    <meta property="og:image:width" content="450" />
    <meta property="og:image:height" content="298" />
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="ia:markup_url" content="{{ URL::current() }}">


    <!--End Use for sharing-->
    <title>Universal Paint</title>
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Styles -->
    <link href="{!! URL::asset('css/home.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! URL::asset('static/plugins/slickslider/slick/slick.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! URL::asset('static/bootstrap/fonts/lucidagrande.css') !!}" rel='stylesheet' type='text/css'>
    <link href="{!! URL::asset('static/bootstrap/fonts/lucidasans.css') !!}" rel='stylesheet' type='text/css'>
    <link href="{!! URL::asset('static/plugins/slickslider/slick/slick-theme.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! URL::asset('static/plugins/datepicker/datepicker3.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <!-- <link href="{!! URL::asset('static/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.jpg') }}" title="Favicon">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    @yield('css')
    <script>
        var base_url = "{{URL::to('/')}}";
    </script>

</head>

<body id="app-layout">
    <div class="wrapper" id="loading-container">
        <header id="theme-header" class="theme-header fixed-half">
            <div class="header-content">
                <!-- <div class="logo">
                    <a href="/"><img src="{{ url('img/logo_nav.png') }}" alt="UNIVERSAL PAINT"></a>
                </div>
                <div class="nav-container">
                    <div class="navigation-social">
                        <div id="header-contact">
                            <p class="smll-text">follow and like us on</p>
                            <a href="https://www.facebook.com/"><img src="{{ url('img/FB.png') }}"></a>
                            <a href="https://www.facebook.com/"><img src="{{ url('img/IG.png') }}"></a>
                        </div>
                        <div id="main-nav">
                            <a href="/">Home</a>
                            <div class="subnav">
                                <button class="subnavbtn">Products <i class="fa fa-caret-down"></i></button>
                                <div class="subnav-content">
                                  <a href="/product-category/interior">Interior</a>
                                  <a href="/product-category/exterior">Exterior</a>
                                  <a href="/product-category/surface-preparation">Surface Preaparation</a>
                                  <a href="/product-category/industrial">Industrial</a>
                                </div>
                              </div>                             
                            <a href="#">Request a Quote</i> </a>
                            <a href="#">Contact Us</a>       
                        </div> 
                    </div>
                </div> -->
                <div class="logo">
                    <a href="/"><img src="{{ url('img/logo_nav.png') }}" alt="UNIVERSAL PAINT"></a>
                </div>
                <div class="nav-wrapper">
                    <div class="header-contact">
                        <p class="smll-text">follow and like us on</p>
                        <a href="https://www.facebook.com/"><img src="{{ url('img/FB.png') }}"></a>
                        <a href="https://www.facebook.com/"><img src="{{ url('img/IG.png') }}"></a>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="header-contact mobile">
                                <p class="smll-text">follow and like us on</p>
                                <a href="https://www.facebook.com/"><img src="{{ url('img/FB.png') }}"></a>
                                <a href="https://www.facebook.com/"><img src="{{ url('img/IG.png') }}"></a>
                            </div>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="/product-category/interior">Interior</a>
                                        <a class="dropdown-item" href="/product-category/exterior">Exterior</a>
                                        <a class="dropdown-item" href="/product-category/surface-preparation">Surface Preparation</a>
                                        <a class="dropdown-item" href="/product-category/industrial">Industrial</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Request a qoute</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact us</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div> <!-- nav-wrapper -->
            </div> <!-- header content -->
        </header>
        @yield('content')
        <!-- Sixth Section -->
        <div id="sixth-section" style="background-image: url('{{ url('img/footer_bgs.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
            <div class="container">
                <div class="heading-bx">
                    <div class="thumbnail-desc">get expert help</div>
                </div>
                <div class="block">
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">REQUEST COLOR BROCHURES</div>
                            <div class="desc">click to request a brochure</div>
                        </div>
                        <div class="btn-con">
                            <a href="#" class="btns">Read More</a>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">HOW TO PAINT GUIDE & TIPS FOR PAINTING</div>
                            <div class="desc">See the proper way to paint</div>
                        </div>
                        <div class="btn-con">
                            <a href="#" class="btns">Read More</a>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">COLOR CHARTS</div>
                            <div class="desc">click here to see online color charts</div>
                        </div>
                        <div class="btn-con">
                            <a href="#" class="btns">Read More</a>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">PAINT CALCULATOR</div>
                            <div class="desc">click to compute how much paint you will need for your project</div>
                        </div>
                        <div class="btn-con">
                            <a href="#" class="btns">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <div class="top-con">
                    <div class="thumbnail-logo"><img src="{{ url('img/logo_nav.png') }}"></div>
                    <div class="text-con">
                        <img src="{{ url('img/001-placeholder.png') }}">
                        <div class="sml-txt">53 F. Pasco Ave, Santolan, Pasig, 1610 Metro Manila, Philippine</div>
                    </div>
                    <div class="text-con">
                        <img src="{{ url('img/002-phone-call.png') }}">
                        <div class="sml-txt">+632 8646 8701, +632 8646 3571 </br> +632 8646 8967,+63917 106 4579 </br>fax no. +632 8646 8329</div>
                    </div>
                </div>
                <div class="bot-con">
                    <div class="footer-terms">
                        © 2020 www.universalpaint.net. All rights reserved. &nbsp;&nbsp;
                        <a href="#">Site Map</a>
                        &nbsp;|&nbsp;
                        <a href="#">Terms of Use</a>
                        &nbsp;|&nbsp;
                        <a href="#">Privacy Policy</a>
                    </div>
                    <div class="thumbnail-logo"> <img src="{{ url('img/itworksm.png') }}"></div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ URL::asset('static/plugins/slickslider/slick/slick.js') }}"></script>
<script src="scripts/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@yield('scripts')

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#first-section .banner-content').slick({
            arrows: true,
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            fade: true,
            autoplaySpeed: 2000,
            pauseOnHover: false,
            pauseOnFocus: false,
            responsive: [{
                breakpoint: 1045,
                settings: {
                    arrows: false,
                }
            }]
        })

        jQuery('#fourth-section .block').slick({
            arrows: true,
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            fade: true,
            autoplaySpeed: 2000,
            pauseOnHover: false,
            pauseOnFocus: false,
            responsive: [{
                breakpoint: 1045,
                settings: {
                    arrows: false,
                    dots: false,
                }
            }]
        })
    });
</script>

</body>

</html>