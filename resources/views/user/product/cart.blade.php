@extends('layouts.user.app')
<meta charset="utf-8" />
@section('css')
<style>
   #footer {
   display: none !important;
   }
   .img{
   width: 100%;
   height: 100px;
   background-repeat: no-repeat !important;
   background-size: contain !important;
   background-position: center center !important;
   }
   .productname{
   text-align: center;
   font-size: x-small;
   width: 100px;
   }
   .active {
   border: 3px solid red;
   box-shadow: 2px 4px gray;
   }
</style>
@endsection
@section('content')
<div id="first-content" class="cart-content">
	<div class="cart-container">
		<div id="cart">
			<div class="row">
					<div class="col-lg-12">
						@if($cart)
						{!! csrf_field() !!}
						<table class="table table-striped cart-table">
								<thead class="cart-header">
									<tr>
											<th>Color</th>
											<th>Image</th>
											<th>Item</th>
											<th>Liters/Paint Type</th>
											<th>Quantity</th>
											<th>Price</th>
									</tr>
								</thead>
								<tbody>
									@php $x=0; $ctr = 0; @endphp
									@php $total_subtotal = 0.00;
                  $Page = \App\Post::find(1);
                  @endphp
									@foreach($cart as $key => $item)
									@php
									$price = $item['product_details'][0]['is_sale'] !== 0 ?  $item['product_details'][0]['sale_price'] : $item['product_details'][0]['price'];
									$qty   = $item['product_details'][0]['qty'];
									$subtotal = $price * $qty;
									$total_subtotal += $subtotal;
									@endphp 
									@if($ctr == 9)
									<tr class="header_print cart-color-details-tr">
									<td colspan="6">
									</td>
									</tr>
									<tr class="header_print cart-color-details-tr">
									<td colspan="6">
										<div style="display:flex; justify-content:space-between;margin-top: 20px;">
											<div style="margin-top: 30px; margin-bottom: 40px; margin-left: -235px;">
												<a href="/"><img src="{{ url('img/logo_nav.png') }}" alt="UNIVERSAL PAINT"></a>
											</div>
                    @if(isset($Page->GetMetaData('social_media_icons', 'post')['meta_value']) && $Page->GetMetaData('social_media_icons', 'post')['meta_value'])                
											<div class="header-contact" style="margin-right: -217px;">
													<p class="smll-text">follow and like us on</p>
													@foreach(explode(',', $Page->GetMetaData('social_media_icons', 'post')['meta_value']) as $icon)
													<a href="{{\App\Post::findOrFail($icon)->button_link}}"><img src="{!! asset('img/post/') !!}/{!! \App\Post::findOrFail($icon)->featured_image; !!}"></a>   
													@endforeach
											</div>
                    @endif
										</div>
									</td>
									</tr>
									@php $ctr = 1; @endphp
									@else 
									@php $ctr++;  @endphp
									@endif
									@if(isset($item['product_details'][0]))
									<tr class="cart-color-details-tr">
											<td colspan="6">
												<div class="row col-sm-12 row-item mb-3 cart-color-details" >
														<div class="cart-color-name" >{{ $item['color_name'] }} </div>
												</div>
											</td>
									</tr>
									<tr class="product_details" id="row-content-{{$x}}" data-id="{{ $item['product_attribute'] }}">
											<td>
													<div class="cart-color-details">
														<div class="cart-item" style="border:1px solid black; background-color: {{$item['css_color']}};">
																<br>
																<div class="cart-img hidden-xs" style="height:100px; font-weight: bold;text-align: center;"></div>
														</div>
														<div class="remove-cart-div" > 
																<button class="btn remove-cart" data-index="{{$x}}"><i class="remove-cart-icon fa fa-times-circle-o fa-lg"></i> Remove</button>
														</div>
													</div>
											</td>
											<td>
													<div id="prod-row-{{$x}}">
														<!-- start -->
														<div class="productpaint">
																@foreach($item['product_details'] as $prod_key => $prod_data)
																<a class="color-box box select-option " data-id="{!! $prod_data['id'] !!}" data-name="{!! $prod_data['name']!!}" data-price="{{$prod_data['price']}}" data-qty="{{$prod_data['qty']}}" data-index="{{$x}}">
																	<!-- <input type="checkbox"  name="" id=""> -->
																	<div class="cart-item">
																			<div class="top">
																				<div class="cart-item-img" style=""> 
																						@if($prod_data['image'])
																						<img src="img/products/{!!$prod_data['image']!!}" alt="" onerror="this.src='img/no_image.png'">
																						@endif
																				</div>
																			</div>
																			<input type="hidden" name="pricerow-{{$x}}" id="price-{{$x}}">
																	</div>
																</a>
																@php 
	 															$selected_liter = !empty($prod_data['liter']) ? $prod_data['liter'] : 'N/A';
																$selected_qty   = $prod_data['qty'];
																@endphp
																@endforeach
														</div>
													</div>
											</td>
											<td>
													<div class="cart-product-name">
														<a href="{{URL::to('/').'/product/'.$prod_data['slug_name']}}">
																<p >{!! $prod_data['name'] !!}</p>
														</a>
													</div>
											</td>
											<!-- end -->
											<td>
	 													<span>{{ $selected_liter }}</span>
											</td>
											<td>
													<input class="form-control cart-qty" type="number" min="1" step="1" value="{{$selected_qty}}" data-index="{{$key}}" data-color="{{$item['color_name']}}" data-liter="{{$selected_liter}}" data-price="{{$price}}">
											</td>
											<td>
													<input type="hidden" name="price-color" id="price-color-{{$x}}" class="price-color">
													<div class="list-price-{{$x}} pricelist">P{{number_format($subtotal,2)}}</div>
											</td>
									</tr>
									@endif
									@php $x++; @endphp
									@endforeach		
								</tbody>
						</table>
						<div class="pl-3 mb-3 cart-add-paint" > Add another paint </div>
						@else 
						<div class="page-header">
								<h5>Shopping Cart</h5>
								<hr width="100%" size="20" color="gray" noshade>
						</div>
						<p > Cart is Empty</p>
						@endif	
					</div>
					<hr width="100%"
						size="20" color="gray"
						noshade>
					@if($cart)
					<div class="cart-subtotal-row row col-sm-12">
						<div class="cart-subtotal-label">Subtotal <span class="subtotal">P {{number_format($total_subtotal,2)}}</span></div>
					</div>
					<div class="row col-sm-12">
						<div class="col-sm-0 col-lg-2"> </div>
						<div class="col-sm-11 col-lg-10 cart-privacy-policy-row"> <input type="checkbox" />&nbsp; Yes, I would like to receive emails from UNIVERSAL PAINT with the latest promotions and color trends. <span class="cart-privacy-policy">privacy policy</span></div>
					</div>
					<div class="row col-sm-12 mt-3">
						<div class="col-sm-0 col-lg-8"> </div>
						<div class="col-sm-11 col-lg-4 cart-review-order-label">Review your order, then checkout at UNIVERSALPAINT.net</div>
					</div>
					<div class="cart-buttons mb-5 mt-5">
						<!-- <div><button> FIND PAINTS IN STORE</button></div> -->
						<div>
								<button id="print_cart">
									<div class="cart-print-button">
											<div>PRINT</div>
											<div>
												<small>SHOPPING LIST</small> 
											</div>
									</div>
								</button>
						</div>
						<div>
								<button id="cart-checkout-btn">
									<div class="cart-checkout-btn">
											<div>CHECK OUT NOW</div>
											<small>AT UNIVERSAL PAINT</small>
								</button>
								</div>
						</div>
						@endif
					</div>
			</div>
		</div>
	</div>
