<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="descrtiption" content="">
	<meta name="author" content="">
	<!--Start Use for sharing-->
	<meta property="og:title" content="@yield('ogtitle')">
	<meta property="og:description" content="@yield('ogdescription')">
	<meta property="og:type" content="image/jpeg">
	<meta property="og:url" content="@yield('ogurl')" >
	<meta property="og:image" content="@yield('ogimg')" >
    <!--End Use for sharing-->
    <title>G&G Glamour</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href="{!! asset('static/bootstrap-slider-master/dist/css/bootstrap-slider.css') !!}" rel='stylesheet' type='text/css'>
    <!-- <link href="{!! asset('static/bootstrap-slider-master/dist/css/bootstrap-slider.min.css') !!}" rel='stylesheet' type='text/css'> -->
    <!-- <script type="text/javascript" src="{!! asset('static/bootstrap-slider-master/dist/bootstrap-slider.min.js') !!}"></script> -->

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="{!! asset('css/home.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('static/plugins/slickslider/slick/slick.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('static/bootstrap/fonts/lucidagrande.css') !!}" rel='stylesheet' type='text/css'>
    <link href="{!! asset('static/bootstrap/fonts/lucidasans.css') !!}" rel='stylesheet' type='text/css'>
    <link href="{!! asset('static/plugins/slickslider/slick/slick-theme.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('static/plugins/datepicker/datepicker3.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.jpg') }}" title="Favicon">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        .checked {
            /*color: #1b1b1b;*/
           color:#FFD700;
        }
        .fa-star-o{
            /*color:#333333;*/
            color:#FFD700;
        }
        .list:hover{
            color:#fff;
        }
    	.middle_content .title {
        	font-size: 26px !important;
    	}
    </style>
    <script>
        var base_url ="{{URL::to('/')}}";
        
	</script>
