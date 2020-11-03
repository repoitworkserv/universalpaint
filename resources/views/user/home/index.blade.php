@extends('layouts.user.app')

@section('content')
<style>
    #first-section .slick-next::before {
        content: url('img/right_white.png');
    }

    #first-section .slick-prev::before {
        content: url('img/left_white.png');
    }

    #fourth-section .slick-next::before {
        content: url('img/right_white.png');
    }

    #fourth-section .slick-prev::before {
        content: url('img/left_white.png');
    }
</style>
<div id="first-section">
    <div class="banner-content">
        <div>
            <div class="banner-slide first" style="background-image: url('img/1.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Premium quality white without the premium cost?</div>
                        <div class="desc">
                            Click here to know how Universal PLUS delivers white without the premium price tag.
                        </div>
                        <a href="/product/universal-professional-architectural-paint-plus-latex-paint" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide second" style="background-image: url('img/2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Metal & Steel preparation paint</div>
                        <div class="desc">
                            Protect steel and metal from corrosion with Universal Paint industrial grade coatings
                        </div>
                        <a href="/product-category/industrial" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide" style="background-image: url('img/3.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">Sometimes, all you need is color</div>
                        <div class="desc">
                            Check out the color depot page and choose from over a thousand unique interior and exterior colors
                        </div>
                        <a href="/color-swatches" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="banner-slide fourth" style="background-image: url('img/4.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box">
                        <div class="heading">The Ultimate weather<br> paint protection</div>
                        <div class="desc">
                        Click here to see paint & coatings that will PROTECT and make your home or project-ALL Weather.
                        </div>
                        <a href="/product/aquaguard-elastomeric-paint-aquaguard-elastomeric-paint" class="btn white">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Third Section -->
<div id="third-section">
    <div class="container">        
        <div class="thumbnail-logo">
            <div class="row"> 
                <div class="col col-md-2">
                    <img src="img/bluelogo.png">
                </div>
                <div class="col col-md-10" style="margin-top: 4%;">
                    <div class="heading">Our thousands of colors, Your Choice</div>
                </div>
            </div>            
        </div>
        <!-- color picker -->
        <div class="color-row">                    
            @if(!empty($colors))                
                @foreach($colors as $item)
                    <a href="/color-swatches" class="color-picker">
                        <div class="color-box" style="background-color:{!! $item['color'] !!};"></div>
                        <div class="ttl">{!! $item['name'] !!}</div>
                    </a>
                @endforeach
            @endif            
        </div>
    </div>
</div>
<!-- Fourth Section -->
<!-- Featured Products -->
<div id="fourth-section">
                    <div class="block">
                    @if($Page->GetMetaData('featured_products', 'product')['meta_value'])  
                            @foreach(explode(',', $Page->GetMetaData('featured_products', 'product')['meta_value']) as $product)
                                <div>
                                    <div class="bg-img" style="background: url(@if(\App\Product::findOrFail($product)->featured_image != '')
                                                    {!! asset('img/products/') !!}/{!! \App\Product::findOrFail($product)->featured_image !!}
                                                @else
                                                    {!! asset('img/products/') !!}/placeholder.png
                                                @endif
                                            ); background-size: contain; background-repeat: no-repeat; background-position: center right;">
                                        <div class="container">
                                            <div class="heading-bx">
                                                <div class="thumbnail-desc">Featured Product</div>
                                            </div>
                                            <div class="widget-box">
                                                <div class="lrg-title">{!! \App\Product::findOrFail($product)->name; !!}</div>
                                                <div class="desc">{!! \App\Product::findOrFail($product)->description !!}</div>                                                
                                                    <button type="button" class="btn btn-primary open-email-dialog" data-broc="{!! $product !!}" data-toggle="modal" data-target="#emailRequestModal">DOWNLOAD PRODUCT BROCHURE PDF</button>                                                    
                                            </div>
                                        </div>
                                    </div>                                                  
                                </div>
                            @endforeach
                        @endif                    
                    </div>
                </div>
                 <!-- Old Open -->
<!-- <div id="fourth-section">
    <div class="container">
        <div class="heading-bx">
            <div class="thumbnail-desc">Featured Product</div>
        </div>
        <div class="block">
        @if($Page->GetMetaData('featured_products', 'product')['meta_value'])  
                @foreach(explode(',', $Page->GetMetaData('featured_products', 'product')['meta_value']) as $product)
                               
                    <div>
                        <div class="bg-img">
                            
                                
                                <div class="widget-wrapper">
                                    <div class="widget-box">
                                        <div class="lrg-title">{--!! \App\Product::findOrFail($product)->name; !!--}</div>
                                        <div class="desc">{--!! \App\Product::findOrFail($product)->description !!--}</div>
                                            <a href="/pdf/{--!! \App\Product::findOrFail($product)->slug_name !!}.pdf" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                                    </div>
                                    <a href="/product/{--!! \App\Product::findOrFail($product)->slug_name; !!}" class="product-img-wrapper" style="background: url(
                                            
                                            @if(\App\Product::findOrFail($product)->featured_image != '')
                                                {--!! asset('img/products/') !!--}/{--!! \App\Product::findOrFail($product)->featured_image !!--}
                                            @else
                                                {--!! asset('img/products/') !!--}/placeholder.png
                                            @endif
                                        );"></a>                                
                                </div>
                            
                        </div>                     
                    </div>
                    

                @endforeach
            @endif                    
        </div>
    </div>
