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

    @php 
        if($Page->GetMetaData('banner', 'post')['meta_value']) {
            $x = 0;
            foreach(explode(',', $Page->GetMetaData('banner', 'post')['meta_value']) as $banner) {
    @endphp
        <div>
            <style>
                .banner-{{$x}} .container .widget-box:after {
                    background-color: {{ \App\Post::findOrFail($banner)->background_color}} !important;
                    border: 10px solid  {{ \App\Post::findOrFail($banner)->background_color}} !important;
                }
            </style>
            <div class="banner-slide banner-{{$x}}" style="background-image: url('img/post/{{\App\Post::findOrFail($banner)->featured_banner}}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                <div class="container">
                    <div class="widget-box" style="background-color: {{ \App\Post::findOrFail($banner)->background_color}} !important">
                        <div class="heading">{{\App\Post::findOrFail($banner)->post_title}}</div>
                        <div class="desc">
                          {!! \App\Post::findOrFail($banner)->post_content !!}
                        </div>
                        <a href="{{\App\Post::findOrFail($banner)->button_link}}" class="btn white">{{ \App\Post::findOrFail($banner)->button_name }}</a>
                    </div>
                </div>
            </div>
        </div>
        @php
            $x++;
            };
        };
    @endphp
        <!-- <div>
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
        </div> -->
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
            <a href="/color-swatches" class="color-picker">
                <div class="color-box" style="background-color: #ccc;"></div>
                <div class="ttl">View </br>All Colors</div>
            </a>            
            @if(!empty($colors))                
                @foreach($colors as $item)
                    <a href="/color-swatches" class="color-picker">
                        <div class="color-box" style="background-color:{!! $item['color'] !!};"></div>
                        <div class="ttl">{!! $item['name'] !!}</div>
                    </a>
                @endforeach
            @endif
            <a href="/color-swatches" class="color-picker">
                <div class="color-box" style="background-color: #ccc;"></div>
                <div class="ttl">Best </br>Selling Colors</div>
            </a>          
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
                                    <div class="bg-img">
                                        <div class="container">
                                            <div class="heading-bx">
                                                <div class="thumbnail-desc">Featured Product</div>
                                            </div>
                                            <div class="widget-box" style="display: flex; width: 100%;">
                                                <div id="left">
                                                    <div class="lrg-title">{!! \App\Product::findOrFail($product)->name; !!}</div>
                                                    <div class="desc">{!! \App\Product::findOrFail($product)->description !!}</div>
                                                    @if(\App\Product::findOrFail($product)->brochure_path)
                                                    <button type="button" class="download_pdf btn btn-primary" data-id="{!! \App\Product::findOrFail($product)->id; !!}" data-toggle="modal" data-target="#emailRequestModal">DOWNLOAD PRODUCT BROCHURE PDF</button>
                                                    @endif
                                                </div>
                                                <div id="right">
                                                    <div class="bg-img" style="background: url(@if(\App\Product::findOrFail($product)->featured_image != '')
                                                        {!! asset('img/products/') !!}/{!! \App\Product::findOrFail($product)->featured_image !!}
                                                    @else
                                                        {!! asset('img/products/') !!}/placeholder.png
                                                    @endif
                                                    ); background-size: contain; background-repeat: no-repeat; background-position: center right;">

                                                    </div>
                                                </div>
                                                <!-- <form  action="{{ URL::action('User\HomePageController@email_request') }}" method="get"  accept-charset="UTF-8"> -->
                                                    <!-- {!! csrf_field() !!} -->
                                                    <!-- <button type="submit" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</button> -->                                                    
                                                    <!-- <a href="/pdf/{!! \App\Product::findOrFail($product)->slug_name !!}.pdf" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a> -->
                                                    {{-- <button type="button" class="download_pdf btn btn-primary" data-toggle="modal" 
                                                    data-id="{!! \App\Product::findOrFail($product)->id; !!}" data-target="#emailRequestModal">DOWNLOAD PRODUCT BROCHURE PDF</button> --}}
                                                    <!-- <a href="#" class="btn">DOWNLOAD PRODUCT BROCHURE PDF</a> -->
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
        @php 
            if($Page->GetMetaData('product_category', 'category')['meta_value']) {
                $x = 0;                           
                $colors         = ["light-gray", "brown", "blue-green", "orange"];
                foreach(explode(',', $Page->GetMetaData('product_category', 'category')['meta_value']) as $category) {
        @endphp                                
            @php 
                $ctr = $x % 2;
                $rand_color_key = rand(0,3);
            @endphp
            @if($ctr == 0)
            <div class="align-bx row-bx">      
            @endif          
                <a href="/product-category/{{str_replace('-','_',\App\Category::findOrFail($category)->slug_name)}}" class="widget-box" style="background-image: url('img/category/{{\App\Category::findOrFail($category)->featured_img}}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                    <div class="color-desc {{$colors[$rand_color_key]}}">
                        <div class="ttl">{{\App\Category::findOrFail($category)->name}}</div>
                        <div class="desc"></div>
                    </div>
                </a>
            @if($ctr) 
            </div>   
            @endif 
         @php
            $x++;
            };
        };
        @endphp
        </div>
    </div>
</div>

<!-- Brochure Modal-->
<div id="emailRequestModal" class="modal fade" role="dialog" data-backdrop="static" >
    <div class="modal-dialog modal-lg" style="pointer-events: auto">
        <div class="panel panel-primary">
            <form  id="downloadPdfForm" action="{{ URL::to('/email_user_pdf') }}" method="post"  accept-charset="UTF-8">
            {!! csrf_field() !!}
                <div class="panel-heading" style="    background: #aeaeae;
    border-top-right-radius: 13px;
    border-top-left-radius: 14px;
    padding-left: 24px;
    padding-top: 12px;
    padding-bottom: 12px;"><h4 class="modal-title">Enter Email Info</h4></div>
                <div class="panel-body" style="background: #fff;
    padding-top: 26px;
    padding-left: 26px; padding-right: 26px;"> 
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
                        <button type="submit" class="btn btn-warning" style="
    margin-right: 20px;">Request</button>                        
                        <button id="button_close" class="btn btn-warning" data-dismiss="modal" >Close</button>                        
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#button_close').click(function() {
            $('#broc_fullname').val("");
            $('#broc_email').val("");
        });
        $('.download_pdf').click(function() {
            var product_id = $(this).data('id');
            $('#broc_product').val(product_id);
        });

        $('#downloadPdfForm').on('submit',function(e) {
            e.preventDefault();
            var broc_product  = $('#broc_product').val();
            var broc_fullname = $('#broc_fullname').val();
            var broc_email    = $('#broc_email').val();
            var _token        = $('input[name="_token"]').val();
            var data = {
                broc_product,
                broc_fullname,
                broc_email,
                _token
            };
            $.ajax($(this).attr('action'), 
            {
                dataType: 'json', // type of response data
                method: "POST",
                data: data,
                success: function (data,status,xhr) {   // success callback function
                    $('#broc_fullname').val("");
                    $('#broc_email').val("");
                   $('#emailRequestModal').modal('hide');
                   alert("Thank you for providing your name and email. The brochure will now start downloading...");
                   window.location = data.url;
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback 
                    alert('Error: ' + errorMessage);
                }
            });
        });
    })
</script>

@stop