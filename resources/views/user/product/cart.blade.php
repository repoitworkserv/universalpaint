@extends('layouts.user.app')
<meta charset="utf-8"/>
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
		    <div class="page-header">
		        <h5>Shopping Cart</h5>
		    </div>
		    <div class="row">
		        <div class="col-lg-12">
					<table class="table table-striped cart-table">
						<thead class="cart-header">
							<tr>
								<th colspan="3" class="col-md-9">Product</th>  
								<th class="col-md-1">Quantity</th>
								<th class="col-md-1">Price</th>
							</tr>
						</thead>
						<tbody>
							@if($cart)
								@php $x=0; @endphp
								@foreach($cart as $item)
									<tr class="cart-product">
										<td>
											<button class="btn btn-xs btn-danger remove-cart" data-index="{{$x}}"><span class="glyphicon glyphicon-remove"></span></button>
										</td>
										<td>
										<div class="cart-img" style="background: url('{{ URL::asset('img/products') }}/{{$item['product_data']['featured_image']}}');"></div>
										</td>
										<td>
											<div class="product-name">{{$item['name']}}</div>
											<div>{!!$item['description']!!}</div>
											@if(!empty($item['product_attribute']))
													<div>@foreach($item['product_attribute'] as $attr)
													{!! App\Attribute::where('id',$attr)->first()['name'] !!} &nbsp;
													@endforeach
													</div>
											@else
												<div></div>
											@endif
										</td>
										<td class="cart-qty-cntn">
											<div class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></div>
											<input class="form-control cart-qty" type="number" min="1" step="1" value="{{$item['qty']}}" data-index="{{$x}}">
											<div class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></div>
										</td>
										<td>
											<div class="latest-price">&#8369; {{$item['sale_price'] == 0 ? $item['price'] : $item['sale_price']}}</div>
											<div class="orig-price">{{$item['sale_price'] == 0 ? '' : '&#8369; ' . number_format($item['price'], 2)}}</div>
										</td>
									</tr>
									@php $x++; @endphp
								@endforeach
							@endif
						</tbody>
					</table>
		        </div>
		        <div class="col-lg-6 text-center">
		        	<a href="{{URL::to('/products')}}">
		        		<div class="btn btn-orange" style="margin: 20px 0;">CONTINUE SHOPPING</div>
		        	</a>
		        </div>
		        <div class="col-lg-6 cart-checkout">
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
											$('.qty-plus').click(function(){
												setTimeout(function(){
											 		location.reload();
											 	},100);
											});

											$('.qty-minus').click(function(){
												setTimeout(function(){
											 		location.reload();
											 	},100);
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
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection
