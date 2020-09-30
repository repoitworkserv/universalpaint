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
                <div class="col-lg-12" style="padding-right: 0;">
                    <div id="product-page-list">
                        <div class="banner-img" style="background-image: url({{ url('img/p2.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
                        <div class="container">
                            <div class="sub-navigation">
                                <div class="nav-right nav-right col-lg-7 col-md-7 col-sm-12 col-12">{{ $category }} Products | Wall Paint</div>
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
                                        @section('ogtitle'){!!$prodname . ' &#8369;'.$prodprice . ' \r\n' .$productRating!!}@stop
                                        @section('ogdescription'){!! $proddesc !!}@stop
                                        @section('ogurl',''){!!$url!!}@stop
                                        @section('ogimg'){!! $img !!}@stop
                                        <div class="left-bx col-md-5 col-sm-12 col-12">
                                            <div class="prod-img" style="background-image: url({!! asset('img/products') !!}/{{ $product[0]->featured_image }}); background-size: cover; background-repeat: no-repeat; background-position: center center; position: relative; left: 15px;"></div>
                                            <div class="prod-btn">
                                                <img src="{{ url('img/buttons/button.png') }}">
                                                <a href="" class="yellow-btn">Download Product Brochure Pdf</a>
                                                <a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
                                                <a href="" class="yellow-btn">Technical Data Sheet</a>
                                                <a href="" class="yellow-btn">Color Calculators</a>
                                            </div>
                                        </div>
                                        <div class="right-bx col-md-7 col-sm-12 col-12">
                                            <div class="title">{{$key->ParentData ? $key->ParentData['name'] :$key->name}}</div>
                                            <div class="sub-title"></div>
                                            <div class="desc">{!! $key->description !!}</div>
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
                                                <div class="sml-desc">Available in {{ $key->UsedAttribute->count() }} color {{$key->UsedAttribute->count() > 1 ? 's':'' }}</div>
                                            </div>
                                            <div class="flex-txt">
                                                <div class="sml-ttl">Application</div>
                                                <div class="sml-desc">{{ $key->application}}</div>
                                            </div>
                                            <div class="flex-txt">
                                                <div class="sml-ttl">Packaging Size</div>
                                                <div class="sml-desc">{{ $key->packaging}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="option-list col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                    <div class="row">
                                                        <div class="option-list col-lg-3 col-md-10 col-sm-10 col-xs-10">                                                                
                                                            @if($key['product_type'] == 'multiple')                                                                
                                                                @foreach($key->UsedVariables as $list)
                                                                    <div class="row option-field">
                                                                        <select class="atrribute-list form-control" name="prod-attri[]">
                                                                            <option value="">Select </option>
                                                                            @foreach($key->UsedAttribute as $attri)
                                                                                @if($attri->AttributeData['variable_id'] == $list->VariableData['id'])
                                                                                    <option value="{{$attri->AttributeData['id']}}">{{$attri->AttributeData['name']}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <!-- <div class="ttl-area col-lg-4 col-md-4 col-sm-4 col-xs-4">{{$list->VariableData['name']}}</div> -->

                                                                        <div class="color-area col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif                                                                
                                                        </div>
                                                        <input type="hidden" id="var-count" value="{{count($key->UsedVariables)}}">                                                               
                                                        <input type="hidden" id="avail-qty" value="{{$key->product_type == 'multiple' ? 0 : $key->quantity}}">
                                                        <!-- <div class="row option-field"> -->
                                                            <div class="color-area col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                                                <div class="row">
                                                                    <div class="quantity col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div id="quantity_id" class="quantity-select">
                                                                            <div class="qty-tally minus-qty"><i class="fa fa-minus" aria-hidden="true"></i></div>
                                                                            <input style="width: 70px; position: relative;" class="prod_qty numbers-only" data-cartid="cart_id" value="0" id="prod_qty" name="prod_qty">
                                                                            <div class="qty-tally plus-qty"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                                        </div>
                                                                    </div>                                                                        
                                                                </div>
                                                            </div>
                                                            
                                                        <!-- </div> -->
                                                        <form action="{!! URL::action('User\CartController@addcart') !!}" method="post" accept-charset="UTF-8"  enctype="multipart/form-data">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="shipping_width" id="shipping_width" value="{{$key->product_type == 'single' ? $key->shipping_width : $key->ParentData['shipping_width']}}">
                                                            <input type="hidden" name="shipping_length" id="shipping_length" value="{{$key->product_type == 'single' ? $key->shipping_length : $key->ParentData['shipping_length']}}">
                                                            <input type="hidden" name="shipping_weight" id="shipping_weight" value="{{$key->product_type == 'single' ? $key->shipping_weight : $key->ParentData['shipping_weight']}}">
                                                            <input type="hidden" name="shipping_height" id="shipping_height" value="{{$key->product_type == 'single' ? $key->shipping_height : $key->ParentData['shipping_height']}}">
                                                            <input type="hidden" name="item_id" id="item_id" value="{{$key->product_type == 'single' ? $key->id : 0}}">
                                                            <input type="hidden" name="item_quantity" id="item_quantity">
                                                            {{-- <input type="hidden" name="item_is_sale" id="is_sale" value="{{$key->is_sale}}"> --}}
                                                            <input type="hidden" name="is_sale" id="is_sale" value="{{$key->product_type == 'single' ? $key->is_sale : $key->ParentData['is_sale']}}">
                                                            <input type="hidden" name="item_name" id="item_name" value="{{$key->ParentData ? $key->ParentData['name'] :$key->name}}">
                                                            
                                                            @if (\App\UserBrands::where('user_id', $uid)->where('brand_id', \App\Product::with('BrandData')->findOrFail($key->id)->BrandData['id'])->get()->isEmpty() || \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->get()->isEmpty())
                                                                {{-- <input type="hidden" name="item_price" id="item_price" value="{{$key->product_type == 'single' ? $key->price : $key->price}}">
                                                                <input type="hidden" name="item_sale_price" id="item_sale_price" value="{{$key->product_type == 'single' ? $key->sale_price : $key->sale_price}}"> --}} 
                                                                <input type="hidden" name="item_price" id="item_price" value="{{$key->product_type == 'single' ? $key->price : $key->ParentData['price']}}">
                                                                <input type="hidden" name="item_sale_price" id="item_sale_price" value="{{$key->product_type == 'single' ? $key->sale_price : $key->ParentData['sale_price']}}">
                                                            @else
                                                                @if (\App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['discount_type'] == 'fix')
                                                                    <input type="hidden" name="item_price" id="item_price" value="{!! $key->price - \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['price']; !!}">                                        
                                                                @else
                                                                    <input type="hidden" name="item_price" id="item_price" value="{!! $key->price * ((100 - \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['price']) / 100) !!}">                                        
                                                                @endif 
                                                                <input type="hidden" name="item_sale_price" id="item_sale_price" value="0">
                                                            @endif
                                                            <input type="hidden" name="item_discount" id="item_discount" value="{{$key->product_type == 'single' ? $key->discount : $key->discount}}">
                                                            <input type="hidden" name="item_discount_type" id="item_discount_type" value="{{$key->product_type == 'single' ? $key->discount_type : $key->discount_type}}">
                                                            <input type="hidden" name="item_description" id="item_description" value="{{$key->product_type == 'single' ? $key->description : $key->description}}">
                                                            @if (empty($uid))
                                                                <a href="#" data-toggle="modal" data-target="#register_new_account"><button class="button button--aylen"tabindex="-1" id="add-cart"  disabled="true">ADD TO CART<i class="fas fa-shopping-bag"></i></button></a>
                                                            @else
                                                            <a><button class="button" tabindex="-1" id="add-cart" disabled="true">ADD TO CART &nbsp;<i class="fas fa-shopping-bag"></i></button></a>                                                            
                                                            @endif
                                                        </form>
                                                    </div>
                                                <!-- form here -->                                                        
                                                </div>
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
    $(window).load(function() {
        setTimeout(function() {
            $('.alert').fadeOut()
        }, 3000);
    });
    $(document).ready(function() {
        $('.plus-qty').trigger('click');
    });

    function onchange_img(e, umg) {
        html_appender = $(umg).parents('.upl_img').find('.preview_image');
        var files = e.target.files,
            filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader(umg);
            fileReader.onload = (function(e, umg) {
                var file = e.target;
                prev_img = "<span class=\"img_prev_wrap\">" +
                    "<span class=\"remove\" style='position:absolute;'><i class='fa fa-trash'></i></span>" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
                    "</span>";
                html_appender.html(prev_img);

                $(".remove").click(function() {
                    $(this).parent(".img_prev_wrap").remove();
                });
            });
            fileReader.readAsDataURL(f);
        }
    }

    $(".upload_image").on("change", function(e) {
        umg = this;
        onchange_img(e, umg);
    });
</script>
@endsection