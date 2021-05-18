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
			<br><br><br><br><br><br>
				@php $x=0; @endphp
				@if($cart)
				@php $total_subtotal = 0.00 @endphp 
				@endif
				@if($cart)
				@foreach($cart as $item)

				@php
				$price = $item['product_details'][0]['is_sale'] !== 0 ?  $item['product_details'][0]['sale_price'] : $item['product_details'][0]['price'];
				$qty   = $item['product_details'][0]['qty'];
				$subtotal = $price * $qty;
				$total_subtotal += $subtotal;
				@endphp 
				<div class="row col-sm-12 row-item mb-3 cart-color-details" > 
					<div class="cart-color-name" >{{ $item['color_name'] }} </div>
				</div>
				<div class="row col-sm-12 row-item mb-6" id="row-content-{{$x}}" data-id="{{ $item['product_attribute'] }}">
					<div class="cart-color-details">
						<div class="cart-item" style="border:1px solid black; background-color: {{$item['css_color']}};"><br>
							<div class="cart-img hidden-xs" style="height:100px; font-weight: bold;text-align: center;"></div>
						</div>
						<div class > 
							<button class="btn remove-cart float-left" data-index="{{$x}}"><i class="remove-cart-icon fa fa-times-circle-o fa-lg"></i> Remove</button>
						
						</div>
					</div>
					<div class="col-sm-6 col-lg-8" id="prod-row-{{$x}}">
						<!-- start -->
						<div class="container">
							<div class="row col-sm-12 productpaint">
							@foreach($item['product_details'] as $prod_key => $prod_data)
								<a class="color-box box select-option " data-id="{!! $prod_data['id'] !!}" data-name="{!! $prod_data['name']!!}" data-price="{{$prod_data['price']}}" data-qty="{{$prod_data['qty']}}" data-index="{{$x}}">
								<!-- <input type="checkbox"  name="" id=""> -->
									<div class="cart-item">
										<div class="top">
											<div class="cart-item-img" style=""> 
												@if($prod_data['image'])
												<img src="img/products/{!!$prod_data['image']!!}" alt="" onerror="this.src='img/no_image.png'">
												@endif
											<div class="cart-product-name"><a href="{{URL::to('/').'/product/'.$prod_data['slug_name']}}"><p >{!! $prod_data['name'] !!}  X {{$prod_data['qty']}}</p></a></div>
										</div>
										</div>
										<input type="hidden" name="pricerow-{{$x}}" id="price-{{$x}}">
									</div>
								</a>
								@endforeach
							</div>
						</div>
					<!-- end -->
				</div>
					<!-- <div class="col-sm-2">
						<select name="size" id="size-volume-{{$x}}" class="form-control size-volume" data-index="{{$x}}" style="margin-top: 50%;">
							<option value="300">4 L</option>
							<option value="500">6 L</option>
						</select>
					</div> -->
					<input type="hidden" name="price-color" id="price-color-{{$x}}" class="price-color">
					<div class="col-sm-1 col-lg-1 ml-5"><div class="list-price-{{$x}} pricelist">P{{number_format($subtotal,2)}}</div><br></div>
				</div>
				@php $x++; @endphp
				<div class="row col-sm-12 row-item mb-3 cart-add-paint" > Add another paint </div>		
				@endforeach		
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
				<div class="col-sm-2" style=""><br>
				<div class="cart-img hidden-xs"></div>
				</div>
				<div class="col-sm-2 col-lg-7">

				</div>
				<div class="col-sm-8 col-lg-3 cart-subtotal-label">Subtotal <span class="subtotal ml-5">P {{number_format($total_subtotal,2)}}</span></div>
				<div class="col-sm-1"><br>
				<!-- <button onclick="window.location='{{ url("/checkout") }}'" class="btn checkout-order" >Checkout</button> -->
				<!-- <button href="{!! url('/checkout') !!}" class="btn checkout-order">Checkout</button> -->
				</div>
			</div>
			<div class="row col-sm-12"> 
				<div class="col-sm-0 col-lg-2"> </div>
				<div class="col-sm-11 col-lg-10 cart-privacy-policy-row"> <input type="checkbox" />&nbsp; Yes, I would like to receive emails from UNIVERSAL PAINT with the latest promotions and color trends. <span class="cart-privacy-policy">privacy policy</span></div>
			</div>
			<div class="row col-sm-12 mt-3"> 
				<div class="col-sm-0 col-lg-8"> </div>
				<div class="col-sm-11 col-lg-4 cart-review-order-label">Review your order, then checkout at UNIVERSALPAINT.net</div>
			</div>
			<div class="row col-sm-12 mb-5 mt-5">
			<div class="col-sm-3 col-lg-4"> </div>
			<div class="row col-sm-9 col-lg-8 cart-buttons">
				<div><button> FIND PAINTS IN STORE</button></div>
				<div><button> <div class="cart-print-button"><div>PRINT</div> <div><small>SHOPPING LIST</small> </div><div></button></div>
				<div><button id="cart-checkout-btn"> <div class="cart-checkout-btn"><div>CHECK OUT NOW</div><small>AT UNIVERSAL PAINT</small></button></div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">

$('.cart-add-paint').click(function() {
	window.location = "{{URL::to('/color-swatches')}}";
});

// $('.select-option').click(function() {
// 	var price = parseFloat($(this).data('price'));
// 	var qty = parseFloat($(this).data('qty'));
// 	var total_price = price * qty;
// 	var p_index = $(this).data('index');
// 	var subtotal = 0.00;
// 	$('.list-price-'+p_index).text("P"+total_price.toFixed(2));

// 	$('.pricelist').each(function() {
// 		subtotal += parseFloat($(this).text().replace('P',''));
// 	})
// 	$('.subtotal').text('P '+subtotal.toFixed(2));
// });
// $('.container .row  a').on('click', function(e) {
// 	var query = $(this).data('id'), values = [];
// 	var dataindex = $(this).data('index');
// 	var qt = '#prod-row-'+dataindex;
// 	$(function(){

	 
// 	});
// 	if(!$(this).hasClass('active')){
// 		console.log($(qt));
// 		$(qt+' a').removeClass('active').addClass('inactive');
// 		$(this).removeClass('inactive').addClass('active');
// 		$(qt).find('a').each(function (index, value){
// 			if($(value).hasClass('active') == false){
// 				$(value).addClass('inactive');
// 			}
// 		})
// 	} 
// });

//CART
$('.remove-cart').on('click', function () {
	var cart_id = $(this).data('index')
	console.log(cart_id)
		if(confirm("Are you sure you want to remove?")) {
		$.ajax({
			url: '/remove-cart',
			method: "post",
			dataType: "json",
			data: {
				cart_id: cart_id,
				_token: "{{ csrf_token() }}"
			},
			success: function (data) {
				console.log('ok');
				location.reload();
			},
			error: function(){
				console.log('error');
			}
		});
	}
})
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
})
</script>


@endsection