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
			@if (!$product->isEmpty())
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
							<a href="/product/{{ $key->slug_name }}"><div class="prod-img" style="background-image: url({!! asset('img/products') !!}/{{ $key->featured_image }}) ; background-size: cover; background-repeat: no-repeat; background-position: center center; left: 15px; position: relative;"></div></a>
						
 								<div class="prod-btn">
									<img src="{{ url('img/buttons/button.png') }}">

								@if(!empty($key->brochure_path))
								<a href="/pdf/{{$key->brochure_path}}"  target="_blank" download class="yellow-btn">Download Product Brochure Pdf</a>
								@endif
								@if(!empty($key->safety_path))
								<a href="/pdf/{{$key->safety_path}}" target="_blank" download class="yellow-btn" >Safety data Sheets (SDS)</a>
								@endif
								@if(!empty($key->technical_path))
								<a href="/pdf/{{$key->technical_path}}" target="_blank" download class="yellow-btn">Technical Data Sheet</a>
								@endif
									<a href="" class="yellow-btn">Color Calculators</a>	
								</div>				
							</div>
							<div class="right-bx col-md-7 col-sm-12 col-12">
								<div class="title">
								<a href="/product/{{ $key->slug_name }}">
									{{$key->ParentData ? $key->ParentData['name'] :$key->name}}
								</a>
								</div>
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
									@if($key->UsedAttribute->count() > 0)
									<div class="sml-desc">available in
										@if($key->UsedAttribute->count() > 20 )
											{{ $key->UsedAttribute->count() }} color{{$key->UsedAttribute->count() > 1 ? 's':'' }}
										@else 
											@foreach( $key->UsedAttribute as $attrib)
											@php
											$color_name = \App\Attribute::where('id',$attrib->attribute_id)->where('variable_id',1)->pluck('name')->first();
											@endphp
											@if(!empty($color_name))
											{{$color_name. ', '}}
											@endif
											@endforeach
									 @endif
									 </div>
									 @else 
									 <div class="sml-desc">no available colors </div>
									@endif
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
			@else
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					<p><h3>No Paint Found!</h3></p>
				</div> 
			@endif					
		</div>   		
	</div>
</div>


@endsection
