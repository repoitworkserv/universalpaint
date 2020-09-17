@extends('layouts.user.app')

@section('css')
<style>
    #footer {
        display: none !important;
    }
</style>
@endsection
@section('content')
@php
$bannerCategory = Session::get('myfilter');
@endphp
<div class="category-banner">
    @if(!empty($bannerCategory['category']))
        @foreach($bannerCategory['category'] as $itemBanner)
        @php $name = explode(': ',$itemBanner)[1];@endphp
        <div class="cat-banner-img bg-img" style="background-attachment: local;background: url({!! URL::asset('img/category/'.\App\Category::where('slug_name','=', $name )->first()['featured_img_banner']) !!});">
            <div class="cat-banner-cont">
                @if(\App\Category::where('slug_name','=', $name )->first()['displayed_name'] === 0)
                <div class="category-title">{!! \App\Category::where('slug_name','=', $name )->first()['name'] !!}</div>
                @else
                @endif 
                @if(\App\Category::where('slug_name','=', $name )->first()['displayed_discription'] === 0)
                <div class="category-desc">{!! \App\Category::where('slug_name','=', $name )->first()['description'] !!}</div>
                @else 
                @endif
            </div>
        </div>
        @break
        @endforeach
    @else
    <div class="cat-banner-img bg-img" style="background-attachment: local;background: url({!! URL::asset('img/category/'.\App\Category::where('slug_name','=', 'all-products' )->first()['featured_img_banner']) !!});">
            <div class="cat-banner-cont">
                @if(\App\Category::where('slug_name','=', 'all-products' )->first()['displayed_name'] === 0)
                <div class="category-title">{!! \App\Category::where('slug_name','=', 'all-products' )->first()['name'] !!}</div>
                @else
                @endif 
                @if(\App\Category::where('slug_name','=', 'all-products' )->first()['displayed_discription'] === 0)
                <div class="category-desc">{!! \App\Category::where('slug_name','=', 'all-products' )->first()['description'] !!}</div>
                @else 
                @endif
            </div>
        </div>
    @endif
