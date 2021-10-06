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
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/slick-theme.css">
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
    <script type="text/javascript" src="{!! URL::asset('js/jspdf.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/html2canvas.js') !!}"></script>

    @yield('css')
    <script>
        var base_url = "{{URL::to('/')}}";
    </script>

</head>

<body id="app-layout">
    <div class="wrapper" id="loading-container">
        <header id="theme-header" class="theme-header fixed-half">
            <div class="header-content">
                <div class="logo">
                    <a href="/"><img src="{{ url('img/logo_nav.png') }}" alt="UNIVERSAL PAINT"></a>
                </div>
                <div class="nav-wrapper">
                    @php 
                    $Page = \App\Post::find(1);
                    @endphp
                    @if(isset($Page->GetMetaData('social_media_icons', 'post')['meta_value']) && $Page->GetMetaData('social_media_icons', 'post')['meta_value'])                
                    <div class="header-contact">
                        <p class="smll-text">follow and like us on</p>
                        @foreach(explode(',', $Page->GetMetaData('social_media_icons', 'post')['meta_value']) as $icon)
                        <a href="{{\App\Post::findOrFail($icon)->button_link}}"><img src="{!! asset('img/post/') !!}/{!! \App\Post::findOrFail($icon)->featured_image; !!}"></a>   
                        @endforeach
                    </div>
                    @endif
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
                                    <a class="nav-link" href="/">Home</a>
                                </li>
                                <li class="nav-item dropdown product-after">
                                    <a class="nav-link " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products <i class="fa fa-caret-down"></i>
                                    </a>
                                    <div class="row dropdown-menu product-after"  aria-labelledby="navbarDropdownMenuLink">
                              

                                    <div class="container">
                                        <div class="row">
                                                <div class="col-lg-4">
                                                    <h2><a href="/product-category/all-products">All Products</a></h2>
                                                    <hr>
                                                    <a class="dropdown-item" href="/product-category/interior">Interior</a>
                                                    <a class="dropdown-item" href="/product-category/exterior">Exterior</a>
                                                    <a class="dropdown-item" href="/product-category/surface_preparation">Surface Preparation</a>
                                                    <a class="dropdown-item" href="/product-category/industrial">Industrial</a>
                                                    <div class="row dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="padding-bottom: 20px">
                                                <h2><a href="/product-category/brands">All Brands</a></h2>
                                                <hr>
                                                <!-- @if(!empty($brands))
                                                <div class="row  responsive-item"  >
                                                    @foreach($brands as $item)
                                                        @if($item->name == 'Other')
                                                        @else<a class="dropdown-item" style="overflow-wrap: break-word; white-space: initial;" href="/product-category/brands/{{$item->slug_name}}">{{$item->name}}</a>
                                                        @endif
                                                        @endforeach
                                                </div>
                                                @endif -->
                                                @php 
                                                $brands = \App\Brand::where('hide_brand',0)->get();
                                                @endphp 
                                                @if(!empty($brands))
                                                <div class="row">
                                                <hr>
                                                @for ($i = 0; $i < sizeof($brands); $i++)
                                                    @if ($i < 9)
                                                    @if($brands[$i]->name != 'Other' && $brands[$i]->name != 'Universal Paint')
                                                         <a class="dropdown-item" href="/product-category/brands/{{$brands[$i]->slug_name}}"> {{$brands[$i]->name}}</a>     
                                                    @endif
                                                    @endif
                                                @endfor
                                                </div>
                                                @endif
                                            </div> 
                                            <div class="col-lg-4 seventh-column-dropdown" @if(Request::is('cart')) style="margin-top: 70px !important;" @endif >
                                                @if(!empty($brands))
                                                <div class="row">
                                                @for ($i = 0; $i < sizeof($brands); $i++)
                                                    @if ($i > 8)        
                                                    <a class="dropdown-item" href="/product-category/brands/{{$brands[$i]->slug_name}}"> {{$brands[$i]->name}}</a>     
                                                    @endif
                                                @endfor
                                                </div>
                                                @endif
                                            </div> 
                                          
                                        </div>
                                     </div>                         
                                     
                                    
                                    </div>

                                </li>
                                <!-- <li class="nav-item regular-text">
                                    <a class="nav-link" href="/request-a-quote/">Request a Quote</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" href="/contact-us/">Contact us</a>
                                </li>
                                <li class="nav-item">
                                    @php  $cart_count = 0; @endphp
                                    @if(Session::has('gocart'))
                                    @php 
                                        $cart_items = Session::get('gocart');
                                        foreach($cart_items as $item) {
                                            $cart_count += count($item['product_details']);
                                        }
                                    @endphp 
                                    @endif
                                    <a class="nav-link cart-icon-link" href="/cart">Cart

                                    @if($cart_count > 0  && !Request::is('checkout'))
                                        ({{ $cart_count }})
                                    @endif
                                    
                                    </a>
                                    <a class="nav-link cart-icon-img" href="/cart"> <img class="cart-icon" src="{!! asset('img/cart-icon.png') !!}"> @if($cart_count > 0 && !Request::is('checkout'))
                                            ({{ $cart_count }})
                                            
                                            @endif</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div> <!-- nav-wrapper -->
            </div> <!-- header content -->
        </header>        
        @yield('content')
        <!-- Sixth Section -->
        <div id="sixth-section" style="background-image: url('{{ url('img/footer_img.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
            <div class="container">
                <div class="heading-bx">
                    <div class="thumbnail-desc">Get expert help</div>
                </div>
                <div class="block">
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">REQUEST PRODUCT BROCHURE</div>
                            <div class="desc">click to request a product</div>
                        </div>
                        <div class="btn-con">
                            @php 
                            $settings = \App\Settings::first();
                            $product_brochure = isset($settings["product_brochure_pdf"]) && !empty($settings["product_brochure_pdf"]) ? URL::to('/')."/img/product_brochure/".$settings["product_brochure_pdf"] : "";
                            @endphp 
                            @if(!empty($product_brochure))
                            <a href="{{$product_brochure}}" target="_blank" class="btns">Request now</a>
                            @else 
                            Request now
                            @endif 
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">HOW TO PAINT? <br> GUIDE & TIPS FOR PAINTING</div>
                            <div class="desc">See the proper way to paint</div>
                        </div>
                        <div class="btn-con">
                            <a href="/how-to-paint" class="btns">Read More</a>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">COLOR DEPOT</div>
                            <div class="desc">click here to see online color charts</div>
                        </div>
                        <div class="btn-con">
                            <a href="/color-swatches" target="_blank" class="btns">Read More</a>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="top-con">
                            <div class="ttl">PAINT CALCULATOR</div>
                            <div class="desc">click to compute how much paint you will need for your project</div>
                        </div>
                        <div class="btn-con">
                            <a href="/paint-calculator" target="_blank" class="btns">Calculate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <div class="top-con">
                    <div class ="col-lg-3 col-md-3 col-sm-12">
                        @php
                        $PostMetaData = \App\PostMetaData::where('meta_key','footer_left_col')->orWhere('meta_key','footer_right_col')->orWhere('meta_key','footer_mid_col')->paginate(10);
                        @endphp
                        @foreach($PostMetaData as $metadata)
                        @if($metadata->meta_key == 'footer_left_col' )
                        @php 
                        $postIDs = explode(',',$metadata->meta_value);
                        @endphp

                        @foreach($postIDs as $id)
                        @php
                        $id = (int)$id;
                        $post  = \App\Post::where('id',$id)->first();
                        @endphp
                        @if(!empty($post))
                        <div class="thumbnail-logo"><img src="{{ url('img/post/'.$post->featured_image) }}"></div>
                        @if($post->displayed_post_content == 1)
                        <div class="sml-txt">{!! $post->post_content !!}</div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                    </div>
                    <div class ="col-lg-6 col-md-6 col-sm-12">
                        @foreach($PostMetaData as $metadata)
                        @if($metadata->meta_key == 'footer_mid_col' )
                        @php 
                        $postIDs = explode(',',$metadata->meta_value);
                        @endphp

                        @foreach($postIDs as $id)
                        @php
                        $id = (int)$id;
                        $post  = \App\Post::where('id',$id)->first();
                        @endphp
                        @if(!empty($post))
                        <div class="text-con">
                            <img src="{{ url('img/post/'.$post->featured_image) }}">
                            @if($post->displayed_post_content == 1)
                            <div class="sml-txt">{!! $post->post_content !!}</div>
                            @endif
                        </div>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                    </div> 
                    <div class ="col-lg-3 col-md-3 col-sm-12">
                    <div class="text-con">                                                                      
                            <div class="sml-txt">
                                @foreach($PostMetaData as $metadata)
                                @if($metadata->meta_key == 'footer_right_col' )
                                @php 
                                $postIDs = explode(',',$metadata->meta_value);
                                @endphp

                                @foreach($postIDs as $id)
                                @php
                                $id = (int)$id;
                                $post  = \App\Post::where('id',$id)->first();
                                @endphp
                                @if(!empty($post))
                                <div class="txt_detail">
                                    <img src="{{ url('img/post/'.$post->featured_image) }}"> 
                                    @if($post->displayed_post_content == 1)
                                    <p class="txt_detail-info">
                                    {!! $post->post_content !!}
                                    </p>
                                    @endif
                                </div>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                            </div>
                    </div>  
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
<script src="/scripts/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
<script src="/js/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
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
            autoplay: true,
            fade: true,
            autoplaySpeed: 5000,
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
            autoplaySpeed: 5000,
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