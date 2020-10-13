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
                            Ptotect steel and metal from corrosion with Universal Paint industrial grade coatings
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
                <div class="col col-md-10">
                    <div class="heading">Our thousands of colors, Your Choice</div>
                </div>
            </div>            
        </div>
        <!-- color picker -->
        <div class="color-row">
            <div class="color-picker">
                <div class="color-box" style="background-color:#F6F7F2;"></div>
                <div class="ttl">Whites </br>& Neutrals</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#373E42;"></div>
                <div class="ttl">Greys</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#B39F94;"></div>
                <div class="ttl">Browns</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#7E7999;"></div>
                <div class="ttl">Purples</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#0045C7;"></div>
                <div class="ttl">Blue</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#9DBFAF;"></div>
                <div class="ttl">Greens</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#FAE196;"></div>
                <div class="ttl">Yellows</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#CC5327;"></div>
                <div class="ttl">Oranges</div>
            </div>
            <div class="color-picker">
                <div class="color-box" style="background-color:#A8312F;"></div>
                <div class="ttl">Reds</div>
            </div>
        </div>
    </div>
</div>
<!-- Fourth Section -->
<!-- Featured Products -->
<div id="fourth-section">
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
                                        <div class="lrg-title">{!! \App\Product::findOrFail($product)->name; !!}</div>
                                        <div class="desc">{!! \App\Product::findOrFail($product)->description !!}</div>
                                            <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a>
                                    </div>
                                    <a href="/product/{!! \App\Product::findOrFail($product)->slug_name; !!}" class="product-img-wrapper" style="background: url(
                                            
                                            @if(\App\Product::findOrFail($product)->featured_image != '')
                                                {!! asset('img/products/') !!}/{!! \App\Product::findOrFail($product)->featured_image !!}
                                            @else
                                                {!! asset('img/products/') !!}/placeholder.png
                                            @endif
                                        );"></a>                                
                                </div>
                            
                        </div>                     
                    </div>
                @endforeach
            @endif                    
        </div>
    </div>
</div>
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
                        <div class="ttl">ndustrial Paint</div>
                        <div class="desc"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection