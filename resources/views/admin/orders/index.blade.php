@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Orders
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif
    

  </section>
  <section class="content">

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
				<br />
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-cart-arrow-down"></i> Order List </h3>
                </div>
                <div class="box-body">
                	<div class="ordernotif">
    	
    				</div>
                    <div class="table-responsive">
						<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
							<form  action="{{ URL::action('Admin\OrderController@search') }}" method="get"  accept-charset="UTF-8" enctype="multipart/form-data">
								{!! csrf_field() !!}
								<div class="input-group">
									<input type="text" class="form-control input-gold" name="search_item" value="{{isset($_GET['search_item']) ? $_GET['search_item'] : ''}}">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search </button>
									</span>
									</div>
							</form>
						</div>
						
                        <table class="table no-margin">
                            <thead>
                                <tr>
									<th>Order ID</th>
									<th>Reference #</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
							</thead>
                            <tbody>
							@if($order)
							@foreach($order as $o)
                            	<!-- @php
	                            	$name = '';
	                            	$ocd_data = $o->OrderCheckoutDetailsData;
	                            @endphp
                            	@foreach($ocd_data as $ocd)
	                            	@php
		                            	$name = $ocd->lname.', '.$ocd->fname." ".$ocd->mname;
		                            	break;
		                            @endphp
                            	@endforeach -->
	                            
                            	<tr>
									<td><a class="view_order_btn cpointer" data-orderid="{{$o->id}}">{{$o->order_code}}</a></td>
									<td>{{$o->ref_no}}</td>
                                    <td>{{$name}}</td>
                                    <td>{{date('F j, Y H:i:s',strtotime($o->created_at))}}</td>
                                    <td>{{ucfirst($o->payment_type)}}</td>
                                    <td><span class="label label-success">{{strtoupper($o->status)}}</span></td>
                                    <td>
                                        &#8369; {{strtoupper(number_format($o->amount_total,2))}}
                                    </td>
                                    <td>
                                        <!--div class="btn btn-primary btn-xs view_order_btn" data-orderid="{{$o->id}}">Update Status</div-->
                                        
                                        <span>
                                        	@php
                                        		$p  = '';
                                        		$op = '';
                                        		$fp = '';
                                        		$c  = '';
                                        		$is_cancel = ($o->status == 'cancelled') ? 1 : 0;
                                        		if($o->status == 'pending'){
                                        			$p  = '';
	                                        		$op = '';
	                                        		$fp = 'disabled';
	                                        		$c  = 'disabled';
                                        		}else if($o->status == 'on_process'){
                                        			$p  = '';
	                                        		$op = '';
	                                        		$fp = '';
	                                        		$c  = 'disabled';
                                        		}else if($o->status == 'complete'){
                                        			$p  = 'disabled';
	                                        		$op = 'disabled';
	                                        		$fp = 'disabled';
	                                        		$c  = '';
                                        		}
                                        		
                                        	@endphp
                                        	
	                                        	@if($is_cancel == 0)
	                                        	<select class="order-stat" data-orderid_stat = "{{$o->id}}">
	                                        		<option value="pending" {{$p}} {{(($o->status == 'pending') ? 'selected' : '' )}}>Pending</option>
	                                        		<option value="on_process" {{$op}} {{(($o->status == 'on_process') ? 'selected' : '' )}}>On Process</option>
	                                        		<option value="for_shipping"{{$fp}} {{(($o->status == 'for_shipping') ? 'selected' : '' )}}>For Shipping</option>
	                                        		<option value="complete" {{$c}} {{(($o->status == 'complete') ? 'selected' : '' )}}>Complete</option>
	                                        	</select>
	                                        	@endif
                                        	
                                        </span>
                                    </td>
                            	</tr>
                            	<tr><td colspan="6"></td></tr>
							@endforeach
							@endif
                                <!--tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>Ash Kenton</td>
                                    <td>June 07, 2018</td>
                                    <td><span class="label label-success">Shipped</span></td>
                                    <td>
                                        &#8369; 3,000
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Labor James</td>
                                    <td>June 07, 2018</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                        &#8369; 7,900
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>Natasha Samson</td>
                                    <td>June 06, 2018</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td>
                                        &#8369; 54,000
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>Kobe Bayan</td>
                                    <td>June 06, 2018</td>
                                    <td><span class="label label-info">Processing</span></td>
                                    <td>
                                        &#8369; 7,900
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Charmain Dela Cruz</td>
                                    <td>June 05, 2018</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                        &#8369; 7,900
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>John Smith</td>
                                    <td>June 04, 2018</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td>
                                        &#8369; 54,000
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>Andre Malby</td>
                                    <td>June 04, 2018</td>
                                    <td><span class="label label-success">Shipped</span></td>
                                    <td>
                                        &#8369; 3,000
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr-->
							</tbody>
						</table>
                    </div>
                </div>
            </div>
		</div>
    	<div>{{ $order->firstItem() }} - {{ $order->lastItem() }} of {{ $order->total() }} </div>
		<div class="pagination"> {{ $order->appends(request()->query())->links() }} </div>
    </div>
  </section>
  
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
	                				
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Reference #</label>
			                        <span class="refno_div col-md-8 col-sm-8 col-xs-12" >
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
																			<th>Color</th>
																			<th>Liter</th>
	                                    <th>Price</th>
<!-- 	                                    <th>Discount</th> -->
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
@stop

@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>

<script>
 	var Token = $('input[name="_token"]').val();
	$('.view_order_btn').on('click',function(){
		var orderid = $(this).data('orderid');
		if(orderid && Token){
			$.ajax({
                url: base_url+'/admin/orders/view-details',
                method: "post",
                dataType: "json",
                data:
                {
                    _token : Token,
                    orderid : orderid,
                },
                success: function (data) {
                	if(data.length > 0){
                		for(d=0;d<data.length;d++){	
							$('.ordercode_div').html(data[d].order_code);
							$('.refno_div').html(data[d].ref_no);
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
                			item_details = data[0].order_item_data;
                			if(item_details.length > 0){
                				tr_details = '';
                				for(cd=0;cd<item_details.length;cd++){
									var discount_type = ''
									if(item_details[cd].discount_type === 'fix'){
										discount_type =  '₱ '+item_details[cd].discount.toFixed(2)+'OFF';
									} else if(item_details[cd].discount_type === 'percentage') {
										discount_type = item_details[cd].discount+'%';
									} else {
										discount_type = item_details[cd].discount.toFixed(2);
									}
                					tr_details += '<tr>'+
				                                    '<td>'+item_details[cd].product_name+'</td>'+
				                                    '<td>'+item_details[cd].product_details+'</td>'+
				                                    '<td>'+item_details[cd].quantity+'</td>'+
																						'<td>'+item_details[cd].color+'</td>'+
																						'<td>'+item_details[cd].liter+'</td>'+
				                                    '<td>₱ '+item_details[cd].price.toFixed(2)+'</td>'+
				                                    // '<td>'+discount_type+'</td>'+
				                                    '<td>₱ '+(item_details[cd].price.toFixed(2) * item_details[cd].quantity).toFixed(2)+'</td>'+
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
		if(confirm('Are you sure you want to proceed')){
			orderid = $(this).data('orderid_stat');
			optsel = $(this).val();
			if(orderid && optsel){
				$.ajax({
					url: base_url+'/admin/orders/order-update-status',
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
						},3000);
					}
				});
			}
		} else {
			setTimeout(function(){location.reload();},1000);
		}
	});
</script>

@stop
