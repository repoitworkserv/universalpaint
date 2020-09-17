@extends('layouts.user.app')
@section('css')
<style>
    #footer {
        display: none !important;
	}    
	#loading-container {
       background: #F7F7F7;
    }
    .hrcolor{
    	    border-top: 1px solid #daa521;
    }
</style>
@endsection
@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"><h4 class="modal-title">Order Details</h4></div>
				<div class="panel-body">
					@if($order)
					@foreach($order as $o)
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									
									<label class="col-md-4 col-sm-4 col-xs-5" >Order Code</label>
									<span class="ordercode_div col-md-8 col-sm-8 col-xs-7" >
										{{($o->order_code ? $o->order_code : '')}}
									</span>
								</div>
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-5" >Status</label>
									<span class="status_div col-md-8 col-sm-8 col-xs-7">
										{{($o->status ? $o->status : '')}}
									</span>
								</div>
									<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-5" >Payment Type</label>
									<span class="status_div col-md-8 col-sm-8 col-xs-7">
										{{($o->payment_type ? $o->payment_type : '')}}
									</span>
								</div>
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-5" >Amount</label>
									<div class="col-md-8 col-sm-8 col-xs-7">
										&#8369; <span class="amount_div ">{{($o->amount ? number_format($o->amount,2) : number_format('0',2))}}</span>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-5" >Shipping Amount</label>
									<div class="col-md-8 col-sm-8 col-xs-7">
										&#8369; <span class="shippamount_div ">{{($o->amount_shipping ? number_format($o->amount_shipping,2) : number_format('0',2))}}</span>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-5" >Total Amount</label>
									<div class="col-md-8 col-sm-8 col-xs-7">
										&#8369; <span class="totamount_div ">{{($o->amount_total ? number_format($o->amount_total,2) : number_format('0',2))}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row billshipp_details">
						<div class="col-md-12 col-sm-12 col-xs-12">
							@php
								$co_details = $o->OrderCheckoutDetailsData;
								$co_item = $o->OrderItemData;
							@endphp
							@for($x=0;$x<count($co_details);$x++)
							
							<label>{{($co_details[$x]['reference'] == 'billing' ? 'Billing Address' : 'Shipping Address')}}</label>
							@php
								$co_details_lothouse = $co_details[$x]['lot_house_no'];
								$city_id = $co_details[$x]['city'];
								$co_details_loc = \App\ShippingGngRates::findOrFail($city_id)->location;  
							@endphp
							<div class="">{{$co_details_lothouse.', '.$co_details_loc}}</div>
							@endfor
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4>Item Details</h4>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
								<table class="table table-condensed table-responsive">
								<thead>
									<tr>
										<th>Item Name</th>
										@if($order[0]['status'] == 'complete')
										<th>Review</th>
										@endif
										<th>Description</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Total Amount</th>
									</tr>
								</thead>
								<tbody id="item_tbl">
									@for($x=0;$x<count($co_item);$x++)
									<tr>
									@php $symbol = '' @endphp
										<td>{{$co_item[$x]['product_name']}}</td>
										@if($order[0]['status'] == 'complete')
										<td><a href="{!! URL::to('product/'.\App\Product::where(['name' => $co_item[$x]['product_name']])->value('slug_name')) !!}">Add Review</a></td>
										@endif
										<td>{!!$co_item[$x]['product_details']!!}</td>
										<td>{!!$co_item[$x]['quantity']!!}</td>
										<td>{!!number_format($co_item[$x]['price'],2)!!}</td>
										<td>{{ number_format($co_item[$x]['price'] *  $co_item[$x]['quantity'],2) }}</td>
									</tr>
									@endfor
								</tbody>
							</table>
						</div>
					</div>
						@endforeach
					@endif
					<div class="row text-right">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="button-group">
								<a href="{{URL::to('/customer/profile')}}" class="btn btn-warning" >Back to Profile</a>
							</div>
						</div>
					</div>
				</div>
	        </div>
		</div>
		<div class="container-all all-banner-slide col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- <div class="top-title">
                <div class="content-ttl single-prod">Similar Items</div>
                <button class="button button--aylen" tabindex="-1">See more >></button>
                <div class="content-tag-ttl">SEE MORE >></div>
            </div> -->
            <div class="top-title-new">
                <div class="content-ttl-new single-prod">Suggested Items</div>
                <div class="content-ttl-line-new"></div>
                <!--div class="content-tag-ttl-new"><a href="/products" tabindex="-1"><button class="button hp-ttl-btn" tabindex="-1">SEE MORE >></button></a></div-->
            </div>
            <div class="row list list-product-slick col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{-- random category and product in category --}}
                @foreach($product[0]->ProductCategoryData[rand(0,(count($product[0]->ProductCategoryData) - 1))]['SameCategoryProduct'] as $list)
                    @if($list->ProductDetails['parent_id'] == 0 && !empty($list->ProductDetails))
                        <div class="list-content">
                            <a href="/product/{{ $list->ProductDetails['slug_name'] }}">
                                <div class="list-banner"> <!-- item -->
                                    <div class="top">
                                        <div class="list img" style="background: url(
                                                @if($list->ProductDetails['featured_image'] != '')
                                                    {!! asset('img/products/') !!}/{!! $list->ProductDetails['featured_image']; !!}
                                                @else
                                                    {!! asset('img/products/') !!}/placeholder.png
                                                @endif
                                            );"></div>
                                    </div>
                                    <div class="bottom">
                                        <div class="list-name-container">
                                            <div class="list-name">{{$list->ProductDetails['name']}}</div>
                                        </div>
                                        <div class="list-cat">PERFUME</div>
                                        <div class="list-price">P {{number_format(\App\Product::where('slug_name', $list->ProductDetails['slug_name'])->max('price'), 2)}}</div>
                                        <div class="list-rate-btn">
                                            <div class="stars">
                                                @for ($i=0; $i < round($list->ProductDetails['rating']); $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- close item -->
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
	</div>
</div>
@endsection

@section('scripts')
@stop