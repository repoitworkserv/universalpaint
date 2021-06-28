@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">{{ ucwords( str_replace("_", " ", $searchCat)) }} Products</div>
		<div class="product-tile">
        @if(!empty($return_sub_cat))
            @foreach($return_sub_cat as $key => $val)
                <div class="product-tile">
                    <div class="heading-cat">{{ $key }}</div>
                    <div class="block">
                        @php
                            $ctr = 0;
                        @endphp	                        
                        @foreach($val['product'] as $list)
                            @php $ctr++;  @endphp
                            <div class="categories-img">
                                <div class="prod-img" style="background-image:  url({!! asset('img/products') !!}/{{$list->featured_image}}); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <a href="/product/{{ $list->slug_name }}"></a></div>
                                <a href="/product/{{ $list->slug_name }}"><div class="title">{{ $list->name }}</div></a>

                            </div>    
                            @if($ctr == 4)
                                @break;
                            @endif	                
                        @endforeach	
                    </div>
                    <div class="align-cntr-btn"><a href="/product-category/{{$searchCat}}/{{$val['slug_name']}}" target="_blank"><u>View all {{ $key }} paint &gt;</u></a></div>
                </div>
            @endforeach
        @endif		
	</div>
</div>

@endsection