</div>	
@endsection
@section('scripts')
<script type="text/javascript">
   $('.cart-add-paint').click(function() {
   	window.location = "{{URL::to('/color-swatches')}}";
   });
   
   //checkout
   $('.size-volume').on('keyup change', function() {
   	var index =  $(this).data('index');
   	var total = $('#price-color-'+index).val();
   	var valueadd = 0;
   	var subtotal = 0;
   	console.log('clear', total);
   	if(total){
   		valueadd += parseInt($('#price-color-'+index).val()) + parseInt($(this).val());
   	}
   	$('.list-price-'+index).html(valueadd);
   	$('.pricelist').each(function (){
   		if($(this).html() != NaN){	
   			subtotal += parseInt($(this).html());
   		}
   		$('.subtotal').html('<span>&#8369;</span> '+subtotal);
   	});
   	subtotal = 0;
   });
   
   function calculatePrice() {
   
   }
   
   $(document).ready(function(){
   	$('.checkout-order').on('click', function() {
   		var allproducts = [];
   		$('.row-item').each(function (){
   			if($('.row-item').length > 0){
   				allproducts.push( {colorvar : $(this).data('id'), 
   					productid: $(this).find('.active').data('id'), 
   					productname: $(this).find('.active').data('name'),
   					productsize: $(this).find('select option:selected').text(),
   					volumeprice: $(this).find('select').val()
   				} );
   			}
   		});
   		console.log(allproducts);
   		$.ajax({
   		url: base_url + '/checkout',
   		method: "post",
   		dataType: "json",
   		data: {
   			product: allproducts,
   			_token: "{{ csrf_token() }}"
   		},
   		success: function (data) {
   			console.log('ok');
   		},
   		error: function(){
   			console.log('error');
   		}
   	});
   	})
   
   	$('#cart-checkout-btn').click(function() {
   		window.location = '/checkout';
   	});

		 $('#print_cart').click(function() {
				CreatePDFfromHTML();
		 });

		//Create PDf from HTML...
		function CreatePDFfromHTML() {
			// $('#cart').css('margin-top', '0px');
			$('#theme-header ').css('position','absolute');
			$('.remove-cart').hide();
			$('#print_cart').hide();
			$('#cart-checkout-btn').hide();
			$('#sixth-section').hide();
			$('.navbar-nav').hide();
			$('.cart-review-order-label').hide();
			$('.cart-privacy-policy-row').hide();
			$('.cart-add-paint').hide();
			$('.header_print').show();
			var HTML_Width = $("#app-layout").width();
			var HTML_Height = $("#app-layout").height();
			var top_left_margin = 1;
			var PDF_Width = HTML_Width + (top_left_margin * 2);
			var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
			var canvas_image_width = HTML_Width;
			var canvas_image_height = HTML_Height;

			var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

			html2canvas($("#app-layout")[0]).then(function (canvas) {
					var imgData = canvas.toDataURL("image/jpeg", 1.0);
					console.log(imgData);
					var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
					pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
					for (var i = 1; i <= totalPDFPages; i++) { 
							pdf.addPage(PDF_Width, PDF_Height);
							pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
					}
					pdf.save("UniversalPaintShoppingList.pdf");
					$('#theme-header ').css('position','fixed');
					$('.remove-cart').show();
					$('#print_cart').show();
					$('#cart-checkout-btn').show();
					$('#sixth-section').show();
					$('.navbar-nav').show();
					$('.cart-privacy-policy-row').show();
					$('.cart-review-order-label').show();
					$('.cart-add-paint').show();
					$('.header_print').hide();
			});
		}
   })
</script>
@endsection