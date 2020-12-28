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
	<div class="container">
		<div id="cart">
			<br><br><br><br><br><br><br><br><br><br>
			<div class="page-header">
				<h5>Shopping Cart</h5>
				<hr width="100%"
        size="20" color="gray"
        noshade> 
			</div>
				@if($arr_color)
				@php $x=0; @endphp
				@foreach($arr_color as $item)
				<div class="row col-sm-12">
					<div class="col-sm-2" style="border:1px solid black; background-color: rgb({{$item['r']}}, {{$item['g']}}, {{$item['b']}});"><br>
					<div class=" cart-img hidden-xs" style="height:100px; font-weight: bold;text-align: center;">{{ $item['name'] }}</div>
					</div>
					<div class="col-sm-7" id="prod-row-{{$x}}">
							<!-- start -->
							<div class="container">
								<div class="row col-sm-12 productpaint">
								@foreach($item['products'] as $ind)
								<a class="color-box box select-option " data-id="{!! $ind['child'] !!}" data-index="{{$x}}">
								<!-- <input type="checkbox"  name="" id=""> -->
									<div class="col-sm-3" >
									<div class="top">
                                        <!-- <div class="list img" style="background: url({!! asset('img/products/') !!}/{!! $ind['featureimage'] !!});"></div> -->
										<div class=" img" style="width: 100px;background-image: url(http://localhost:8000/img/products/1600095996-Universal-Professional-Flat-Wall-Enamel.png)"></div>
                                    </div>
									<div class="productname">

									<p >{!! $ind['name'] !!}</p>


									</div>
									<input type="hidden" name="pricerow-{{$x}}" id="price-{{$x}}">
									</div>
								</a>
								&nbsp;
								@endforeach
								</div>
							</div>
							<!-- end -->
					</div>
					<div class="col-sm-2">
						<select name="size" id="size" class="form-control" style="margin-top: 50%;">
							<option value="" selected disabled>Volume</option>
							<option value="">4 L</option>
							<option value="">6 L</option>
						</select>
					</div>
					<div class="col-sm-1"><div class="list-price-{{$x}} pricelist"></div><br><br>
					<button class="btn btn-danger remove-cart float-right" data-index="{{$x}}"><i class="fa fa-trash-o"></i></button>
					</div>
				</div>
				@php $x++; @endphp
				@endforeach
				@endif					
		</div>
		<hr width="100%"
        size="20" color="gray"
        noshade> 
		<div class="row col-sm-12">
			<div class="col-sm-2" style=""><br>
			<div class=" cart-img hidden-xs" style="height:100px;"></div>
			</div>
			<div class="col-sm-7">

			</div>
			<div class="col-sm-1">Subtotal <span class="subtotal"></span></div>
			<div class="col-sm-2"><br><div class=""> </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">

//selection
// $('.productpaint').on('click', function(e){
// 	e.preventDefault()
// 	$(this).find('a').each(function (index, value){

// 	});

// });
$('.container .row  a').on('click', function(e) {
	var query = $(this).data('id'), values = [];
	var dataindex = $(this).data('index');
	var qt = '#prod-row-'+dataindex;
	$(function(){

	 
	});
	if(!$(this).hasClass('active')){
		console.log($(qt));
		$(qt+' a').removeClass('active').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');
		$(qt).find('a').each(function (index, value){
			if($(value).hasClass('active') == false){
				$(value).addClass('inactive');
			}
		})
	} 
	e.preventDefault()
	$.ajax({
		url:"{{ route('autocomplete.getfetch') }}",
		method:"post",
		data:{query:query, dataindex:dataindex,_token: "{{ csrf_token() }}"},
		success:function(data){
			$('.list-price-'+dataindex).html(data);
			var subtotal = 0;
			$('.pricelist').each(function (){
				if($(this).html() != NaN){	
					subtotal += parseInt($(this).html());
				}
				$('.subtotal').html('<span>&#8369;</span> '+subtotal);
			});
		}
	});

	

});

//CART
$('.remove-cart').on('click', function () {
	var cart_id = $(this).data('index')
	console.log(cart_id)
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
})
</script>


@endsection