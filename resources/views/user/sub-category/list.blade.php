@extends('layouts.user.app')


@section('content')
<style>
#product-page-list .block {
    margin-bottom: 20px;
}
.modal-lg {
	max-width: 1200px;
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
									@php 
										$colors       = ''; 
										$colors_count = 0;
									@endphp
									@if($key->UsedAttribute->count() > 0 || $key->ChildData->count() > 0)
									<div class="sml-desc">
										@if($key->UsedAttribute->count() > 20)
											{{ $key->UsedAttribute->count() }} color{{$key->UsedAttribute->count() > 1 ? 's':'' }}
										@elseif($key->ChildData->count() > 20) 
										{{ $key->ChildData->count() }} color{{$key->ChildData->count() > 1 ? 's':'' }}
										@else 
											@forelse( $key->ChildData as $subproduct)
												@foreach($subproduct->AttributesData as $attrib)
													@if(!empty($attrib->name) && $attrib->VariableData->name == "Color" && !preg_match("/{$attrib->name}/i", $colors))
													@php  
														$colors .=  $attrib->name .', ';
														$colors_count++;
													@endphp
													@endif
												@endforeach
											@empty
												@foreach( $key->UsedAttribute as $attrib)
												@php
													$color_name = \App\Attribute::where('id',$attrib->attribute_id)->where('variable_id',1)->pluck('name')->first();
													@endphp
													@if(!empty($color_name))
													  @php $colors .=  $color_name.', '; @endphp
														@endif
												@endforeach
											@endforelse
											@if(!empty(trim($colors))) Available in {{$colors}} @else No available colors.  @endif 
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
								<hr>
								<div class="flex-txt">
										{{ csrf_field() }}
										<input type="hidden" id="productName" name="productName" value="{{ $prodname }}">
										<input type="hidden" name="productId" id="productId" value="{{ $key->id }}">
										<input type="hidden" name="subProductId" id="subProductId" value="{{ $key->id }}">
										<input type="hidden" id="colorChoose" name="colorChoose" value>
										<input type="hidden" name="colorCss" id="colorCss">
										<input type="hidden" name="colorCount" id="colorCount" value=" @if($key->ChildData->count() > 0) {{ $key->ChildData->count() }} @elseif($colors_count <= 0) {{ $key->UsedAttribute->count() }} @else  {{$colors_count}} @endif">
									<div class="sml-ttl">			
											@if($key->ChildData->count() > 0 || $key->UsedAttribute->count() > 0)																		
												@if($colors_count > 0 || $key->UsedAttribute->count() > 0  || $key->ChildData->count() > 0)
													<div class="option-field">
														<select class="form-control productattri_list" name="colorNameP">
																<option value="">Select Color</option>		
																<option data-img_src="/img/loading.gif" value=""> </option>	
														</select>
													</div>																														
												<div class="option-field mt-2">
													<select class="form-control product_liters_list @if($key->ChildData->count() <= 0) no_color @endif" name="product_liters" required="" @if($colors_count > 0 || $key->UsedAttribute->count() > 0) disabled @endif>
															<option value="">Select Liters</option>
													</select>    
												</div> 
												@endif					
										@else 
											<div class="option-field mt-2">
												<select class="form-control product_liters_list @if($key->ChildData->count() <= 0) no_color @endif" name="product_liters" required="" style="display:none">
														<option value="">N/A</option>
												</select>    
											</div> 
										@endif
									</div>                                            
									<div class="sml-ttl">
									</div>
								</div>		
								<div class="row">
									<div class="sml-ttl sml-ttl-fifteen">
										<input type="hidden" id="var-count" value="2">
										<div id="quantity_id" class="quantity-select">                                                    
										@if($key->ChildData->count() > 0 || $key->UsedAttribute->count() > 0)				
											<input type="number" class="prod_qty numbers-only" min="1" data-cartid="cart_id" value="1" name="quantity" required>                                             
										@else 
											<input type="number" class="prod_qty numbers-only" max="{{$key->quantity}}" min="@if($key->quantity > 0){{'1'}}@else{{'0'}}@endif" data-cartid="cart_id" value="@if($key->quantity > 0){{'1'}}@else{{'0'}}@endif" name="quantity" required>          
										@endif
										</div>
									</div>
									<div class="option-list col-lg-10 col-md-10 col-sm-10 col-xs-10">
										<div class="flex-txt">
											<button name="add_to_cart" class="button addtocart_from_listing gotocart" tabindex="-1">PROCEED TO CART &nbsp;<i class="fas fa-shopping-bag"></i></button>
											<img class="loading_cart_product_list" src="{{URL::asset('img/loading.gif')}}" width="30" height="10"/>
											@if($key->ChildData->count() <= 0 && $key->UsedAttribute->count() <= 0 && $key->quantity <= 0)		
												<span class="error_message_listing" style="visibility: visible">OUT OF STOCK!</span>   
											@else
												<span class="error_message_listing">OUT OF STOCK!</span>       
											@endif
										</div>
									</div>
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

<!-- Modal -->
<div class="modal fade" id="colorSwatchesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Color Swatches</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div id="color-swatches" class="mt-0">
					<div class="container">
						<div class="heading">Color Charts and Brochures</div>
						<div class="sub-heading">Browse by colour scheme</div>
						<div class="color-tab">
							<div class="tab">
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12 active" data-color="View-All-Colors">
									<div class="color-picker">
										<div class="color-box" id="view-all-colors" style="background-color:#ccc;"></div>
										<div class="ttl">View </br>All Colors</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="White">
									<div class="color-picker">
										<div class="color-box" style="background-color:#F6F7F2;"></div>
										<div class="ttl">Whites </br>& Neutrals</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Grey">
									<div class="color-picker">
										<div class="color-box" style="background-color:#373E42;"></div>
										<div class="ttl">Greys</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Brown" id="defaultOp">
									<div class="color-picker">
										<div class="color-box" style="background-color:#B39F94;"></div>
										<div class="ttl">Browns</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Purple">
									<div class="color-picker">
										<div class="color-box" style="background-color:#7E7999;"></div>
										<div class="ttl">Purples</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Blue">
									<div class="color-picker">
										<div class="color-box" style="background-color:#0045C7;"></div>
										<div class="ttl">Blues</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Green">
									<div class="color-picker">
										<div class="color-box" style="background-color:#9DBFAF;"></div>
										<div class="ttl">Greens</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Yellow">
									<div class="color-picker">
										<div class="color-box" style="background-color:#FAE196;"></div>
										<div class="ttl">Yellows</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Orange">
									<div class="color-picker">
										<div class="color-box" style="background-color:#CC5327;"></div>
										<div class="ttl">Oranges</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Red">
									<div class="color-picker">
										<div class="color-box" style="background-color:#A8312F;"></div>
										<div class="ttl">Reds</div>
									</div>
								</div>
								<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12 bestselling-colors" data-color="Regular-Colors">
									<div class="color-picker">
										<div class="color-box" id="regular-colors" style="background-color:#ccc;"></div>
										<div class="ttl">Best </br>Selling Colors</div>
									</div>
								</div>
							</div>
							<div class="btnProceedDiv">
							</div>
						</div>
						<div class="color-section row">
							<div id="White" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Grey" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Brown" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Purple" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Blue" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Blue" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Green" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Yellow" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Orange" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Red" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
							<div id="Regular-Colors" class="tabcontent" style="display: block;">
								<div class="box-widget">
									<div class="color-picker row">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger">Select Color</button>
      </div>
    </div>
  </div>
</div>

						

@endsection
