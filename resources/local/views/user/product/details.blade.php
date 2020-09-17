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
                <div class="product-main">
                    <div class="base-zoom bg-contain" data-scale="1.8" data-image="{{ URL::asset('img/products') }}/{{ $product[0]->featured_image }}" style="background: url({{ URL::asset('img/products') }}/{{ $product[0]->featured_image }});"></div>
                    @foreach($img_gal as $index)
                    <div class="base-zoom bg-contain" data-scale="1.8" data-image="{{ URL::asset('img/gallery') }}/{{ $index->image_gallery }}" style="background: url({{ URL::asset('img/gallery') }}/{{ $index->image_gallery }});"></div>
                    @endforeach
                </div>
                    <div class="product-images">
                        <div class="prod-slide-img">
                            <img src="{{ URL::asset('img/products') }}/{{ $product[0]->featured_image }}" alt="" id="currentImages">
                        </div>
                        @foreach($img_gal as $index)
                        <div class="prod-slide-img product-section-thumbnail">
                            <img src="{{ URL::asset('img/gallery') }}/{{ $index->image_gallery }}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
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
                        <div class="item-content">
                            <div class="title-share">
                                <div class="item-title">
                                    {{$key->ParentData ? $key->ParentData['name'] :$key->name}}
                                    <input type="hidden" id="productid" value="{{$key->id}}">
                                    <input type="hidden" id="parentid" value="{{$key->ParentData ? $key->ParentData['id'] : $key->id}}">
                                </div>
                                <div class="item-title-share">
                                    <div class="icons"><a id="add-wishlist"><i class="fa fa-heart{{count($product[0]->ProductWishlist) > 0 ? '' : '-o'}} fa-fw" aria-hidden="true" style="color: {{count($product[0]->ProductWishlist) > 0  ? 'red' : ''}}"></i></a></div>
                                </div>
                            </div>
                            <div class="title-category"><a href="/brand/{{$key->BrandData['slug_name']}}">{{$key->BrandData['name']}}</a><span class="sku"> {{$key->ParentData ? $key->ParentData['product_code'] :$key->product_code}}</span></div>
                            <div class="line-thru"></div>
                            <form action="{!! URL::action('User\CartController@addcart') !!}" method="post" accept-charset="UTF-8"  enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            @if (\App\UserBrands::where('user_id', $uid)->where('brand_id', \App\Product::with('BrandData')->findOrFail($key->id)->BrandData['id'])->get()->isEmpty() || \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->get()->isEmpty())
                                @if($key->product_type == 'single')
                                    @if($key->is_sale == 1)
                                        <div class="price">&#8369; {{number_format($key->sale_price, 2)}}</div>
                                    @else
                                        @if(\App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['user_types_id'] == 3)
                                        <div class="price">&#8369; {{number_format($key->price, 2)}}</div>
                                        @else
                                            @if(!empty(\Auth::id()))
                                                <div class="price">&#8369; {!! number_format(\App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['price'],2); !!}</div>
                                            @else 
                                                <div class="price">&#8369; {{number_format($key->price, 2)}}</div>
                                            @endif
                                        @endif
                                    @endif
                                @else 
                                    @if($key->is_sale == 1)
                                        <div class="price">&#8369; {{number_format($key->sale_price, 2)}}</div>
                                    @else
                                        <div class="price">&#8369; {{number_format($key->price, 2)}}</div>
                                    @endif
                                @endif
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
                            @else
                                @if (\App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['discount_type'] == 'fix')
                                    @if($key->is_sale == 1)
                                       <div class="price">&#8369; {{number_format($key->sale_price, 2)}}</div>  
                                    @else
                                        <div class="price">&#8369; {!! number_format($key->price - \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['price'],2); !!}</div> 
                                    @endif
                                @else
                                    <div class="price">&#8369; {!! number_format($key->price * ((100 - \App\ProductUserPrice::where('product_id', $key->id)->where('user_types_id', $user_type)->first()['price']) / 100),2) !!}</div>
                                @endif                           
                            @endif
                            <div class="slogan"></div>
                            <div class="description">

                            </div>
                            <div class="share-btns">
                                <div class="share-text">Share</div>
                                <div class="social-btns">
                                  <div id="fb-root"></div>
                                    <div><a href="#"  class="sharebtn" data-shareuri="http://www.facebook.com/sharer.php?u={!!Request::url()!!}" ><img src="{{ URL::asset('img/icons/large-001-facebook.png') }}" class="logo"></a></div>&nbsp;&nbsp;
                                    <div><div class="icon-item"><a target="_blank" href="https://shopee.ph/ezdeal"><img src="{{ URL::asset('img/icons/large-001-shopee.png') }}" class="logo"></a></div></div>&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="line-thru"></div>
                            <div class="row">
                                <div class="option-list col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                <form action="{!! URL::action('User\CartController@addcart') !!}" method="post" accept-charset="UTF-8"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if($key['product_type'] == 'multiple')
                                        @foreach($key->UsedVariables as $list)
                                            <div class="row option-field">
                                                <div class="ttl-area col-lg-4 col-md-4 col-sm-4 col-xs-4">{{$list->VariableData['name']}}</div>
                                                <div class="color-area col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                                    <select class="atrribute-list form-control" name="prod-attri[]">
                                                        <option value="">Select Attribute</option>
                                                        @foreach($key->UsedAttribute as $attri)
                                                            @if($attri->AttributeData['variable_id'] == $list->VariableData['id'])
                                                                <option value="{{$attri->AttributeData['id']}}">{{$attri->AttributeData['name']}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <input type="hidden" id="var-count" value="{{count($key->UsedVariables)}}">
                                    <input type="hidden" id="avail-qty" value="{{$key->product_type == 'multiple' ? 0 : $key->quantity}}">
                                    <div class="row option-field">
                                        <div class="ttl-area col-lg-4 col-md-4 col-sm-4 col-xs-4">Quantity</div>
                                        <div class="color-area col-lg-4 col-md-4 col-sm-4 col-xs-7">
                                            <div class="row">
                                                <div class="quantity col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div id="quantity_id" class="quantity-select">
                                                        <div class="qty-tally minus-qty"><i class="fa fa-minus" aria-hidden="true"></i></div>
                                                        <input style="width: 70px; position: relative;" class="prod_qty numbers-only" data-cartid="cart_id" value="0" id="prod_qty" name="prod_qty" required>
                                                        <div class="qty-tally plus-qty"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div id="qty-err">Please Check Quantity</div>
                                                    <div class="quantity-text">{{$key->product_type == 'multiple' ? '&nbsp;' : $key->quantity.' stocks available'}}</div>
                                                    <!-- Use this if "No Stocks available" -->
                                                    <!-- <div class="quantity-text-null"></div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <a href="#" data-toggle="modal" data-target="#register_new_account"><button class="button button--aylen"tabindex="-1" id="add-cart"  disabled="true">ADD TO CART</button></a>
                                @else
                                <a><button class="button button--aylen" tabindex="-1" id="add-cart" disabled="true">ADD TO CART</button></a>
                                @endif
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- tab area -->
        <div class="col-sm-12">
            <div class="tabs">
                <ul class="tab-links nav nav-tabs">
                    <li class="active"><a data-toggle="tab"  href="#tab1">Overview</a></li>
                    <li><a data-toggle="tab"  href="#tab2">Product Details</a></li>
                    @if(in_array("howtouse",$listab))
                        <li><a data-toggle="tab"  href="#tab3">How To Use</a></li>
                    @endif
                    @if(in_array("aboutbrand",$listab))
                        <li><a data-toggle="tab"  href="#tab4">About the Brand</a></li>
                    @endif
                    @if(in_array("deliveropt",$listab))
                        <li><a data-toggle="tab"  href="#tab5">Delivery Option</a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                        <div class="row">
                            @foreach($product[0]->ProductOverview as $item)
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="content-line-text row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                                                <div class="tab-content-ttl"><h3><b>{!! $item->title !!}</b></h3></div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <div class="tab-content-text"><p>{!! $item->description !!}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <p>{!!$key->description!!}</p>
                    </div>
                    <div id="tab3" class="tab-pane fade">
                        <p>{!! $key->howtousetab_details !!}</p>      
                    </div>
                    <div id="tab4" class="tab-pane fade">
                        <p>{{$product[0]->BrandData['name']}}</p>
                        <p>{{$product[0]->BrandData['description']}}</p>
                    </div>
                    <div id="tab5" class="tab-pane fade">
                       <p>{!! $key->deliveryopt_tab_details !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- close tab area -->
        <!-- rating and reviews -->
        <div class="container-all all-banner-slide col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="rating-reviews">
                <div class="title-head">Reviews & Rating</div>
                <div class="product-reviews">
                    <div class="product-rev-left {{(!empty($uid) ? '' : 'w100per')}}"> <!-- Left Container  -->
                        @if($prod_rev_list->count() > 0)
                            @foreach($prod_rev_list as $prl)
                              @if($prl->is_approved == 1)
                                <div class="rating-container"> <!-- Start Rating -->
                                    <div class="review-cont {{(!empty($uid) ? '' : 'review-cont-anon')}}"> 
                                        <div class="left">
                                            <div class="rate-star">
                                                @php
                                                    $rate = $prl->rate;
                                                @endphp
                                                @for($r=0;$r<$rate;$r++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                            <div class="rate-name">{{$prl->UserProfileData['first_name']." ". $prl->UserProfileData['last_name']}}</div>
                                            <div class="rate-status">Verified Purchase</div>
                                            <div class="rate-date">Review Submitted Date: {!! $prl->created_at->format('m/d/Y') !!}</div>
                                            <div class="rate-date">Review Published Date: {!! $prl->updated_at->format('m/d/Y') !!}</div>
                                        </div>
                                        <div class="right">
                                            <div class="rate-image"><img src="{{ URL::asset('img/reviews') }}/{{ $prl->review_image }}" alt="" id="" style="width:300px"></div>
                                            <div class="rate-title">{{$prl->title}}</div>
                                            <div class="rate-review">{{$prl->reviews}}</div>
                                        </div>
                                    </div>
                                </div> 
                                @endif
                            @endforeach
                         {{  $prod_rev_list->links() }}                   
                        @else
                            <h4>No Reviews and Rating Available.</h4>
                        @endif
                    </div>  <!-- End Left Container -->
                    <div class="product-rev-right {{(!empty($uid) ? '' : 'dsply-none')}}"> <!-- Right Container -->
                        <div class="title">Rate this product</div>
                        <form action="{{ URL::action('User\ProductPageController@product_ratings') }}" method="post" id="ratingform" accept-charset="UTF-8" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="clickable-stars" >
                                <div class="rating">
                                 <label>
                                    <input type="hidden" name="rating_stars" >
                                 </label>
                                  <label>
                                    <input type="radio" name="rating_stars" required value="1" />
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="rating_stars" required value="2" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="rating_stars" required value="3" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>   
                                  </label>
                                  <label>
                                    <input type="radio" name="rating_stars" required value="4" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="rating_stars" required value="5" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                </div>
                            </div>
                            <div class="review-form">
                                <input type="text" class="" id="rev_tagline" name="rev_tagline" placeholder="Review Tag Line:" required>
                                <textarea class="" id="rev_desc" name="rev_desc" placeholder="Tell us what you think about it:" required></textarea>
                                <div class="check-user"><input type="checkbox" id="rev_is_anon" name="rev_is_anon" class="check-if-user" required>Review as Anonymous</div>
                                <input type="hidden" name="prodslug" value="{{$slug_name}}" />
                                <button type="submit" class="btn btn-primary btn-block btn-flat rate-btn sbmt_rating_btn" id="">Submit!</button>
                            </div>
                       </form>
                       @if(count($product) > 0)
                            @foreach($prod_rev as $pr)
                                @if($pr->is_approved == 1)
                                    <div class="title">You rate this product as</div>
                                    <div class="clickable-stars">
                                        <div class="rating">
                                            <label>
                                                @php
                                                    $rate = $pr->rate;
                                                @endphp
                                                @for($r=0;$r<$rate;$r++)
                                                    <span class="icon rating-selected ">★</span>
                                                @endfor
                                            </label>
                                        </div>
                                    </div>
                                    <div class="review-form text-center">
                                        <h4>{{$pr->title}}</h4>
                                        <p>{{$pr->reviews}}</p>
                                    </div>
                                    @else
                                    <h3 class="text-center">Your review and rating is for approval.</h3>
                                @endif
                            @endforeach
                       @endif
                    </div> <!-- End Right Container -->
                </div>
            </div>
        </div>
        <!-- close rating and reviews -->
        <!-- slider -->
        <div class="container-all all-banner-slide col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="top-title-new">
                <div class="content-ttl-new single-prod">Similar Items</div>
                <div class="content-ttl-line-new"></div>
                <div class="content-tag-ttl-new"><a href="/products" tabindex="-1"><button class="button hp-ttl-btn" tabindex="-1">SEE MORE >></button></a></div>
            </div>
            <div class="row list list-product-slick col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{-- random category and product in category --}}
                @foreach($product[0]->ProductCategoryData[rand(0,(count($product[0]->ProductCategoryData) - 1))]['SameCategoryProduct'] as $list)
                    @if($list->ProductDetails['parent_id'] == 0 && !empty($list->ProductDetails))
                        <div class="list-content">
                            <a href="/product/{{ $list->ProductDetails['slug_name'] }}">
                                <div class="list-banner"> <!-- item -->
                                    <div class="top">
                                        <div class="list img" style="background: url(
                                                @if($list->ProductDetails['featured_image'] != '')
                                                    {!! asset('img/products/') !!}/{!! $list->ProductDetails['featured_image']; !!}
                                                @else
                                                    {!! asset('img/products/') !!}/placeholder.png
                                                @endif
                                            );">
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="list-name-container">
                                            <div class="list-name">{{$list->ProductDetails['name']}}</div>
                                        </div>
                                        <div class="list-cat">
                                            @php
                                                $list_category = \App\ProductCategory::where('product_id', $list->ProductDetails['id'])->with('CatData')->take(2)->get();
                                            @endphp
                                            @foreach ($list_category as $cat)
                                            @if($cat['CatData'][0]->name == 'All Products')
                                        @else
                                            {{'| '.$cat['CatData'][0]->name.' |'}}
                                        @endif
                                            @endforeach
                                        </div>
                                        <div class="list-price">P {{number_format(\App\Product::where('slug_name', $list->ProductDetails['slug_name'])->max('price'), 2)}}</div>
                                        <div class="list-rate-btn">
                                            <div class="stars">
                                                @for ($i=0; $i < round($list->ProductDetails['rating']); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- close item -->
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <!-- close slider -->
        <!-- slider -->
        <div class="container-all all-banner-slide col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                @foreach($product as $key)
                    <!-- <div class="content-tag-ttl cat-select cpointer"   data-gettype="ps" data-filter-type="brand" data-value="{{strtolower($key->BrandData['name'])}}">SEE MORE >></div> -->
                @endforeach
            <!-- </div> -->
            <div class="top-title-new">
                <div class="content-ttl-new single-prod">From the Same Brand</div>
                <div class="content-ttl-line-new"></div>
                @foreach($product as $key)
                <div class="content-tag-ttl-new cat-select cpointer" data-gettype="ps" data-filter-type="brand" data-value="{{strtolower($key->BrandData['name'])}}"><button class="button hp-ttl-btn" tabindex="-1">SEE MORE >></button></div>
                @endforeach
            </div>
            <div class="row list list-product-slick col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @foreach($product[0]->BrandData['ProductByBrand'] as $list)
                <div class="list-content">
                    <a href="/product/{{ $list->slug_name }}">
                        <div class="list-banner"> <!-- item -->
                            <div class="top">
                                <div class="list img" style="background: url(
                                    @if($list->featured_image != '')
                                        {!! asset('img/products/') !!}/{!! $list->featured_image; !!}
                                    @else
                                        {!! asset('img/products/') !!}/placeholder.png
                                    @endif
                                );"></div>
                            </div>
                            <div class="bottom">
                                <div class="list-name-container">
                                    <div class="list-name">{{$list->name}}</div>
                                </div>
                                <div class="list-cat">
                                        @php
                                        $list_category = \App\ProductCategory::where('product_id', $list->id)->with('CatData')->take(2)->get();
                                    @endphp
                                    @foreach ($list_category as $cat)
                                        @if($cat['CatData'][0]->name == 'All Products')
                                        @else
                                            {{'| '.$cat['CatData'][0]->name.' |'}}
                                        @endif
                                    @endforeach
                                </div>
                                <div class="list-price">P {{number_format(\App\Product::where('slug_name', $list->slug_name)->max('price'), 2)}}</div>
                                <div class="list-rate-btn">
                                    <div class="stars">
                                    @for ($i=0; $i < round($list->rating); $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    </div>
                                </div>
                            </div>
                        </div> <!-- close item -->
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <!-- close slider -->
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