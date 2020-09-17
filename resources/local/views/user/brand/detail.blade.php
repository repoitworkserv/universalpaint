@extends('layouts.user.app')
@php
	 $img = URL::asset('img/brand').'/'.$featuredimg;
	 $url = URL::to('/').'/brand/'.$slugname;
@endphp

@section('ogtitle'){!!$selectedBrand->name!!}@stop
@section('ogdescription'){!!$selectedBrand->description!!}@stop
@section('ogurl',''){!!$url!!}@stop
@section('ogimg'){!! $img !!}@stop
@section('content')
<div id="brand-detail">
    <div class="category-banner">
        <div class="cat-banner-img bg-img" style="background-attachment: local;background: url({{ URL::asset('img/brand/'.$selectedBrand->featured_img_banner.'') }});">
            <div class="cat-banner-cont">
            </div>
        </div>
        <a name="prodlist"></a>
    </div>
    <div class="pg-hdr">
        <div class="page-header">
            <div class="page-title"><a href="{{ url::to('/') }}">Home </a><span><a href="{{ URL::to('/brands') }}"> All Brands</a></span><span>{{$selectedBrand->name}}</span></div>
        </div>
    </div>
    <div class="brand-detail-container">
        <div class="brand-detail-side">
            <div class="ttl">Our Brands</div>
            <div class="items">
                <ul>
                    @foreach($brand as $item)
                        @if(empty($uid))
                            @if ($item->slug_name != 'other')
                                <li class="{{$item->slug_name == $selectedBrand->slug_name ? 'active' : ''}}"><a href="/brand/{{$item->slug_name}}">{{$item->name}}</a></li>
                            @endif
                        @else 
                            @if ($item->slug_name != 'other')
                                @if(\App\User::where('id', $uid)->first()['users_type_id'] == 3)
                                    <li class="{{$item->slug_name == $selectedBrand->slug_name ? 'active' : ''}}"><a href="/brand/{{$item->slug_name}}">{{$item->name}}</a></li>
                                @else
                                    @if(in_array($item->id, $userBrands))
                                        <li class="{{$item->slug_name == $selectedBrand->slug_name ? 'active' : ''}}"><a href="/brand/{{$item->slug_name}}">{{$item->name}}</a></li>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="brand-detail-main">
            <div class="hdr">
                <div class="ttl">
                   <div class="mn">{{$selectedBrand->name}}</div>
                   <div class="sb">{{$productCount}} products under this brand</div>
                </div>
                 <div class="socialmedias">
                	<div class="share-btns">
                        <div class="social-btns">
                            <div><a  target="_blank" href="https://www.facebook.com/EZDealOnline/"><img src="{{ URL::asset('img/icons/large-001-facebook.png') }}" class="logo"></a></div>&nbsp;&nbsp;
                            <div><div class="icon-item"><a target="_blank" href="https://shopee.ph/ezdeal"><img src="{{ URL::asset('img/icons/large-001-shopee.png') }}" class="logo"></a></div></div>&nbsp;&nbsp;
                        </div>
                    </div>
                 </div>
            </div>
        	<div id="viewscroll"></div>
            <div class="cntnt">
                {{$selectedBrand->description}}
            </div>
            <div class="prdct">
                <div id="row-list">
                    <div class="pagination">{{ $sampleProducts->fragment('viewscroll')->links() }}</div>
                    @foreach($sampleProducts as $item)
                        <div class=" {{!empty($product_view) ? ($product_view=='gridView' ? 'grid' : 'list') : 'grid'}}">
                        <a href="/product/{{ $item->slug_name }}">
                            <div class="category-item">
                                <div class="blk-one">
                                    @if ($item->featured_image != "")
                                        <div class="cat-item-img bg-img" style="background: url({{ URL::asset('img/products/'.$item->featured_image.'') }});"></div>
                                    @else
                                        <div class="cat-item-img bg-img" style="background: url({{ URL::asset('img/materials/prod1.jpg') }});"></div>
                                    @endif
                                </div>
                                <div class="blk-two">
                                    <div class="item-title">{{ ucwords($item->name) }}</div>
                                    <div class="item-desription">
                                        This is a sample content. Information that should be written here must be provided by the client. We also provide Content Writing service for a reasonable cost. For further inquiry, please contact your Client Services Executive.
                                    </div>
                                </div>
                                <div class="blk-three">
                                    @php
                                        $price = ($item->is_sale == 1) ? $item->sale_price : $item->price;
                                        $price_before = ($item->is_sale == 1) ? $item->price : $item->sale_price;
                                    @endphp
                                    
                                    <div class="price">₱ {{ number_format($price,2) }}</div>
                                    <div class="regular-price">
                                        @if($item->is_sale == 1)
                                            <span class="price-before"> ₱ {{ number_format($price_before,2) }}
                                        @endif
                                    </div>
                                    <div style="position: relative">
                                        <div class="stars" style="position: absolute;">
                                        @php $item->rating; @endphp  

                                        @foreach(range(1,5) as $i)

                                                @if($item->rating >0)
                                                    @if($item->rating >0.5)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                @endif
                                                @php $item->rating--; @endphp
                                        @endforeach
                                        </div>
                                        </div>
<!--                                         <button class="button button--aylen" tabindex="-1">View Details</button> -->
                                </div>
                            </div>
                        </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection