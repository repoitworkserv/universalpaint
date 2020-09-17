@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Interior Products</div>
		<div class="product-tile">
			<div class="heading-cat">Door Paint</div>
			<div class="block">
				@foreach($interior_door as $list)
					<div class="categories-img">
						<div class="prod-img" style="background-image:  url({!! asset('img/products') !!}/{{$list->featured_image}}); background-size: cover; background-repeat: no-repeat; background-position: center center;">
						<a href="/product/{{ $list->slug_name }}"></a></div>
						<a href="/product/{{ $list->slug_name }}"><div class="title">{{ $list->name }}</div></a>
					</div>                    
                @endforeach				
			</div>
			<div class="align-cntr-btn"><a href="/product-category/interior/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		<div class="product-tile">
			<div class="heading-cat">Wall Paint</div>

			<div class="block">
				@foreach($interior_wall as $list)
					<div class="categories-img">
						<div class="prod-img" style="background-image:  url({!! asset('img/products') !!}/{{$list->featured_image}}); background-size: cover; background-repeat: no-repeat; background-position: center center;">
						<a href="/product/{{ $list->slug_name }}"></a></div>
						<a href="/product/{{ $list->slug_name }}"><div class="title">{{ $list->name }}</div></a>
					</div>                    
                @endforeach				
			</div>			
			<div class="align-cntr-btn"><a href="/product-category/interior/wall" target="_blank"><u>View all wall paint &gt;</u></a></div>
		</div>
	</div>
</div>

@endsection