@extends('layouts.user.app')
<meta charset="utf-8" />
@section('css')
<style>
	#footer {
		display: none !important;
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
			</div>
			<div class="row">
				<div class="col-lg-12 table-responsive-sm">
					<table class="table table-striped cart-table table-condensed">
						<thead class="cart-header">
							<tr>
								<th colspan="2" class="col-md-8">Color</th>
								<th class="col-md-1">Product</th>
								<th class="col-md-1">Quantity</th>
								<!-- <th class="col-md-1">Price</th> -->
								<th class="col-md-1"></th>
							</tr>
						</thead>
						<tbody>
							@if($arr_color)
							@php $x=0; @endphp
							@foreach($arr_color as $item)
							<tr class="cart-product">
								<td data-th="Product" >
									<div class="row">
										<div class=" cart-img col-sm-6 hidden-xs" style="height:100px; background-color: rgb({{$item['r']}}, {{$item['g']}}, {{$item['b']}});"></div>
									</div>
								</td>
								<td >
									<!-- <div class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></div> -->
									<div class="container">
										<div class="row">
										@foreach($item['products'] as $index)
											<div class="col-sm" style="background: url({!! asset('img/products/') !!}/{!! $index['featureimage'] !!});">
											{{ $index['name'] }}
											</div>
										@endforeach
										</div>
									</div>
									<!-- <div class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></div> -->
									
								</td>
								
								<td> &nbsp; </td>								
								<td>
									<button class="btn btn-danger remove-cart float-right" data-index="{{$x}}"><i class="fa fa-trash-o"></i></button>
								</td>
							</tr>
							@php $x++; @endphp
							@endforeach
							@endif							
							</tr>
						</tbody>
						<tfoot>
							<input type="hidden" name="sub-total" class="sub-total" value="">
							<tr class="d-block d-sm-none">
								<td class="text-center">
									<strong>Total: <span class="total-amount"> &#8369;</span></strong>
								</td>
							</tr>
							<tr>
								<td>
									<a href="{{URL::to('/products')}}">
										<div class="btn btn-secondary"><i class="fa fa-angle-left"></i> Continue Shopping</div>
									</a>
								</td>
								<td colspan="2" class="hidden-xs">
									
								</td>
								<td colspan="3">
									<a href="{{URL::to('/products/checkout')}}">
										<div class="btn btn-primary btn-block">Checkout <i class="fa fa-angle-right"></i></div>
									</a>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>				
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
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