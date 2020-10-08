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
								<th class="col-md-1">Price</th>
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
								<td data-th="Price">
									<div class="latest-price">&#8369; {{$item['sale_price'] == 0 ? $item['price'] : $item['sale_price']}}</div>
									<div class="orig-price">{{$item['sale_price'] == 0 ? '' : '&#8369; ' . number_format($item['price'], 2)}}</div>
								</td>
								<td>
									<button class="btn btn-danger remove-cart float-right"><i class="fa fa-trash-o"></i></button>
								</td>
							</tr>
							@php $x++; @endphp
							@endforeach
							@endif
							{!! csrf_field() !!}
							<tr>
								<td> &nbsp; </td>
								<td> &nbsp; </td>
								<td>
									<h5>Subtotal</h5>
								</td>
								<td> &nbsp; </td>
								<td colspan="2" class="text-right">
									&#8369; {{number_format($sub_total, 2)}}
								</td>
							</tr>
							<tr>
								<td> &nbsp; </td>
								<td> &nbsp; </td>
								<td>
									<h5>Shipping</h5>
								</td>
								<td colspan="3" class="text-right">
									<div>
										<div id="shippingAccordion" data-children=".item">
											<div class="item">
												<div id="shipping-details">
													<div class="form-group">
														<select class="form-control" id="shipping-location">
															<option value="0" data-amount="0">Select Location</option>
															@foreach($shipping as $list)
															<option value="{{$list->id}}" {{ ($list->id == App\UserAddress::where('user_id', $uid)->first()['area_region']) ? 'selected' : ''}}>{{$list->location}}</option>
															@endforeach
														</select>
													</div>
													<div class="form-group">
														<input type="text" class="form-control" id="shipping-amount" placeholder="Amount" readonly value="{{$list->price}}">
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td> &nbsp; </td>
								<td> &nbsp; </td>
								<td>
									<strong><h5>Total</h5></strong>
								</td>
								<td> &nbsp; </td>
								<td colspan="2" class="text-right">
									<strong><span class="total-amount"> &#8369; {{$sub_total == 0 ? number_format($sub_total, 2): number_format($total, 2)}}</span></strong>
								</td>
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
				<!-- <div class="col-lg-6 cart-checkout">
					<div class="panel panel-default">
						<div id="price-body" class="panel-body">
							<h2>Cart Totals</h2>
							<input type="hidden" name="sub-total" class="sub-total" value="{{$sub_total}}">
							<table class="table table-striped cart-table">
								<tbody>
									{!! csrf_field() !!}
									<tr>
										<td>Sub Total</td>
										<td>&#8369; {{number_format($sub_total, 2)}}</td>
									</tr>
									<tr>
										<td>Shipping</td>
										<td>
											<div>
												<div id="shippingAccordion" data-children=".item">
													<div class="item">
														<div id="shipping-details">
															<div class="form-group">
																<select class="form-control" id="shipping-location">
																	<option value="0" data-amount="0">Select Location</option>
																	@foreach($shipping as $list)
																	<option value="{{$list->id}}" {{ ($list->id == App\UserAddress::where('user_id', $uid)->first()['area_region']) ? 'selected' : ''}}>{{$list->location}}</option>
																	@endforeach
																</select>
															</div>
															<div class="form-group">
																<input type="text" class="form-control" id="shipping-amount" placeholder="Amount" readonly value="{{$list->price}}">
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										@section('scripts')
										<script>
											$('.qty-plus').click(function() {
												setTimeout(function() {
													location.reload();
												}, 100);
											});

											$('.qty-minus').click(function() {
												setTimeout(function() {
													location.reload();
												}, 100);
											});

											//    
										</script>
										@endsection
										<td>Total</td>
										<td class="total-amount">&#8369; {{$sub_total == 0 ? number_format($sub_total, 2): number_format($total, 2)}}</td>
									</tr>
								</tbody>
							</table>
							<a type="button" class="btn btn-gold btn-block" href="/checkout">PROCEED TO CHECKOUT</a>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>
@endsection