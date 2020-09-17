@extends('layouts.user.app')
@section('css')
<style>
    #footer {
        display: none !important;
	}
</style>
@endsection
@section('content')
<div id="orders" class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" >
            @if(Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">My Orders</h4>
                    <div class="box-body no-padding">
                    <table class="table orders-table">
                        <thead class="orders-table-head">
							<tr>
								<th>Order Date</th>
								<th>Order Code</th>
								<th>Payment Type</th>
								<th>Status</th>
								<th>Total Price</th>
                        	</tr>
                        </thead>
                        <tbody class="orders-table-body">
                            @if($order->count() > 0)
                                @foreach($order as $o)
                                    @php
                                        $name = '';
                                        $ocd_data = $o->OrderCheckoutDetailsData;
                                    @endphp
                                    @foreach($ocd_data as $ocd)
                                        @php
                                            $name = $ocd->lname.', '.$ocd->fname." ".$ocd->mname;
                                            break;
                                        @endphp
                                    @endforeach
                                    
                                    <tr>
                                    <td>{{date('F j, Y H:i:s',strtotime($o->created_at))}}</td>
                                    <td>
                                        <a href="{{URL::to('/customer/order-details/'.$o->id)}}" class="view_order_btn cpointer">{{$o->order_code}}</a>
                                    </td>
                                    <td>
                                        {{ucfirst($o->payment_type)}}
                                    </td>
                                    <td>
                                        <span class="label label-{{$o->status == 'pending' ? 'warning' : ($o->status == 'cancelled' ? 'danger' : 'success')}}">{{strtoupper($o->status)}}</span>
                                    </td>
                                    <td>&#8369; {{strtoupper(number_format($o->amount_total,2))}}</td>
                                    <td>
                                        @if($o->status == 'pending' || $o->status == 'on_process')
										<select class="order-stat" data-orderid_stat = "{{$o->id}}">
											<option value="0"> Cancel Order Here</option>
											<option value="cancelled" >Cancel Order</option>
										</select>
                                        @endif
                                    </td>
                                    </tr>
                                    
                                @endforeach
                            @else
                                <tr>
                                <td colspan="6"><h3 class="text-center">No Order Found.</h3></td>
                                </tr>
                            @endif        
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="pagination"> {{ $order->links() }} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="orderDtl" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="panel panel-primary">
            <form action="{{ URL::action('Admin\CategoryController@update') }}" method="post"accept-charset="UTF-8">
                <div class="panel-heading"><h4 class="modal-title">Order Details</h4></div>
                <div class="panel-body">
                	<div class="row">
                		<div class="col-md-12 col-sm-12 col-xs-12">
	                		<div class="col-md-6 col-sm-12 col-xs-12">
	                			<div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Order Code</label>
			                        <span class="ordercode_div col-md-8 col-sm-8 col-xs-12" >
			                        	asdasd
			                        </span>
			                    </div>
			                    <div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Status</label>
			                        <span class="status_div col-md-8 col-sm-8 col-xs-12">
			                        	asdasd
			                        </span>
			                    </div>
			                    <div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Amount</label>
			                        <div class="col-md-8 col-sm-8 col-xs-12">
			                        	&#8369; <span class="amount_div ">asdasd</span>
			                        </div>
			                    </div>
	                		</div>
	                		<div class="col-md-6 col-sm-12 col-xs-12">
	                			<div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Discount</label>
			                       <div class="col-md-8 col-sm-8 col-xs-12">
			                        	&#8369; <span class="discount_div ">asdasd</span>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Shipping Amount</label>
			                        <div class="col-md-8 col-sm-8 col-xs-12">
			                        	&#8369; <span class="shippamount_div ">asdasd</span>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Total Amount</label>
			                        <div class="col-md-8 col-sm-8 col-xs-12">
			                        	&#8369; <span class="totamount_div ">asdasd</span>
			                        </div>
			                    </div>
	                		</div>
                		</div>
                	</div>
                	<div class="row billshipp_details">
                		
                	</div>
                	<div class="row">
                		<div class="col-md-12 col-sm-12 col-xs-12">
                			<h4>Item Details</h4>
                		</div>
                		<div class="col-md-12 col-sm-12 col-xs-12">
                			 <table class="table table-striped table-accordion">
                                <thead>
                                    <tr>
	                                    <th>Item Name</th>
	                                    <th>Description</th>
	                                    <th>Quantity</th>
	                                    <th>Price</th>
	                                    <th>Discount</th>
	                                    <th>Amount</th>
	                                </tr>
                                </thead>
                                <tbody id="item_tbl">
                                	
                                </tbody>
                            </table>
                		</div>
                	</div>
                </div>
                <div class="panel-footer" style="text-align: right">
                    <div class="button-group">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	$(window).load(function(){
        setTimeout(function(){$('.alert').fadeOut() }, 3000);
    });
 	var Token = $('input[name="_token"]').val();
	$('.view_order_btn').on('click',function(){
		var orderid = $(this).data('orderid');
		if(orderid && Token){
			$.ajax({
                url: base_url+'/customer/order-view-details',
                method: "post",
                dataType: "json",
                data: {
                    _token : Token,
                    orderid : orderid,
                },
                success: function (data) {
                	if(data.length > 0){
                		for(d=0;d<data.length;d++){	
                			$('.ordercode_div').html(data[d].order_code);
                			$('.status_div').html(data[d].status);
                			$('.amount_div').html(data[d].amount.toFixed(2));
                			$('.discount_div').html(data[d].amount_discount.toFixed(2));
                			$('.shippamount_div').html(data[d].amount_shipping.toFixed(2));
                			$('.totamount_div').html(data[d].amount_total.toFixed(2));
                			//checkout details
                			
                			checkout_details = data[d].order_checkout_details_data;
                			if(checkout_details.length > 0){
                				checkoutdetails = '<div class="col-md-6 col-sm-12 col-xs-12">';
                				for(cd=0;cd<checkout_details.length;cd++){
                					title_section = (checkout_details[cd].reference == 'billing') ? 'Billing Details' : 'Shipping Details';
                					
                					address = checkout_details[cd].lot_house_no+', '+checkout_details[cd].city+', '+checkout_details[cd].province+', '+checkout_details[cd].region;
                					fullname = checkout_details[cd].lname+', '+checkout_details[cd].fname+' '+checkout_details[cd].mname;
                					checkoutdetails += '<h4>'+title_section+'</h4>';
                					checkoutdetails +='<div class="col-md-12 col-sm-12 col-xs-12"><div class="row">'+
									                        '<label class="col-md-4 col-sm-4 col-xs-12">Address</label>'+
									                         '<span class="col-md-8 col-sm-8 col-xs-12"> '+
									                        	address+
									                        '</span>'+	
									                    '</div>'+
									                    '<div class="row">'+
									                        '<label class="col-md-4 col-sm-4 col-xs-12">Name</label>'+
									                         '<span class="col-md-8 col-sm-8 col-xs-12"> '+
									                        	fullname+
									                        '</span>'+	
									                    '</div>'+
									                    '<div class="row">'+
									                        '<label class="col-md-4 col-sm-4 col-xs-12">Birth Date</label>'+
									                        ' <span class="col-md-8 col-sm-8 col-xs-12"> '+
									                        	checkout_details[cd].birth_date+
									                        '</span>'+	
									                    '</div>'+
									                    '<div class="row">'+
									                       ' <label class="col-md-4 col-sm-4 col-xs-12">Contact Number</label>'+
									                         '<span class="col-md-8 col-sm-8 col-xs-12"> '+
									                        	checkout_details[cd].contact_no+
									                        '</span>'+	
									                    '</div></div>';
                					
                					checkoutdetails +='</div>'+
                									  '<div class="col-md-6 col-sm-12 col-xs-12">';
                				}
                				checkoutdetails += '</div>';
                				$('.billshipp_details').html(checkoutdetails);
                			}
                			//item details
                			item_details = data[d].order_item_data;
                			if(item_details.length > 0){
                				tr_details = '';
                				for(cd=0;cd<item_details.length;cd++){
                					tr_details += '<tr>'+
				                                    '<td>'+item_details[cd].product_name+'</td>'+
				                                    '<td>'+item_details[cd].product_details+'</td>'+
				                                    '<td>'+item_details[cd].quantity+'</td>'+
				                                    '<td>₱ '+item_details[cd].price.toFixed(2)+'</td>'+
				                                    '<td>₱ '+item_details[cd].discount.toFixed(2)+'</td>'+
				                                    '<td>₱ '+item_details[cd].total_amount.toFixed(2)+'</td>'+
				                                '</tr><tr><td colspan="6"></td></tr>';
                				}
                				$('#item_tbl').html(tr_details);
                			}
                		}
                	}
                    $('#orderDtl').modal('show');
                }
            });
		}
	});
	
	$('.order-stat').on('change',function(){
		optsel = $(this).val();
		if(optsel == 'cancelled'){
		 	if(confirm("Do you want to Cancel your order?")){
				orderid = $(this).data('orderid_stat');
				optsel = $(this).val();
				if(orderid && optsel){
					$.ajax({
						url: base_url+'/customer/order-update-status',
						method: "post",
						dataType: "json",
						data:{
							_token : Token,
							orderid : orderid,
							optsel : optsel,
						},
						success: function (data) {
							notif_class = 'danger';
							notif_msg = data.msg;
							if(data.status == 'success'){
								notif_class = 'success';
							}

							$notifalert = '<div class="alert alert-'+notif_class+'">'+
											'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '+
												notif_msg+
										'</div>';
							$('.ordernotif').html($notifalert);
							setTimeout(function(){
								location.reload();
							},1000);
						}
					});
				}
			}
		}
	});
</script>
@endsection