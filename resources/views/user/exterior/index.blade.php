@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Exterior Products</div>
		<div class="product-tile">
			<div class="heading-cat">Door Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_door as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		</div>
		<div class="product-tile">
			<div class="heading-cat">Wall Paint</div>

			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_wall as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/wall" target="_blank"><u>View all wall paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Floor Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_floor as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all floor paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Ceiling Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_ceiling as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all ceiling paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Furniture Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_furniture as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all funiture paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Automative Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_automative as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all automative paint &gt;</u></a></div>
		</div>

		<div class="product-tile">
			<div class="heading-cat">Roof Paint</div>
			<div class="block">
				@php
					$ctr = 0;
				@endphp				 	
				@foreach($exterior_roof as $list)
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
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all roof paint &gt;</u></a></div>

		</div>
	</div>
</div>

@endsection