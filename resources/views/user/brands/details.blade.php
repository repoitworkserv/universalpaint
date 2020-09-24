@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Product Brands</div>

		<div class="product-tile">
			<div class="heading-cat"></div>
			<div class="block">

					<div class="categories-img">
						<div class="prod-img" style="background-image: url({{ url('img/products/') }}/); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href="/product-category/brands/"></a></div>
						<a href="/product-category/brands/aquaGuard-elastomeric-paint"><div class="title"></div></a>
					</div>

			</div>
			<div class="align-cntr-btn"><a href="/product-category/exterior/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		</div>
	</div>
</div>

@endsection