</div>
<a id="prodlist" class="anchor"></a>
<div id="products">
    <div class="row title-head">                                    
        <div class="cat-name col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-xs-10">
                    <div class="ttl-cat">ALL PRODUCTS</div>
                    <div class="item-cat"><span>{{ count($countProducts) }}</span> items found</div>
                </div>
                <div class="col-xs-2">
                    <div class="filter-button">
                        <button type="button" class="filter-toggle collapsed" data-target="#side-filter">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-sort col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="sort-cat">
                <div class="text">Sort by:</div>
                <div class="options">   
                    <select id="sortable">
                        <option value="name-asc" {{ $sort == "name-asc" ?'selected="selected"':'' }} >Name A-Z</option>
                        <option value="name-desc" {{ $sort == "name-desc" ?'selected="selected"':'' }} >Name Z-A</option>
                        {{-- <option value="Popularity">Popularity</option> --}}
                        {{-- <option value="Best Selling">Best Selling</option> --}}
                        <option value="price-desc" {{ $sort == "price-desc" ?'selected="selected"':'' }} >Price High to Low</option>
                        <option value="price-asc" {{ $sort == "price-asc" ?'selected="selected"':'' }} >Price Low to High</option>
                        {{-- <option value="New Items">New Items</option> --}}
                        {{-- <option value="By Review">By Review</option> --}}
                    </select>
                </div>
            </div>
            <div class="list-view-btn">
                <div id="btnContainer">
                    @php
                    	$product_view = session('product_view');
                    @endphp
                    <div class="text">View:</div>
                	<button class="grid {{!empty($product_view) ? ($product_view=='gridView' ? 'active' : '') : 'active'}}" data-prodview="gridView"><i class="fa fa-th-large"></i></button>
                	<button class="list {{!empty($product_view) ? ($product_view=='listView' ? 'active' : '') : ''}}" data-prodview="listView"><i class="fa fa-bars"></i></button> 
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="side-filter" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 filter collapse">
            <div class="panel panel-jrlb">
                <!-- Please add class="selected-filter-item" when filter item is selected. -->
                <div class="filter-area">
                    <div class="filter-ttl">
                        <div class="filter-ttl-txt">
                            <div class="title">Filter by:</div>
                            <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter');return false;">CLEAR ALL</button></div>
                        </div>
                        <div class="filter-ttl-btn">
                            <p id="click_advance"><i class="fa fa-minus"></i></p>
                        </div>
                    </div>
                    <div class="filter-content" id="display_advance">
                    @if (!empty($myfilter))
                    @php $elementOne = true; @endphp
                    @foreach ($myfilter as $main => $getfltr)
                        @foreach ($getfltr as $itemkey => $itemval)
                        @if($main == 'undefined')
                        @php $elementOne = false; @endphp
                        @else
                            <div class="selected-filter"><span>{{ (strpos($itemval,'rating') !== false ? $itemval.' Star' : $itemval) }}</span>&nbsp&nbsp<a href="/delfilt/{{ $type }}/{{ $main }}/{{ $itemkey }}#prodlist"><i class="fa fa-times"></i></a></div>  
                        @endif
                        @endforeach
                    @endforeach
                    @else
                        <p class="text-center">No filters are selected</p>
                    @endif
                    </div>
                </div>
                <div class="filter-area">
                    <div class="filter-ttl">
                        <div class="filter-ttl-txt">
                            <div class="title">Related Categories</div>
                            <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter.category');return false;">CLEAR</button></div>
                        </div>
                        <div class="filter-ttl-btn">
                            <p id="click_advance2"><i class="fa fa-minus"></i></p>
                        </div>
                    </div>
                    <div class="filter-content" id="display_advance2">
                        <ul class="filter-items checkbox">
                            @foreach($getCategory as $getCategoryRows)
                            <!-- <li ><label><a href="#"  data-value="{{ $getCategoryRows->slug_name }}" class="cat-select list" data-gettype="ps"  data-filter-type = "category">{{ $getCategoryRows->name }}</a></label></li> -->
								@if($getCategoryRows->name == 'All Categories')
                        		@else
                                <li ><label><input type="checkbox" {{ isset($myfilter['category']) && in_array('category: '.strtolower($getCategoryRows->slug_name),$myfilter['category'])?'checked="checked"':'' }} value="{{ $getCategoryRows->slug_name }}" class="cat-select" data-gettype="ps"  data-filter-type = "category" > {{ $getCategoryRows->name }}</label></li> 
                        		@endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-area">
                    <div class="filter-ttl">
                        <div class="filter-ttl-txt">
                            <div class="title">Brand</div>
                            <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter.brand');return false;">CLEAR ALL</button></div>
                        </div>
                        <div class="filter-ttl-btn">
                            <p id="click_advance3"><i class="fa fa-minus"></i></p>
                        </div>
                    </div>
                    <div class="filter-content" id="display_advance3">
                        @if(count($brands) > 0)
                            @if(empty($uid))
                            @foreach ($brands as $brand)
                                @if($brand['BrandData']['hide_brand']== 0)
                                <div class="checkbox">
                                    <label><input type="checkbox" {{ isset($myfilter['brand']) && in_array('brand: '.strtolower($brand["BrandData"]->slug_name),$myfilter['brand'])?'checked="checked"':'' }} data-key="{{ isset($myfilter['brand'])? array_search('brand: '.strtolower($brand->BrandData->name),$myfilter['brand']):'' }}" data-gettype="{{ $type }}" data-filter-type="brand" value="{{ strtolower($brand["BrandData"]->slug_name) }}" class="cat-select">{{ ucwords($brand->BrandData->name) }}</label>
                                </div>
                                @endif
                            @endforeach
                            @else
                            @foreach ($brands as $brand)
                                @if(\App\User::where('id', $uid)->first()['users_type_id'] == 3)
                                <div class="checkbox">
                                    <label><input type="checkbox" {{ isset($myfilter['brand']) && in_array('brand: '.strtolower($brand["BrandData"]->slug_name),$myfilter['brand'])?'checked="checked"':'' }} data-key="{{ isset($myfilter['brand'])? array_search('brand: '.strtolower($brand->BrandData->name),$myfilter['brand']):'' }}" data-gettype="{{ $type }}" data-filter-type="brand" value="{{ strtolower($brand["BrandData"]->slug_name) }}" class="cat-select">{{ ucwords($brand->BrandData->name) }}</label>
                                </div>
                                @elseif(in_array($brand['brand_id'], $userBrands))
                                    <div class="checkbox">
                                        <label><input type="checkbox" {{ isset($myfilter['brand']) && in_array('brand: '.strtolower($brand["BrandData"]->slug_name),$myfilter['brand'])?'checked="checked"':'' }} data-key="{{ isset($myfilter['brand'])? array_search('brand: '.strtolower($brand->BrandData->name),$myfilter['brand']):'' }}" data-gettype="{{ $type }}" data-filter-type="brand" value="{{ strtolower($brand["BrandData"]->slug_name) }}" class="cat-select">{{ ucwords($brand->BrandData->name) }}</label>
                                    </div>
                                @else
                                @endif
                            @endforeach
                            @endif
                        @else
                            <p class="text-center">No brand selection</p>
                        @endif
                    </div>
                </div>
                <div class="filter-area">
                    <div class="filter-ttl">
                        <div class="filter-ttl-txt">
                            <div class="title">Price</div>
                            <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter.price');return false;">CLEAR</button></div>
                        </div>
                        <div class="filter-ttl-btn">
                            <p id="click_advance4"><i class="fa fa-minus"></i></p>
                        </div>
                    </div>
                    <div class="filter-content" id="display_advance4">
                        <div class="range-text">Select price range</div>
                        <div class="form-group">
                            <b id="priceValmin">{{ isset($pricesRnge[0])?$pricesRnge[0]:0 }}</b> - <b id="priceValmax">{{ isset($pricesRnge[1])?$pricesRnge[1]:$productsRangePrice }}</b>
                        </div>
                        <div class="form-group">
                            <input id="priceRange"  class="span2" value="" data-slider-min="0" data-slider-max="{{ $productsRangePrice }}" data-slider-step="1" data-slider-value="[0,{{ $productsRangePrice }}]"/>
                            <div id="sliderAmount"></div>​
                        </div>
                        <div class="price-range-input">
                            <input type="number" id="inputMin" value="{{ isset($pricesRnge[0])?$pricesRnge[0]:0 }}" onchange="updateSlider(this.value)" value=""  class="price-range-field" placeholder="Min" />
                            <div class="range-line"></div>
                            <input type="number" id="inputMax" value="{{ isset($pricesRnge[1])?$pricesRnge[1]:$productsRangePrice }}" onchange="updateSlider(this.value)"  value="" class="price-range-field" placeholder="Max" />
                            <div class="apply-range text-right">
                                <a href="{{ url('/putfilt/ps/price/'.(isset($pricesRnge[0])?$pricesRnge[0]:0).'-'.(isset($pricesRnge[1])?$pricesRnge[1]:$productsRangePrice)) }}" class="priceRange apply-btn btn btn-primary btn-sm">Apply</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-area">
                    <div class="filter-ttl">
                        <div class="filter-ttl-txt">
                            <div class="title">Rating</div>
                            <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter.rating');return false;">CLEAR</button></div>
                        </div>
                        <div class="filter-ttl-btn">
                            <p id="click_advance5"><i class="fa fa-minus"></i></p>
                        </div>
                    </div>
                    <div class="filter-content" id="display_advance5">
                        <ul class="filter-items" style="font-size: 18px;list-style-type: none;">
                            <li class="filter-star cat-select">
                                <a href="{{ url('/putfilt/ps/rating/5') }}" class="list" value="5 star">
                                @if($ratingRnge == "5")
                                    <span class="fa fa-circle" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>                                    
                                @else
                                    <span class="fa fa-circle-o" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @endif
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </a>
                            </li>
                            <li class="filter-star cat-select">
                                <a href="{{ url('/putfilt/ps/rating/4') }}" class="list" value="4 star">                                
                                @if($ratingRnge == "4")
                                    <span class="fa fa-circle" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @else
                                    <span class="fa fa-circle-o" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @endif
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>
                                </a>
                            </li>
                            <li class="filter-star cat-select">
                                <a href="{{ url('/putfilt/ps/rating/3') }}" class="list" value="3 star">                                
                                @if($ratingRnge == "3")
                                    <span class="fa fa-circle" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @else
                                    <span class="fa fa-circle-o" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @endif
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                </a>
                            </li>
                            <li class="filter-star cat-select">
                                <a href="{{ url('/putfilt/ps/rating/2') }}" class="list" value="2 star">
                                @if($ratingRnge == "2")
                                    <span class="fa fa-circle" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @else
                                    <span class="fa fa-circle-o" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @endif
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                </a>
                            </li>
                            <li class="filter-star cat-select">
                                <a href="{{ url('/putfilt/ps/rating/1') }}" class="list" value="1 star">                                
                                @if($ratingRnge == "1")
                                    <span class="fa fa-circle" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @else
                                    <span class="fa fa-circle-o" style="font-size: 7px;position: relative;top: -5px;left: -1px;"></span>
                                @endif
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span class="fa fa-star-o"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--div class="filter-area">
                    @foreach ($variables as $variable)
                        <div class="filter-ttl">
                            <div class="filter-ttl-txt">
                                <div class="title">{{ $variable->name }}</div>
                                <div class="clear"><button class="button clear-filter" onclick="getClearAll('{{ $type }}','myfilter.{{ ($variable->name) }}');return false;">CLEAR ALL</button></div>
                            </div>
                            <div class="filter-ttl-btn">
                                <p id="click_advance6"><i class="fa fa-minus"></i></p>
                            </div>
                        </div>
                        <div class="filter-content" id="display_advance6">
                            @foreach ($variable->AttributeData as $attribute)
                                <div class="checkbox">
                                    <label><input type="checkbox" {{ isset($myfilter[($variable->name)]) && in_array(($variable->name.': '.$attribute->name),$myfilter[($variable->name)])?'checked="checked"':'' }} class="cat-select" data-key="{{ isset($myfilter[($variable->name)])? array_search(($variable->name.': '.$attribute->name),$myfilter[($variable->name)]):'' }}" data-filter-type = "{{ ($variable->name) }}" data-gettype = "{{ $type }}" value="{{ $attribute->name }}">{{ ucwords($attribute->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div-->
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 products-list">
            @if($products->count() > 0)
                <div id="row-list">
                    @foreach($products as $getItems)
                            <div class=" {{!empty($product_view) ? ($product_view=='gridView' ? 'grid' : 'list') : 'grid'}}">
                            <a href="/product/{{ $getItems->slug_name }}">
                                <div class="category-item">
                                    <div class="blk-one">
                                        @if ($getItems->featured_image != "")
                                            <div class="cat-item-img bg-img-prod" style="background: url({{ URL::asset('img/products/'.$getItems->featured_image.'') }});"><div style="position: relative">
                                            @php $user_type = \App\User::where('id', Auth::id())->first()['users_type_id']; @endphp
                                            @if (\App\UserBrands::where('user_id', $uid)->where('brand_id', \App\Product::with('BrandData')->findOrFail($getItems->id)->BrandData['id'])->get()->isEmpty() || \App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->get()->isEmpty())                                        
                                                @if ($getItems->is_sale == 1)
                                                <div class="discount-tag" style="position: absolute">
                                                    @if ($getItems->discount_type == 'fix')
                                                        <div class="disc amount" style="height: inherit">₱ {{$getItems->discount}}<br /> OFF</div>
                                                    @else
                                                        <div class="disc amount" style="height: inherit">{{ $getItems->discount}}%<br /> OFF</div>
                                                    @endif
                                                </div>
                                                @endif
                                            @else
                                                @if(\App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['price'] != 0)
                                                <div class="discount-tag" style="position: absolute">
                                                    @if (\App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['discount_type'] == 'fix')
                                                    <div class="disc amount" style="height: inherit">₱ {{\App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['price']}}<br /> OFF</div>
                                                    @else
                                                    <div class="disc amount" style="height: inherit">{{ \App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['price']}}%<br /> OFF</div>
                                                    @endif
                                                </div>
                                                @else
    
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                        @else
                                            <div class="cat-item-img bg-img-prod" style="background: url({{ URL::asset('img/materials/prod1.jpg') }});"></div>
                                        @endif
                                    </div>
                                    <div class="blk-two">
                                        <div class="item-title">{{ ucwords($getItems->name) }}</div>
                                        <div class="item-desription">
                                            {!! $getItems->description !!}
                                        </div>
                                    </div>
                                    <div class="blk-three">
                                        @php
                                            $price = ($getItems->is_sale == 1) ? $getItems->sale_price : $getItems->price;
                                            $price_before = ($getItems->is_sale == 1) ? $getItems->price : $getItems->sale_price;
                                            $user_type = \App\User::where('id', Auth::id())->first()['users_type_id'];
                                        @endphp
                                        {{-- @if(\App\UserBrands::where('user_id', $uid)->where('brand_id', \App\Product::with('BrandData')->findOrFail($getItems->id)->BrandData['id'])->get()->isEmpty() || \App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->get()->isEmpty()) --}}
                                            @if(empty($uid))
                                                @if($getItems->discount_type == 'fix')
                                                    <div class="price">₱ {!! number_format($getItems->price - $getItems->discount,2); !!}</div>
                                                @else
                                                    <div class="price">₱ {!! number_format($getItems->price - ($getItems->discount * $getItems->price / 100  ) ,2) !!}</div>
                                                @endif
                                            @else 
                                                @if($getItems->discount_type == 'fix')
                                                    <div class="price">₱ {!! number_format($getItems->price - $getItems->discount,2); !!}</div>
                                                @else
                                                    <div class="price">₱ {!! number_format($getItems->price - ($getItems->discount * $getItems->price / 100  ) ,2) !!}</div>
                                                @endif
                                            @endif
                                        {{-- @endif --}}
                                        <div class="regular-price">
                                            @if(\App\UserBrands::where('user_id', $uid)->where('brand_id', \App\Product::with('BrandData')->findOrFail($getItems->id)->BrandData['id'])->get()->isEmpty() || \App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->get()->isEmpty())  
                                                @if($getItems->is_sale == 1)
                                                    @if($getItems->discount_type == 'fix')
                                                    <span class="price-before"> ₱ {!! number_format($getItems->price, 2) !!}</span>
                                                    @elseif($getItems->discount_type == 'percentage')
                                                    <span class="price-before">  ₱ {!! number_format($getItems->price, 2) !!}</span>
                                                    @else

                                                    @endif
                                                @endif
                                            @else
                                                @if($getItems->is_sale == 1)
                                                    @if(\App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['discount_type'] == 'fix')
                                                    <span class="price-before"> ₱ {!! number_format($getItems->price, 2) !!}</span>
                                                    @elseif(\App\ProductUserPrice::where('product_id', $getItems->id)->where('user_types_id', $user_type)->first()['discount_type'] == 'percentage')
                                                    <span class="price-before">  ₱ {!! number_format($getItems->price, 2) !!}</span>
                                                    @else

                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                        <div style="position: relative">
                                        <div class="stars" style="position: absolute">
                                        @php $getItems->rating; @endphp  

                                        @foreach(range(1,5) as $i)

                                                @if($getItems->rating >0 && \App\ProductReviewsandRating::where('product_id',$getItems->id)->first()['is_approved'] == 1)
                                                    @if($getItems->rating >0.5)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                @endif
                                                @php $getItems->rating--; @endphp
                                        @endforeach
                                        </div>
                                        </div>
                                        {{-- <button class="button button--aylen" tabindex="-1">View Details</button> --}}
                                    </div>
                                </div>
                            </a>
                            </div>
                    @endforeach
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                    {{  $products->links() }}
                </div>
            @else
                <div class="search-result col-md-12 col-sm-12 col-xs-12 text-center">
                    <p><h3>Search No Result</h3></p>
                    <p>Your search <u><i><b>{{ $search }}</b></i></u> did not match any products</p>
                </div>      
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
    
@endsection