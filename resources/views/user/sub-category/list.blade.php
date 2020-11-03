@extends('layouts.user.app')


@section('content')
<style>
#product-page-list .block {
    margin-bottom: 20px;
}
</style>
<div id ="product-page-list">
	<div class="banner-img" style="background-image: url({{ url('img/p2.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>
	<div class="container">
		<div class="sub-navigation">
			<div class="nav-right"> {{ ucfirst( str_replace("_", " ", $category)) }} Products</div>
		</div>
		<div class="product-tile">
					
				@php
					$listab = array();
					$proddesc = '';
					$howtouse = '';
					$delvry_opt = '';
				@endphp
				@foreach($product as $key)
                <div class="block">	
					@php
						$listab = explode(',',$key->list_tab);
						$howtouse = $key->howtousetab_details;
						$delvry_opt = $key->deliveryopt_tab_details;
					@endphp
					@php
					$prodesc = $key->description;
					$query = App\ProductReviewsandRating::where('product_id', $key->id)->count();
					$productRating = "(" . $query .' '."Rating)". "\r\n";
					$prodprice = '';
					if($key->product_type == 'single')
						if($key->is_sale == 1)
							$prodprice = "\r\n".number_format($key->sale_price, 2);
						else
							$prodprice = "\r\n".number_format($key->price, 2);
					else 
						if($key->is_sale == 1)
							$prodprice = "\r\n".number_format($key->sale_price, 2);
						else
							$prodprice = "\r\n".number_format($key->price, 2);

							$img = URL::asset('img/products').'/'.$product[0]->featured_image;
							$prodname = $key->ParentData ? $key->ParentData['name'] :$key->name;
							$url = URL::to('/').'/product';
							@endphp
							@section('ogproduct'){!! $prodname !!}@stop               
							@section('ogtitle'){!!$prodname . ' &#8369;'.$prodprice  .  ' \r\n' .$productRating!!}@stop
							@section('ogdescription'){!! $proddesc !!}@stop
							@section('ogurl',''){!!$url!!}@stop
							@section('ogimg'){!! $img !!}@stop
							<div class="left-bx col-md-5 col-sm-12 col-12">                
							<a href="/product/{{ $key->slug_name }}">
								<div class="prod-img" style="background-image: url({!! asset('img/products') !!}/{{ $key->featured_image }}) ; background-size: cover; background-repeat: no-repeat; background-position: center center; left: 15px; position: relative;"></div>
							</a>
								
								<div class="prod-btn">
									<img src="{{ url('img/buttons/button.png') }}">
									<a href="/pdf/{{ $key->slug_name }}.pdf" class="yellow-btn">Download Product Brochure Pdf</a>
									<a href="" class="yellow-btn">Safety data Sheets (SDS)</a>
									<a href="" class="yellow-btn">Technical Data Sheet</a>
									<a href="" class="yellow-btn">Color Calculators</a>	
								</div>				
							</div>
							<div class="right-bx col-md-7 col-sm-12 col-12">
								<div class="title">{{$key->ParentData ? $key->ParentData['name'] :$key->name}}</div>
								<div class="sub-title"></div>
								<div class="desc">{!! $key->description !!}</div>
								<div class="regular-price">
									@if($key->is_sale == 1)
										@if($key->product_type == 'single')
											<span class="price-before">{{'&#8369; '. number_format($key->price, 2)}}</span> 
											@if($key->discount_type == 'fix')
												<span class="discount">{{'&#8369; ' . number_format($key->discount, 2) .' OFF'}}</span>
											@else
												<span class="discount">{{number_format($key->discount, 2).'% OFF'}}</span>
											@endif
										@else
											<span class="price-before">{{'&#8369; '. number_format($key->price, 2)}}</span> 
											@if($key->discount_type == 'percentage')
												<span class="discount">{{$key->discount .'% OFF'}}</span>
											@else
												<span class="discount">{{number_format($key->discount, 2).'% OFF'}}</span>
											@endif
										@endif
									@endif
								</div>  
								<div class="flex-txt">
									<div class="sml-ttl">Where to Use</div>
									<div class="sml-desc">{{ $key->where_to_use}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Area </div>
									<div class="sml-desc">{{ $key->area}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Best Used for</div>
									<div class="sml-desc"> {{ $key->best_used_for}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Features</div>
									<div class="sml-desc">{{ $key->features}} </div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Coverage per 4/L</div>
									<div class="sml-desc">{{ $key->coverage}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Finish</div>
									<div class="sml-desc">{{ $key->finish}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Color</div>
									<div class="sml-desc">white, black, aluminum, baby blue, baby pink, bright red, caterpillar yellow, chocolate brown, crystal blue, crystal green, international red, ivory, jade green, lemon yellow, maple, maroon, medium gray, moly orange, nile green, royal blue, silver gray</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Application</div>
									<div class="sml-desc">{{ $key->application}}</div>
								</div>
								<div class="flex-txt">
									<div class="sml-ttl">Packaging Size</div>
									<div class="sml-desc">{{ $key->packaging}}</div>
								</div>
							</div>	
                        </div>
				@endforeach						
		</div>   		
	</div>
</div>


@endsection