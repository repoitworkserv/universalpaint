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
								<th colspan="2" class="col-md-8">Product</th>
								<th class="col-md-1">Quantity</th>
								<th class="col-md-1"></th>
								<!-- <th class="col-md-1">Price</th> -->
								<th class="col-md-1"></th>
							</tr>
						</thead>
						<tbody>
							@if($cart)
							@php $x=0; @endphp
							@foreach($cart as $item)

							<tr class="cart-product">
								<td data-th="Product" colspan="2">
									<div class="row">
										<div class=" cart-img col-sm-3 hidden-xs"><img src="{{ URL::asset('img/products') }}/{{$item['product_data']['featured_image']}}" alt="..." class="img-responsive"></div>
										<div class="col-sm-9">
											<h6 class="nomargin product-name">{{$item['name']}}</h6>
											<div>{!!$item['description']!!}</div>
											@if(!empty($item['product_attribute']))
											<div>
												{!! App\Attribute::where('id',$item['product_attribute'])->first()['name'] !!} &nbsp;
											</div>
											@else
											<div></div>
											@endif
										</div>
									</div>
								</td>
								<td data-th="Quantity" class="cart-qty-cntn">
									<!-- <div class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></div> -->
									<input class="form-control cart-qty" type="number" min="1" step="1" value="{{$item['qty']}}" data-index="{{$x}}">
									<!-- <div class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></div> -->
								</td>
								
								<td> &nbsp; </td>								
								<td>
									<button class="btn btn-danger remove-cart float-right"><i class="fa fa-trash-o"></i></button>
								</td>
							</tr>
							@php $x++; @endphp
							@endforeach
							@endif							
							</tr>
						</tbody>
						<tfoot>
							<input type="hidden" name="sub-total" class="sub-total" value="{{$sub_total}}">
							<tr class="d-block d-sm-none">
								<td class="text-center">
									<strong>Total: <span class="total-amount"> &#8369; {{$sub_total == 0 ? number_format($sub_total, 2): number_format($total, 2)}}</span></strong>
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