</head>
<body id="app-layout">
    <div class="wrapper" id="loading-container">
        <div id="loading-image">
            <img src="{{ URL::asset('img/materials/Loading.gif') }}" alt="" style="width: 200px;">
        </div>
        <div id="header">
            <div class="header-content">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 site-logo">
                        <a href="{{URL::to('/')}}"><img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo"></a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    	<div class="right-search">
                    	    @if(empty($uid))
                                <a data-toggle="modal" data-target="#customer_login_modal">
                                    <div class="regtxt">Sign-in</div> 
                                </a>
                                <span class="inline-divider">|</span>
                                <a href="{{URL::to('/register')}}" >
                                    <div class="regtxt">Register</div> 
                                </a>
                            @else
                                <a href="#" target="_blank"> 
                                    <div class="regtxt">
                                        @if(Session::has('display_name'))
                                        Welcome, {{ Session::get('display_name')}}!
                                        @endif
                                    </div> 
                                </a>
                                <span class="inline-divider"></span>
                                <ul class="profile-nav">
                                    <li><a href="#"><button type="button" class="btn btn-primary btn-block btn-flat"><i class="fa fa-user"></i></button></a>
                                        <ul class="profile-nav-submenu">
                                            <li><a href="{{URL::to('/customer/profile')}}" class="list">Profile</a></li>
                                            <li><a href="{{URL::to('/customer/wishlist')}}" class="list">Wishlist</a></li>
                                            <li><a href="{{URL::to('/customer/manage-password')}}" class="list">Change Password</a></li>
                                            <li><a href="{{URL::to('/logout')}}" class="list">Log out</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            @endif
                        </div>
                        <div class="clear"></div>
                        <div class="search-container">
                            <form id="getProducts"  method="get" action="/products/search#prodlist">
                                <div class="input-group search-box">
                                    @if(isset($sort))
                                        <input type="hidden" class="form-control" name="sort" value="{{ $sort }}">
                                    @endif
                                    <input type="text" class="form-control" name="s" placeholder="Find Product">
                                    <span class="input-group-addon" id="submitprod"><i class="fa fa-search"></i></span>
                                </div>
                            </form>
                            <ul class="scl-md">
                                <li>
                                    @if (empty($uid))
                                    <a href="#" data-toggle="modal" data-target="#register_new_account"><i class="fa fa-fw fa-shopping-cart" aria-hidden="true"></i></a>
                                    @elseif(session()->get('cart') == true)
                                    <a href="{!! URL::to('/cart') !!}"><i class="fa fa-fw fa-shopping-cart" aria-hidden="true"></i></a>
                                    @else
                                    <a href="{!! URL::to('/products/search?s=#prodlist') !!}"><i class="fa fa-fw fa-shopping-cart" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if(!empty($uid) && session()->has('cart'))
	                                    @php
	                                    	$totcart = '0';
	                                    	$cart = session()->get('cart');
	                                    	$countcart = count($cart);
	                                    @endphp
	                                    @for($c=0;$c<$countcart;$c++)
	                                     	@php
	                                    		$totcart += $cart[$c]['qty'];
	                                    	@endphp
	                                    @endfor
                                    	<span id="itemCount">{{$totcart}}</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="navbar">
                <div id="sticky-nav" class="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#toggle-navbar-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- collapse navigations -->
                    <div class="collapse navbar-collapse text-center" id="toggle-navbar-collapse">
                        <div class="nav-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-child"><a href="{{URL::to('/brands')}}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">BRANDS</a>
                                    <ul class="dropdown-menu">
                                        @foreach(\App\Brand::where('id','<>',1)->orderBy('name', 'asc')->get() as $list)
                                            <li><a href="/brand/{{$list->slug_name}}">{{$list->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-child"><a href="{{URL::to('/category')}}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CATEGORY</a>
                                    <ul class="dropdown-menu">
                                        @foreach(\App\Category::with('SubCategory')->where('parent_id','=', 0)->orderBy('name', 'asc')->get() as $getCatName)
                                        {{-- */$categoryParent = \App\Category::where('parent_id',$getCatName->id)->count();/* --}}
                                            <li><a href="#" class="cat-select" data-gettype="ps" data-filter-type="category" data-value="{{ $getCatName->slug_name }}">{{ ucwords($getCatName->name) }}    </a> <input type="hidden" value="{{ $getCatName->slug_name }}" class="cat-select" data-gettype="ps" data-filter-type="category" /> {!! $categoryParent > 0 ? '<i class="fa fa-angle-right"></i>':'' !!}
                                                @if($categoryParent > 0)
                                                <ul class="dropdown-menu">
                                                    @foreach($getCatName->SubCategory as $getSubCat)
                                                        <li><a href="#" data-value="{{ $getSubCat->slug_name }}" class="cat-select" data-gettype="ps" data-filter-type="category">{{ ucwords($getSubCat->name) }}</a></li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                        @endforeach
<!--                                         <li class="li-list-btn">
                                            <div class="prdct-btn">
                                                <a href="{{URL::to('/products/search?s=#prodlist')}}" tabindex="-1"><button class="button button--aylen" tabindex="-1">See all products >></button></a>
                                            </div>
                                        </li> -->
                                    </ul>
                                </li>
                                <li class="nav-child"><a href="{{URL::to('/products')}}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SHOP</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{URL::to('/products/search?s=sale#prodlist')}}" class="prod-sale" data-value="sale ?  1" data-gettype="ps" data-filter-type="product">Sale</a></li>
                                        <li><a href="{{URL::to('/products')}}" class="prod-sale" data-value="sale ?  1" data-gettype="ps" data-filter-type="product">Hot Deals</a></li>
                                        <li><a href="{{URL::to('/products/search?s=#prodlist')}}" class="prod-sale" data-value="sale ?  1" data-gettype="ps" data-filter-type="product">All Products</a></li>
                                    </ul>
                                </li>
                                <li class="nav-child"><a data-toggle="dropdown" role="button" aria-haspopup="true" >ABOUT</a>
                                    <ul class="dropdown-menu">
                                        @foreach(\App\PostMetaData::where('meta_key', '=', 'footer_left_col')->orWhere('meta_key','=', 'footer_right_col')->get() as $getPage)
                                            @if(empty($getPage->paste_lnk))
                                            <li><a href="{{ url('single-page',$getPage->display_name) }}">{{$getPage->display_name}}</a></li>
                                            @else
                                            <li><a href="{{ url::to('/',$getPage->paste_lnk) }}">{{$getPage->display_name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{URL::to('/contact-us')}}">CONTACT US</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- collapse navigations -->
                </div>
            </nav>
        </div>
        @yield('content')
        <div id="footer">
            <div class="container">
            <div class="row">                                     
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="sub-ttl">The Company:</div>
                    <div class="sub-ttl-list">
                        @if($footerlinks_left)
                            @foreach($footerlinks_left as $fll)
                                @php
                                    $pastedlink = $fll->paste_lnk;
                                    $lnk = URL::to('/single-page').'/'.$fll->display_name;
                                @endphp
                                
                                @if(!empty($pastedlink))
                                    @if(filter_var($pastedlink, FILTER_VALIDATE_URL) === FALSE)
                                        @php
                                            $lnk = URL::to('/').'/'.$pastedlink;
                                        @endphp
                                    @else
                                        @php
                                            $lnk = $pastedlink;
                                        @endphp
                                    @endif
                                @endif
                                <div class="sub-ttl-list-item"><a href="{{$lnk}}">{{$fll->display_name}}</a></div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="sub-ttl">Our Categories:</div>
                    <div class="sub-ttl-list">
                        
                        @foreach(\App\Category::with('SubCategory')->where('parent_id','=', 0)->orderBy('name', 'asc')->get() as $getCatName)
                        {{-- */$categoryParent = \App\Category::where('parent_id',$getCatName->id)->count();/* --}}
                            <div class="sub-ttl-list-item"><a href="#" class="cat-select" data-gettype="ps" data-filter-type="category" data-value="{{ $getCatName->slug_name }}">{{ ucwords($getCatName->name) }}</a></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="sub-ttl">Customer Service:</div>
                    <div class="sub-ttl-list">
                        @if($footerlinks_right)
                            @foreach($footerlinks_right as $flr)
                                @php
                                    $pastedlink = $flr->paste_lnk;
                                    $lnk = URL::to('/single-page').'/'.$flr->display_name;
                                @endphp
                                @if(!empty($pastedlink))
                                    @if(filter_var($pastedlink, FILTER_VALIDATE_URL) === FALSE)
                                        @php
                                            $lnk = URL::to('/').'/'.$pastedlink;
                                        @endphp
                                    @else
                                        @php
                                            $lnk = $pastedlink;
                                        @endphp
                                    @endif
                                @endif
                                <div class="sub-ttl-list-item"><a href="{{$lnk}}">{{$flr->display_name}}</a></div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="footer-logo col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="{{URL::to('/')}}"><img src="{{ URL::asset('img/logo3.png') }}" class="logo"></a>
                    </div>
                    <div class="social-icon">
                        <div class="icon-item"><a  target="_blank" href="{!! \App\PostMetaData::where('display_name','=','Facebook')->first()->paste_lnk !!}"><img src="{{ URL::asset('img/icons/large-001-facebook.png') }}" class="logo"></a></div>
                        <!-- <div class="icon-item"><a href=""><img src="{{ URL::asset('img/icons/social_media_icon_004.png') }}" class="logo"></a></div> -->
                        <div class="icon-item"><a target="_blank" href="{!! \App\PostMetaData::where('display_name','=','Instagram')->first()->paste_lnk !!}"><img src="{{ URL::asset('img/icons/large-002-instagram.png') }}" class="logo"></a></div>
                        <!-- <div class="icon-item"><a href=""><img src="{{ URL::asset('img/icons/social_media_icon_002.png') }}" class="logo"></a></div> -->
                        <div class="icon-item"><a target="_blank" href="{!! \App\PostMetaData::where('display_name','=','Shopee')->first()->paste_lnk !!}"><img src="{{ URL::asset('img/icons/large-001-shopee.png') }}" class="logo"></a></div>
                    </div>
                    <div class="input-group search-box newsletter-btn">
                        <input type="text" class="form-control subs" id="newsletter_email" placeholder="Subscribe to get our promos!">
                        <div class="nwltr-btn"><span class="input-group-addon"><i class="fa fa-angle-right"></i></span></div>
                    </div>
                    <div class="payment-icon">
                        <div class="payment-item"><img src="{{ URL::asset('img/icons/payment_001.png') }}" class="logo"></div>
                        <div class="payment-item"><img src="{{ URL::asset('img/icons/payment_002.png') }}" class="logo"></div>
                        <div class="payment-item"><img src="{{ URL::asset('img/icons/payment_003.png') }}" class="logo"></div>
                    </div>
                </div>
            </div>
                <div class="divider"></div> 
                <div class="powered">© Copyright <?php echo date("Y"); ?>, All Rights Reserved,  Powered by <a href="http://itworkserv.com/" target="_blank"><img style="vertical-align: middle;" src="https://itworkserv.com/wp-content/uploads/2018/04/itw_logo_white.png" alt="iTWorks Global Solutions" width="110"></a>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog"> <!-- modal container -->
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content custom-modal" style="background: url({{ URL::asset('img/modal/pop_bg_001.png') }});">
                    <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <div class="modal-membership">
                        <div class="top">
                            <img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
                            <div class="tagline">PREMIUM MEMBERSHIP</div>
                        </div>
                        <div class="bottom">
                            <div class="title">Be our next Partner</div>
                            <div class="desc">Lorem ipsum dolor sit amet, risus pellentesque est quis dolor eros accumsan, pellentesque vestibulum neque et arcu eget at, risus venenatis vivamus luctus, suspendisse erat non tellus aliquam, donec tempus. Ante dolore ac tellus, a porta fermentum mattis, maecenas mi, nec blandit sit dis torquent in pellentesque, class sed donec aliquet.</div>
                            <div class="input-group search-box">
                                <input type="text" class="form-control">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign Me Up!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- close modal container -->
    <div id="myAnnouncement" class="modal fade" role="dialog"> <!-- modal container -->
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content custom-modal" style="background: url({{ URL::asset('img/modal/pop_bg_002.png') }});">
                    <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <div class="modal-announce">
                        <div class="top">
                            <img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
                        </div>
                        <div class="bottom">
                            <div class="title">WELCOME TO OUR NEW WEBSITE!</div>
                            <div class="desc">Lorem ipsum dolor sit amet, risus pellentesque est quis dolor eros accumsan, pellentesque vestibulum neque et arcu eget at, risus venenatis vivamus luctus, suspendisse erat non tellus aliquam,</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- close modal container -->
    <div id="myContactUs" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content custom-modal" style="background: url({{ URL::asset('img/modal/pop_bg_003.png') }});">
                    <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <div class="modal-contact">
                        <div class="top">
                            <img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
                        </div>
                        <div class="bottom">
                             <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                 <div class="map">
                                    <div class="title">MAP</div>
                                    <div class="map-img"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3859.986897812066!2d120.98336700000002!3d14.656685000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x185d2e010b4a3d33!2sAraneta+Square!5e0!3m2!1sen!2ssg!4v1521193893934" width="550" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                                 </div>
                             </div>
                             <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                 <div class="inquery">
                                    <div class="title">FOR INQUIRY</div>
                                    <form action="{{ URL::action('User\ContactUsController@contact_form') }}" method="post" accept-charset="UTF-8">
                                    <form id="inquiry_form">
                                    	<div class="form-group contact_us_msg">
                          				</div>
										{!! csrf_field() !!}
                                    	<div class="input-group search-box">
	                                        <input type="text" id="name" name="fullname" placeholder="Name" class="form-control" placeholder="Name">
	                                        <input type="text" id="contactnumber" name="contactnumber" class="form-control" placeholder="Contact">
	                                        <input type="text" id="emailadd" name="emailadd" class="form-control" placeholder="Email">
	                                        <textarea class="form-control"  id="messagecontact" name="messagecontact" placeholder="Your Message Here!!!"></textarea>
	                                        <button type="button" class="btn btn-primary btn-block btn-flat" id="send_contactus_btn">Send</button>
	                                    </div>
                                    	
                                    </form>
                                     
                                 </div>
                             </div> -->
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="address">
                                    <div class="house text">Unit T8 3rd Floor Araneta, Square Mall Monumento, Caloocan City</div>
                                    <div class="number">
                                        <div class="list text">Landline: (02) 366 44 45</div>
                                        <div class="list text">Smart: 0998 790 16 00</div>
                                        <div class="list text">Globe: 0977 834 81 19</div>
                                        <div class="list text">Sun: 0922 819 98 84</div>
                                    </div>
                                    <div class="email text">glamour.mihs@gmail.com</div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- close modal container -->
    
    <div id="subscriber_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
        <div class="modal-dialog">
            <!-- Modal content-->
            <!-- <div class="modal-content custom-modal" style="background: url({{ URL::asset('img/modal/pop_bg_003.png') }});"> -->
            <div class="modal-content custom-modal">
                    <button type="button" class="close custom-close-modal" data-dismiss="modal">X</button>
                <div class="modal-body">
                    <div class="modal-contact">
                        <div class="top">
                            <img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
                        </div>
                        <div class="middle_content">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 subscriber_msg">
                                 
                             </div>
                        </div>
                        <!-- <div class="bottom">
                             
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="address">  
                                    <div class="house text">Unit T8 3rd Floor Araneta, Square Mall Monumento, Caloocan City</div>
                                    <div class="number">
                                        <div class="list text">Landline: (02) 366 44 45</div>
                                        <div class="list text">Smart: 0998 790 16 00</div>
                                        <div class="list text">Globe: 0977 834 81 19</div>
                                        <div class="list text">Sun: 0922 819 98 84</div>
                                    </div>
                                    <div class="email text">glamour.mihs@gmail.com</div>
                                 </div>
                             </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- close modal container -->
    
    
   
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script type="text/javascript" src="{{ URL::asset('static/plugins/slickslider/slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('static/bootstrap-slider-master/dist/bootstrap-slider.js') }}"></script>
     <script type="text/javascript" src="{{URL::asset('static/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{URL::asset('js/app.js')}}"></script>
    <script type="text/javascript">
      
        jQuery(window).load(function(){
     jQuery('#loading-image').fadeOut();
});
        jQuery(document).ready(function(){
            jQuery('.testi-main').slick ({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 300,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 1,
                slidesToScroll: 1,  
                focusOnSelect: true,
                fade: true,
                asNavFor: '.testi-heads'
            });
        });
        jQuery(document).ready(function(){
            jQuery('.testi-heads').slick ({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 300,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 5,
                slidesToScroll: 1,
                centerMode: true,
                focusOnSelect: true,
                asNavFor: '.testi-main'
            });
        });
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.product-main').slick ({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,  
                focusOnSelect: true,
                fade: true,
                asNavFor: '.product-images'
            });
        });
        jQuery(document).ready(function(){
            jQuery('.product-images').slick ({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                centerMode: false,
                focusOnSelect: true,
                asNavFor: '.product-main'
            });
        });
    </script>
    <script>    
        $('.base-zoom')
            .on('mouseover', function(){
                $(this).children('.photo-zoom').css({'transform': 'scale('+ $(this).attr('data-scale') +')'});
            })
            .on('mouseout', function(){
                $(this).children('.photo-zoom').css({'transform': 'scale(1)'});
            })
            .on('mousemove', function(e){
                $(this).children('.photo-zoom').css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +'%'});
            })
            // tiles set up
            .each(function(){
                $(this)
                // add a photo-zoom container
                .append('<div class="photo-zoom"></div>')
                // set up a background image for each tile based on data-image attribute
                .children('.photo-zoom').css({'background-image': 'url('+ $(this).attr('data-image') +')'});
        })
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#banner-slider .slick').slick ({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                fade: true,
                autoplaySpeed: 10000,
                arrows: true,
            });
        });
    </script>
<script type="text/javascript">
        jQuery('ul.submenu').hide();
        jQuery('ul.nav > li, ul.submenu > li').hover(function () {
        if (jQuery('> ul.submenu',this).length > 0) {
            jQuery('> ul.submenu',this).stop().slideDown('slow');
        }
        },function () {
            if (jQuery('> ul.submenu',this).length > 0) {
                jQuery('> ul.submenu',this).stop().slideUp('slow');
            }
        });
</script>
@if(isset($page) && $page == "products")
<script type="text/javascript">

var slider = new Slider("#priceRange",{
    range: true,
    min: 0,
    value: [{{ isset($pricesRnge[0])?$pricesRnge[0]:0 }}, {{ isset($pricesRnge[1])?$pricesRnge[1]:$productsRangePrice }}],
});
slider.on("change", function(sliderValue) {
    priceRangeVal = $("#priceRange").val();
    getPrice = priceRangeVal.split(",");
    $(".priceRange").attr('href',"{!! url('/putfilt/ps/price/"+priceRangeVal+"') !!}");
    $("#priceValmin").html(getPrice[0]);
    $("#priceValmax").html(getPrice[1]);
});
function updateSlider(slideAmount) {
    var sliderDiv = document.getElementById("sliderAmount"),
        bMin = document.getElementById("priceValmin");
        bMax = document.getElementById("priceValmax");
        inputMin = document.getElementById("inputMin"),
        inputMax = document.getElementById("inputMax");
        bMin.innerHTML = inputMin.value;
        bMax.innerHTML = inputMax.value;
        xcs = inputMin.value +','+ inputMax.value;
        getPrice = xcs.split(",");
        $(".priceRange").attr('href',"{!! url('/putfilt/ps/price/"+xcs+"') !!}");
        $("#priceValmin").html(getPrice[0]);
        $("#priceValmax").html(getPrice[1]);
        console.log(xcs);
}
</script>
@endif

<script type="text/javascript">
$('#click_advance').click(function() {
    $('#display_advance').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
$('#click_advance2').click(function() {
    $('#display_advance2').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
$('#click_advance3').click(function() {
    $('#display_advance3').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
$('#click_advance4').click(function() {
    $('#display_advance4').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
$('#click_advance5').click(function() {
    $('#display_advance5').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
$('#click_advance6').click(function() {
    $('#display_advance6').toggle('1000');
    $("i", this).toggleClass("fa-plus fa-minus");
});
</script>
<script type="text/javascript">
        jQuery('ul.profile-nav-submenu').hide();
        jQuery('ul.profile-nav > li, ul.profile-nav-submenu > li').hover(function () {
        if (jQuery('> ul.profile-nav-submenu',this).length > 0) {
            jQuery('> ul.profile-nav-submenu',this).stop().slideDown('slow');
        }
        },function () {
            if (jQuery('> ul.profile-nav-submenu',this).length > 0) {
                jQuery('> ul.profile-nav-submenu',this).stop().slideUp('slow');
            }
        });
</script>
<script type="text/javascript">
jQuery('.list-product-slick').slick({
//   centerMode: true,
  centerPadding: '0px',
  slidesToShow: 5,
  slidesToScroll: 5,
  arrows: true,
    responsive: [
        {
            breakpoint: 1600,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
            }
        },{
            breakpoint: 1300,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
            }
        },{
            breakpoint: 1050,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                arrows: false,
            }
        },{
            breakpoint: 800,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});
</script>

<!-- <script>
jQuery(document).ready(function() {
jQuery('.tabs .tab-links a').on('click', function(e)  {
var currentAttrValue = jQuery(this).attr('href');
// Show/Hide Tabs
jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
// Change/remove current tab to active
jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
e.preventDefault();
});
});
</script> -->
<script>
/* Optional: Add active class to the current button (highlight it) */
$('#btnContainer button').on('click', function(){
    $('button.active').removeClass('active');
    $(this).addClass('active');
    
    if ($(this).hasClass('grid')) {
        $('#row-list div.list').removeClass('list').addClass('grid');
    }
    else if($(this).hasClass('list')) {
        $('#row-list div.grid').removeClass('grid').addClass('list');
    }
    
    var Token = $('input[name="_token"]').val();
    $prodview = $(this).data('prodview');
    if($prodview){
    	$.ajax({
	        url: '/product-view',
	        method: "post",
	        dataType: "json",
	        data:{
	        	prodview : $prodview,
	        	_token: Token,
	        },
	        success: function (data) {
	        	
	        }
	    }); 
    }
});
</script>

<script>
	$('#send_contactus_btn').on('click',function(){
		serialize_data = $('#inquiry_form').serializeArray();
		$.ajax({
	        url: '/contact-us',
	        method: "post",
	        dataType: "json",
	        data:serialize_data,
	        success: function (data) {
	           $('.contact_us_msg').html(data);
	        }
	    });
    });
    $('#submitprod').click(function(){
        document.getElementById('getProducts').submit();
    });
    $("#sortable").change(function(){
        var sort = $(this).val();
        window.location = "/products/search?"+((sort != "") ?'sort='+sort:'')+"{!!  !empty($search)?'&s='.$search:'' !!}#prodlist"
    });
</script>
<script>
	$('.nwltr-btn').on('click',function(){
		newsletter_email = $('#newsletter_email').val();
		var Token = $('input[name="_token"]').val(); 
		msg = 'Please check the Subscriber Form. Email Address is required';
		if(newsletter_email){
			$.ajax({
		        url: '/newsletter',
		        method: "post",
		        dataType: "json",
		        data:{
		        	newsletter_email : newsletter_email,
		        	_token: Token,
		        },
		        success: function (data) {
		        	
		        	if(data == 'success'){
		        		msg = '<p style="text-align:left;"><b>GREAT NEWS! </b></p> <br /> <br /><p style="text-align:justify;">You have just veen subscribed to EZ Deals regular mailing list. Joining our newsletter will allow you to see our deals and promotions!</p><br /><br /><p style="text-align:left;">Thank you for subcribing.</p>';
		        	}else if(data == 'invalid_email'){
		        		msg = 'We notice that the email you enter is invalid. <br /> Please check before submit.';
		        	}else if(data == 'existing'){
		        		msg = 'This email address is already subscribed.';
		        	}
		        	$('.subscriber_msg').html('<p class="title"><b>'+msg+'</b></p>');
		        	
		          $('#subscriber_modal').modal('show');
		        }
		    });
		}else{
			$('.subscriber_msg').html('<h4 class="title">'+msg+'</h4>');
		     $('#subscriber_modal').modal('show');
		}
		
		
    });
    
</script>
<script>
    $('.prod-sale').on('click',function(){
        //$this = ($(this).val() == "" ? $(this).closest('input'):$(this));

        document.getElementById('getProducts').submit();
    
     });
     

</script>
<script>
    $('.cat-select').on('click',function(){
    	
    	//$this = ($(this).val() == "" ? $(this).closest('input'):$(this));
        filter_type = $(this).data('filter-type');
        gettype = $(this).data('gettype');
        cat_filtr = ($(this).val() == "" ? $(this).data('value'):$(this).val());
        getkey = $(this).data('key');
        if($(this).prop('checked') === true || $(this).data('value') != ''){
             window.location = "{!! url('/putfilt/"+gettype+"/"+filter_type+"/"+cat_filtr+"') !!}";
        }else{
             window.location = "{!! url('/delfilt/"+gettype+"/"+filter_type+"/"+getkey+"') !!}";
        }
        
     });
     function getClearAll(type,sess_name){
        window.location = "{!! url('/getclear/"+type+"/"+sess_name+"') !!}";
     }
</script>
<script>
$(window).scroll(function () {
    // Get the header
    var header = document.getElementById("sticky-nav");
    var sticky = header.offsetTop;
    if (window.pageYOffset > $(".header-content").height()) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
});    
</script>
<script>
/*$('input:radio[name="rating_stars"]').change(function() {
  console.log('New star rating: ' + this.value);
});*/
</script>
 <div id="customer_login_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <!-- <div class="modal-content" style="background: url({{ URL::asset('img/modal/pop_bg_003.png') }});"> -->
        <div class="modal-content login-modal-bg">
            <button type="button" class="close custom-close-modal" data-dismiss="modal">X</button>
            <div class="modal-body">
        		<div class="row text-center">
            		<div class="col-md-12 col-sm-12 col-xs-12">
            			<div class="form-group login-modal-logo">
            			<img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
            			</div>
            		</div> 
            	</div>
            	<form  role="form" method="POST" action="{{ url('/login') }}">
            		<div class="row sign-in-form">
            			{{ csrf_field() }}
                		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12  col-lg-offset-2 col-md-offset-2" style="background: #FFF;padding-top:10px;">
                			<div class="form-group mb20 err_msg">
                				@if (session('msg'))
	                				@php
							    		$class = (session('status') == 'success' ? 'success' : 'danger' );
							    		$fa_class = (session('status') == 'success' ? 'check' : 'ban' );
							    		$start_txt = (session('status') == 'success' ? 'Success!' : 'Notice!' );
							    	@endphp
							    	{{session('error')}}
							    	<div class="alert alert-{{$class}} alert-dismissible">
					                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					                <h4><i class="icon fa fa-{{$fa_class}}"></i> {{$start_txt}}</h4>
					                {{session('msg')}}
					               	@if (session('modalshow'))
					                	<script>window.onload = $('#customer_login_modal').modal('show');</script>
					                	@if(session('status') && session()->has('pagecode'))
					                		<script>setTimeout(function(){$("#customer_login_modal").modal("hide");},3000);</script>
					                	@endif
					               @endif
					              </div>
							    @endif
                				<!--div class="alert alert-danger alert-dismissible">
					                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					                <h4><i class="icon fa fa-ban"></i> Notice!</h4>
					                
					              </div-->
                			</div>
                             <div class="form-group">
                             	<h4>Email Address</h4>
                             	<input type="text" class="form-control" name="customerid" />
                             </div>
                             <div class="form-group">
                             	<h4>Password</h4>
                             	<input type="password" class="form-control" name="customerpaswd" />
                             </div>
                             <div class="form-group">
                             	<input type="checkbox"  name="rememberme" />
                                <span>Remember me<span>
                             	
                             </div>
                             <div class="form-group">
                             	<div class="row">
                             		<div class="col-md-8 col-sm-6 col-xs-12">
	                             		<a href="{{URL::to('/password/reset')}}">Forgot Password?</a>  | <a href="{{URL::to('/contact-us')}}">Need Help?</a>
	                             	</div>
	                             	<div class="col-md-4 col-sm-6 col-xs-12 text-right">
	                             		<button type="submit" class="btn btn-gold btn-md">
	                                 		Sign In
	                                 	</button>
	                             	</div>
                             	</div>
                             </div>
                       	</div>
                	</div>
               </form>
            </div>
        </div>
    </div>
</div> <!-- close modal container -->

<div id="register_new_account" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <!-- <div class="modal-content" style="background: url({{ URL::asset('img/modal/pop_bg_003.png') }});"> -->
        <div class="modal-content login-modal-bg">
            <button type="button" class="close custom-close-modal" data-dismiss="modal">X</button>
            <div class="modal-body">
        		<div class="row text-center">
            		<div class="col-md-12 col-sm-12 col-xs-12">
            			<div class="form-group login-modal-logo">
            			<img src="{{ URL::asset('img/EZDEAL_RGB.png') }}" class="logo">
            			</div>
            		</div> 
                </div>
                <div class="row text-center">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12  col-lg-offset-2 col-md-offset-2" style="background: #FFF;padding-top:10px;">
                        <h4>Create an accout, it's easy!</h4>
                        <div class="form-group">
                                <div class="list-btn"><a href="{{URL::to('/register')}}"><button class="button button--aylen" tabindex="-1">Register</button></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- close modal container -->

<div id="rating_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background:#c1c1c1;">
            <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
            <div class="modal-body">
        		<div class="row text-center">
            		<div class="col-md-3 col-sm-3 col-xs-12">
            			<div class="form-group icon-div">
            				<!-- <i class="fa fa-check-circle-o"></i> -->
            				
            			</div>
            		</div> 
            		<div class="col-md-9 col-sm-9 col-xs-12">
            			<div class="form-group msg-div">
            				<!-- <h3>Gotcha!</h3>
            				<p>Ratings succesfully sent.</p> -->
            			</div>
            		</div> 
            	</div>
        	</div>
        </div>
    </div>
</div> <!-- close modal container -->

    <script>
    $(window).load(function(){
        setTimeout(function(){$('.alert').fadeOut() }, 3000);
    });
    $('#customer_login_modal .close').click(function(){
    	$('#customer_login_modal .err_msg').html('');
    });
    
    var getYR = new Date().getFullYear();
	$(".bday").datepicker({
	    changeMonth: true,
	    changeYear: true,
	    maxDate: '+0d',
	    defaultDate: '-25yr',
	    yearRange: "1905:" + getYR,
	    showOnFocus:false,
	}).on('changeDate',function(value){
		var today = new Date().getTime();
        dob = new Date(value.date).getTime();
        currYear = new Date(today - dob).getFullYear();
       
        age = currYear - 1970;
        $('#age,#addr_age').val(age);
	});

    	window.onload = function(){
    	$def = $(".bday").val();	
    	var today = new Date().getTime();
        dob = new Date($def).getTime();
        currYear = new Date(today - dob).getFullYear();
       
        age = currYear - 1970;
        $('#age,#addr_age').val(age);
    	};
    </script>
    
    <script>
    	/*Manage Profile*/
    	$('.savebtn').on('click',function(){
			$('#mngprofilefrm').submit();
        });
        $('.resetpass').on('click',function(){
			$('#updatepass').submit();
		});
    </script>
   
	@yield('scripts')
</body>
</html>
