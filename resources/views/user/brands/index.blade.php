@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Product Brands</div>
		@foreach($brands as $item)
		<div class="product-tile">
			<div class="heading-cat">{{$item->name}}</div>
			<div class="block">
				@if($item['ProductByBrand'])
					@foreach($item['ProductByBrand'] as $product)
					<div class="categories-img">
						<div class="prod-img" style="background-image: url({{ url('img/products/') }}/{{ $product->featured_image }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href="/product-category/brands/{{$product->slug_name}}"></a></div>
						<a href="/product-category/brands/aquaGuard-elastomeric-paint"><div class="title">{{ $product->name }}</div></a>
					</div>
					@endforeach
				@endif
			</div>
			<div class="align-cntr-btn"><a href="/product-category/exterior/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		</div>
		@endforeach
	</div>
</div>

@endsection