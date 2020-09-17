@extends('layouts.user.app')

@section('content')
<div id="product">
    <div class="page-header">
    </div>
    <div class="row">
    @include('flash-message')
    <div class="col-lg-12">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
            
            <div id ="product-page-list">
                <div class="banner-img" style="background-image: url({{ url('img/p2.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
                <div class="container">
                    <div class="sub-navigation">
                        <div class="nav-right">Interior Products | Wall Paint</div>
                    </div>
                    <div class="product-tile">
			<div class="block">
                @php
                    $listab = array();
                    $proddesc = '';
                    $howtouse = '';
                    $delvry_opt = '';
                @endphp
                @foreach($product as $key)
                    @php
                        $listab = explode(',',$key->list_tab);
                        $howtouse = $key->howtousetab_details;
                        $delvry_opt = $key->deliveryopt_tab_details;
                    @endphp
                    @php
                    $prodesc = $key->description;
                    $query = App\ProductReviewsandRating::where('product_id', $key->id)->count();
                    $productRating = "(" . $query .' '."Rating)". "\r\n";
                    $prodprice = '';
                    if($key->product_type == 'single')
                        if($key->is_sale == 1)
                            $prodprice = "\r\n".number_format($key->sale_price, 2);
                        else
                            $prodprice = "\r\n".number_format($key->price, 2);
                    else 
                        if($key->is_sale == 1)
                            $prodprice = "\r\n".number_format($key->sale_price, 2);
                        else
                            $prodprice = "\r\n".number_format($key->price, 2);

                            $img = URL::asset('img/products').'/'.$product[0]->featured_image;
                            $prodname = $key->ParentData ? $key->ParentData['name'] :$key->name;
                            $url = URL::to('/').'/product';
                            @endphp
                            @section('ogproduct'){!! $prodname !!}@stop               
                            @section('ogtitle'){!!$prodname . ' &#8369;'.$prodprice  .  ' \r\n' .$productRating!!}@stop
                            @section('ogdescription'){!! $proddesc !!}@stop
                            @section('ogurl',''){!!$url!!}@stop
                            @section('ogimg'){!! $img !!}@stop
                            <div class="left-bx">                
                                <div class="prod-img" style="background-image: url({!! asset('img/products') !!}/{{ $product[0]->featured_image }}) ; background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
                                <div class="prod-btn">
                                    <img src="{{ url('img/buttons/button.png') }}">
                                    <a href="" class="yellow-btn">Download Product Brochure Pdf</a>
                                    <a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
                                    <a href="" class="yellow-btn">Technical Data Sheet</a>
                                    <a href="" class="yellow-btn">Color Calculators</a>	
                                </div>				
                            </div>
                            <div class="right-bx">
                                <div class="title">{{$key->ParentData ? $key->ParentData['name'] :$key->name}}</div>
                                <div class="sub-title"></div>
                                <div class="desc">{{$key->ParentData ? $key->ParentData['name'] :$key->description}}</div>
                                <div class="feat-ttl">BEST FEATURES</div>                    
                                <div class="regular-price">
                                    @if($key->is_sale == 1)
                                        @if($key->product_type == 'single')
                                            <span class="price-before">{{'&#8369; '. number_format($key->price, 2)}}</span> 
                                            @if($key->discount_type == 'fix')
                                                <span class="discount">{{'&#8369; ' . number_format($key->discount, 2) .' OFF'}}</span>
                                            @else
                                                <span class="discount">{{number_format($key->discount, 2).'% OFF'}}</span>
                                            @endif
                                        @else
                                            <span class="price-before">{{'&#8369; '. number_format($key->price, 2)}}</span> 
                                            @if($key->discount_type == 'percentage')
                                                <span class="discount">{{$key->discount .'% OFF'}}</span>
                                            @else
                                                <span class="discount">{{number_format($key->discount, 2).'% OFF'}}</span>
                                            @endif
                                        @endif

                                    @endif
                                </div>  
                                <div class="flex-txt">
                                    <div class="sml-ttl">Where to Use</div>
                                    <div class="sml-desc">{{ $key->where_to_use}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Area </div>
                                    <div class="sml-desc">{{ $key->area}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Best Used for</div>
                                    <div class="sml-desc"> {{ $key->best_used_for}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Features</div>
                                    <div class="sml-desc">{{ $key->features}} </div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Coverage per 4/L</div>
                                    <div class="sml-desc">{{ $key->coverage}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Finish</div>
                                    <div class="sml-desc">{{ $key->finish}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Color</div>
                                    <div class="sml-desc">white, black, aluminum, baby blue, baby pink, bright red, caterpillar yellow, chocolate brown, crystal blue, crystal green, international red, ivory, jade green, lemon yellow, maple, maroon, medium gray, moly orange, nile green, royal blue, silver gray</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Application</div>
                                    <div class="sml-desc">{{ $key->application}}</div>
                                </div>
                                <div class="flex-txt">
                                    <div class="sml-ttl">Packaging Size</div>
                                    <div class="sml-desc">{{ $key->packaging}}</div>
                                </div>
                            </div>	
                @endforeach			
			</div>
		</div>        
                </div>
            </div>       
                            
                    
            </div>
                
            </div>
        </div>                
               
    </div>
</div>
@endsection
@section('scripts')
    <script>
    $(window).load(function(){
        setTimeout(function(){$('.alert').fadeOut() }, 3000);
    });
    $(document).ready(function(){
        $('.plus-qty').trigger('click');
    });
    function onchange_img(e,umg){
        html_appender = $(umg).parents('.upl_img').find('.preview_image');
        var files = e.target.files,
        filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader(umg);
            fileReader.onload = (function(e,umg) {
              var file = e.target;
              prev_img = "<span class=\"img_prev_wrap\">" +
                                "<span class=\"remove\" style='position:absolute;'><i class='fa fa-trash'></i></span>" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
                                "</span>";
              html_appender.html(prev_img);
              
              $(".remove").click(function(){
                $(this).parent(".img_prev_wrap").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
    }
    
     $(".upload_image").on("change", function(e) {
        umg = this;
        onchange_img(e,umg);
    });
    </script>
@endsection