</div> -->
<!-- Old Close -->
<!-- Fifth Section -->
<div id="fifth-section">
    <div class="container">
        <div class="heading-bx">
            <div class="thumbnail-desc">What to paint</div>
        </div>
        <div class="block">
            <div class="align-bx row-bx">                
                <a href="/product-category/surface_preparation" class="widget-box" style="background-image: url('img/surface.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc light-gray">
                        <div class="ttl">Preparation</div>
                        <div class="desc"></div>
                    </div>
                </a>
                <a href="/product-category/interior" class="widget-box" style="background-image: url('img/p2.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc brown">
                        <div class="ttl">Interior Paint</div>
                        <div class="desc"></div>
                    </div>
                </a>
            </div>            
            <div class="align-bx row-bx">
                <a href="/product-category/exterior" class="widget-box" style="background-image: url('img/p1.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc blue-green">
                        <div class="ttl">exterior paint</div>
                        <div class="desc"></div>
                    </div>
                </a>
                <a href="/product-category/industrial" class="widget-box" style="background-image: url('img/industrial.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc orange">
                        <div class="ttl">Industrial Paint</div>
                        <div class="desc"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Brochure Modal-->
<div id="emailRequestModal" class="modal fade" role="dialog" data-backdrop="static" >
    <div class="modal-dialog modal-lg" style="pointer-events: auto">
        <div class="panel panel-primary">
            <form  action="{{ URL::action('User\HomePageController@email_request_pdf') }}" method="get"  accept-charset="UTF-8">
            {!! csrf_field() !!}
                <div class="panel-heading" style="    background: #aeaeae;
    border-top-right-radius: 13px;
    border-top-left-radius: 14px;
    padding-left: 24px;
    padding-top: 12px;
    padding-bottom: 12px;"><h4 class="modal-title">Enter Email Info</h4></div>
                <div class="panel-body" style="background: #fff;
    padding-top: 26px;
    padding-left: 26px;"> 
                	<div class="row">      
                                  		
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="broc_product" name="broc_product" class="form-control" type="hidden"  value="">
                                <div class="form-group">
                                    <label for="broc_fullname">Name</label>
                                    <input id="broc_fullname" name="broc_fullname" class="form-control" type="text"  value="">
                                </div>							
                                <div class="form-group color_attrib">
                                    <label for="broc_email">Email Address</label>
                                    <input id="broc_email" name="broc_email" class="form-control" type="email"  value="">
                                </div>
                            </div>
                        
                	</div>                    
                </div>
                <div class="panel-footer" style="text-align: left; background: #aeaeae;
    border-bottom-right-radius: 13px;
    border-bottom-left-radius: 14px;
    padding-left: 24px;
    padding-top: 12px;
    padding-bottom: 12px;">
                    <div class="button-group">
                        <button type="submit" class="btn btn-warning">Request</button>                        
                        <a href="#" class="btn" data-dismiss="modal" >CLOSE</a>                        
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection