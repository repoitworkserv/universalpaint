@extends('layouts.user.app')

@section('content')

<div id="product-page">
	<div class="container">
		<div class="sub-navigation">Exterior Products</div>
		<div class="product-tile">
			<div class="heading-cat">Door Paint</div>
			<div class="block">
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/exteriordoor/quickdry.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href="/product-category/exterior/door"></a></div>
					<a href="/product-category/exterior/door"><div class="title">Universal Professional Quick Dry Enamel</div></a>
				</div>
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/exteriordoor/plusename.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href="/product-category/exterior/door"></a></div>
					<a href="/product-category/exterior/door"><div class="title">Universal Plus Enamel Paint</div></a>
				</div>
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/exteriordoor/popularenamel.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href="/product-category/exterior/door"></a></div>
					<a href="/product-category/exterior/door"><div class="title">Popular Enamel Paint</div></a>
				</div>
			</div>
			<div class="align-cntr-btn"><a href="/product-category/exterior/door" target="_blank"><u>View all door paint &gt;</u></a></div>
		</div>
		<div class="product-tile">
			<div class="heading-cat">Wall Paint</div>
			<div class="block">
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/wall/aqua.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href=""></a></div>
					<a href=""><div class="title">AquaGuard Elastomeric Paint</div></a>
				</div>
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/wall/aquashield.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href=""></a></div>
					<a href=""><div class="title">Universal AquaShield</div></a>
				</div>
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/wall/antibac.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href=""></a></div>
					<a href=""><div class="title">Universal Advantage Anti-Bacterial Paint</div></a>
				</div>
				<div class="categories-img">
					<div class="prod-img" style="background-image: url({{ url('img/wall/acrylic.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"><a href=""></a></div>
					<a href=""><div class="title">Universal Professional Acrylic Latex Paint</div></a>
				</div>
			</div>
			<div class="align-cntr-btn"><a href="/product-category/exterior/wall" target="_blank"><u>View all wall paint &gt;</u></a></div>
		</div>
	</div>
</div>

@endsection