@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Industrial Products</div>
		<div class="product-tile">
			<div class="heading-cat">Door Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($industrial_door as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/industrial/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		</div>
		<div class="product-tile">
			<div class="heading-cat">Road and Sidewalk Paint</div>

			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($industrial_road_and_sidewalk as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/industrial/wall" target="_blank"><u>View all road and sidewalk paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Floor Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($industrial_floor as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/industrial/door" target="_blank"><u>View all floor paint &gt;</u></a></div>
		</div>			
	</div>
</div>

@endsection