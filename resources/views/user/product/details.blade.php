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
                            @php
                                $listab = array();
                                $proddesc = '';
                                $howtouse = '';
                                $delvry_opt = '';
                                $sub_cat = implode( ", ", $sub_category );
                            @endphp                            
                            @foreach($product as $key)
                            
                            <div class="sub-navigation">
                                <div class="nav-right nav-right col-lg-7 col-md-7 col-sm-12 col-12">{{ $category }} Products</div>
                            </div>
                            <div class="product-tile">
                                <div class="block">
                                    
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
                                            <a href="/pdf/{!! $key->slug_name !!}.pdf" class="yellow-btn">Download Product Brochure Pdf</a>
                                            <a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
                                            <a href="" class="yellow-btn">Technical Data Sheet</a>
                                            <a href="/paint-calculator?paint=<?php echo $key->ParentData ? $key->ParentData['name'] :$key->name; ?>" class="yellow-btn">Color Calculators</a>
                                        </div>
                                    </div>
                                    <div class="right-bx col-md-7 col-sm-12 col-12">
                                        <div class="title">{{$key->ParentData ? $key->ParentData['name'] :$key->name}}</div>
                                        <input type="hidden" id="productid" value="{{$key->id}}">
                                        <input type="hidden" id="parentid" value="{{$key->ParentData ? $key->ParentData['id'] : $key->id}}">
                                        <div class="sub-title"></div>
                                        <div class="desc">{!! $key->description !!}</div>
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
                                        <hr>
                                        @if(!empty($prod_attrib))
                                        <div class="row">
                                            <div class="option-list col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                <div class="flex-txt">
                                                    <div class="sml-ttl">Colors Selected</div>
                                                </div>
                                                <div class="sml-desc">
                                                    @if(!empty($color_selected))
                                                    @foreach($color_selected as $item)
                                                    @php var_dump($item) @endphp
                                                    @endforeach
                                                    @endif
                                                    @if(!empty($cart))

                                                    @php dd($cart) @endphp
                                                    @endif
                                                </div>
                                            </div>
                                        </div>                                       
                                        @else
                                        <div class="flex-txt">
                                            <div class="sml-ttl">
                                                @if($key['product_type'] == 'multiple')
                                                @foreach($key->UsedVariables as $list)
                                                <div class="option-field">
                                                    <select id="productattri" class="atrribute-list form-control" name="prod-attri[]">
                                                        <option value="">Select </option>
                                                        @foreach($key->UsedAttribute as $attri)
                                                        @if($attri->AttributeData['variable_id'] == $list->VariableData['id'])
                                                        <option style="background: rgb(255,0,0); color: white;" value="{{$attri->AttributeData['id']}}">{{$attri->AttributeData['name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>                                                                                                        
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>                                            
                                            <div class="sml-ttl sml-ttl-fifteen">
                                                <input type="hidden" id="var-count" value="{{count($key->UsedVariables)}}">
                                                <div id="quantity_id" class="quantity-select">                                                    
                                                    <input class="prod_qty numbers-only" data-cartid="cart_id" value="0" id="prod_qty" name="prod_qty">                                                    
                                                </div>
                                            </div>
                                            <div class="sml-ttl">
                                                <form action="{!! URL::action('User\CartController@addcart') !!}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="shipping_width" id="shipping_width" value="{{$key->product_type == 'single' ? $key->shipping_width : $key->ParentData['shipping_width']}}">
                                                    <input type="hidden" name="shipping_length" id="shipping_length" value="{{$key->product_type == 'single' ? $key->shipping_length : $key->ParentData['shipping_length']}}">
                                                    <input type="hidden" name="shipping_weight" id="shipping_weight" value="{{$key->product_type == 'single' ? $key->shipping_weight : $key->ParentData['shipping_weight']}}">
                                                    <input type="hidden" name="shipping_height" id="shipping_height" value="{{$key->product_type == 'single' ? $key->shipping_height : $key->ParentData['shipping_height']}}">
                                                    <input type="hidden" name="item_id" id="item_id" value="{{$key->product_type == 'single' ? $key->id : 0}}">
                                                    <input type="hidden" name="item_quantity" id="item_quantity">
                                                    <input type="hidden" name="prodattri" id="prodattri">
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
                                                    <a><button class="col-md-12" tabindex="-1" id="add-cart" disabled="true">ADD TO CART &nbsp;<i class="fas fa-shopping-bag"></i></button></a>
                                                    <!-- <a href="#" data-toggle="modal" data-target="#register_new_account"><button class="button button--aylen"tabindex="-1" id="add-cart"  disabled="true">ADD TO CART<i class="fas fa-shopping-bag"></i></button></a> -->
                                                    @else
                                                    <a><button class="col-md-12" tabindex="-1" id="add-cart" disabled="true">ADD TO CART &nbsp;<i class="fas fa-shopping-bag"></i></button></a>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                        <div class="flex-txt">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 10px;">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="option-list col-lg-12 col-md-12 col-sm-10 col-xs-10">
                                                <div class="row">
                                                    
                                                </div>
                                                <div class="row">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($cart)
                                            <div class="row">
                                                <div class="option-list col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                    <div class="flex-txt">
                                                        <a href="/cart"><button class="button gotocart" tabindex="-1" id="gotocart">PROCEED TO CART &nbsp;<i class="fas fa-shopping-bag"></i></button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif                                         
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
@endsection
@section('scripts')
<script>
    $(window).on('load', function() {
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

    $("#productattri").on("keyup change", function() {
        $('#prodattri').val($(this).val());
        $("#prod_qty").val()
        // console.log($(this).val(), $('#prodattri').val());
    });
</script>
@endsection