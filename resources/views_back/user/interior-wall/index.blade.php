@extends('layouts.user.app')


@section('content')

<div id ="product-page-list">
	<div class="banner-img" style="background-image: url({{ url('img/p2.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
	<div class="container">
		<div class="sub-navigation">
			<div class="nav-right">Interior Products | Wall Paint</div>
		</div>
		<div class="product-tile">
			<div class="block">
				<div class="left-bx">
					<div class="prod-img" style="background-image: url({{ url('img/wall/aqua.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
					<div class="prod-btn">
						<img src="{{ url('img/buttons/button.png') }}">
						<a href="" class="yellow-btn">Download Product Brochure Pdf</a>
						<a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
						<a href="" class="yellow-btn">Technical Data Sheet</a>
						<a href="" class="yellow-btn">Color Calculators</a>	
					</div>				
				</div>
				<div class="right-bx">
					<div class="title">AquaGuard Elastomeric Paint</div>
					<div class="sub-title"></div>
					<div class="desc">AquaGuard is a premium quality elastomeric paint, it features a flexible and ultra-durable coating that fills and covers existing or developing cracks on your wall - creating a waterproof barrier against rain from entering your home. Guaranteed to protect your home against all types of tropical weather.</div>
					<div class="feat-ttl">BEST FEATURES</div>
					<div class="flex-txt">
						<div class="sml-ttl">Where to Use</div>
						<div class="sml-desc">Interior and Exterior</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Area </div>
						<div class="sml-desc">Wall</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Best Used for</div>
						<div class="sml-desc">Masonry, concrete, stucco</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Features</div>
						<div class="sml-desc">Elastomeric, Crack bridging, low VOC, low odor, fade resistant colors, available in 1000's of colors</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Coverage per 4/L</div>
						<div class="sml-desc">25 - 30 sqm</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Finish</div>
						<div class="sml-desc">Satin</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Color</div>
						<div class="sml-desc">Color Depot 1000's of colors</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Application</div>
						<div class="sml-desc">brush, roller & spray</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Packaging Size</div>
						<div class="sml-desc">4L & 16L</div>
					</div>
				</div>				
			</div>
		</div>
		<div class="product-tile">
			<div class="block">
				<div class="left-bx">
					<div class="prod-img" style="background-image: url({{ url('img/wall/aquashield.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
					<div class="prod-btn">
						<img src="{{ url('img/buttons/button.png') }}">
						<a href="" class="yellow-btn">Download Product Brochure Pdf</a>
						<a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
						<a href="" class="yellow-btn">Technical Data Sheet</a>
						<a href="" class="yellow-btn">Color Calculators</a>	
					</div>				
				</div>
				<div class="right-bx">
					<div class="title">Universal AquaShield</div>
					<div class="sub-title"></div>
					<div class="desc">AquaShield is 2 component cementitious water proofing compound the dries to a flexible, tough and very durable, abrasion resistant coating. Designed for all weather waterproofing</div>
					<div class="feat-ttl">BEST FEATURES</div>
					<div class="flex-txt">
						<div class="sml-ttl">Where to Use</div>
						<div class="sml-desc">Interior and Exterior</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Area </div>
						<div class="sml-desc">Wall & floor</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Best Used for</div>
						<div class="sml-desc">Horizontal & Vertical Concrete surfaces and areas where water ponding may occur like balconies and bathroom</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Features</div>
						<div class="sml-desc">Elastomeric, Crack bridging, highly durable, abrasion resistant, superior adhesion to concrete surfaces</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Coverage per 4/L</div>
						<div class="sml-desc">25 - 30 sqm</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Finish</div>
						<div class="sml-desc"></div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Color</div>
						<div class="sml-desc">White dries to cement color </div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Application</div>
						<div class="sml-desc">brush & roller</div>
					</div>
					<div class="flex-txt">
						<div class="sml-ttl">Packaging Size</div>
						<div class="sml-desc">4L & 16L</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>


@endsection