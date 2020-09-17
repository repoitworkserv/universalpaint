@extends('layouts.user.app')
@section('styles')
<link href="{!! asset('static/dropzone/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
<style>
    #footer {
        display: none !important;
    }
</style>
@stop
@section('content')
<div id="manage-address" style="margin:2% auto;">
	<div class="container">
		<div class="row mb20">
			<div align="right" class="col-md-12 col-sm-12 col-xs-12">
				<a href="{{URL::to('/customer/profile')}}">
				<button class="button button--aylen" tabindex="0" style="margin: 0;">Back to Profile</button>
				</a>
			</div>
		</div>
		<div class="row">
			<h3 class="box-title">Manage Address 
				<span class=" pull-right add_address_btn" data-toggle="modal" data-target="#address_modal">
					<small>
						<i class="fa fa-plus-circle"></i> Add Address
					</small>
				</span>
			</h3>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped">
                	<thead>
                		<tr>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th>Address</th>
                            <th>Notes</th>
                            <th>Set As</th>
                            <th>Action</th>
                       </tr>	
                	</thead>
                    <tbody>
                    	@if($useraddress->count() > 0)
						@foreach($useraddress as $ua)
                    	<tr>
                            <td>{{$ua->last_name.', '.$ua->first_name}}</td>
                            <td>{{$ua->mobile_num}}</td>
                            <td>{{$ua->no_bldg_st_name.", ".$ua->brgy." ".$ua->city_municipality.", ".$ua->province}}</td>
                            <td>{{$ua->other_notes ? $ua->other_notes : "None"}}</td>
                            <td>{{($ua->is_billing == 1) ? (($ua->is_shipping == 1) ? 'Billing Address and Shipping Address' : 'Billing Address')  : (($ua->is_shipping == 1) ? 'Shipping Address' : '')}}</td>
                            <td>
							<a class="badge bg-orange edit-uaddr" data-area_region="{{$ua->area_region}}" data-tel_num="{{$ua->tel_num}}" data-birthdate="{{$ua->birthdate}}" data-uaddr_id = '{{$ua->id}}' data-uaddr_fname="{{$ua->first_name}}" data-uaddr_lname="{{$ua->last_name}}"  data-mobnum = '{{$ua->mobile_num}}' data-stname = '{{$ua->no_bldg_st_name}}'  data-brgy = '{{$ua->brgy}}'   data-city_municipality = '{{$ua->city_municipality}}' data-province = '{{$ua->province}}'   data-othernotes = '{{$ua->other_notes}}' data-billing = '{{$ua->is_billing}}' data-shipping = '{{$ua->is_shipping}}' >
                                    <span class="fa fa-edit"></span> Edit
                                </a>
                            </td>
                         </tr>
                          @endforeach
                          @endif
                    </tbody>
                </table>  
                <div class="pagination">  </div>  
            </div>
    	</div>
	</div>
</div>
  <div id="address_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
          <div class="panel panel-primary panel-brdr-orange">
          	<form id="editVariableForm" action="" method="post" accept-charset="UTF-8">
	            <div class="panel-heading panel-orange"><h4 class="modal-title">Address Form</h4></div>
	            <div class="panel-body">
					@if(!empty($useraddress))
					{!! csrf_field() !!}

					<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12">
										<!-- <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_name">Name</label>
												<input id="addr_name" name="addr_name" class="form-control addr_inp" type="text"  value="">
											</div>
										</div> -->
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_frst_name">First Name</label>
												<input id="addr_frst_name" style="text-transform: capitalize;" name="addr_frst_name" class="form-control addr_inp" type="text" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_lst_name">Last Name</label>
												<input id="addr_lst_name" style="text-transform: capitalize;" name="addr_lst_name" class="form-control addr_inp" type="text" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_bdate">Birth Date</label>
												<input id="addr_bdate" name="addr_bdate" class="form-control addr_inp bday" type="text" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_age">Age</label>
												<input id="addr_age" name="addr_age" class="form-control addr_inp" type="text" readonly="readonly" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_mobnum">Mobile Number</label>
												<input id="addr_mobnum" name="addr_mobnum" class="form-control addr_inp" type="text"  required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_telnum">Telephone Number</label>
												<input id="addr_telbnum" name="addr_telnum" class="form-control addr_inp" type="text"  value="">
											</div>
										</div>
                        
                        				<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">
													<label for="area_region">Shipping Area/Region</label>
													<select id="area_region" name="area_region" class="form-control addr_inp" type="text"  value="">
															<option disabled selected value> -- select an option -- </option>
														@foreach (App\ShippingGngRates::get() as $item)
			
															<option value="{{$item->id}}">{{$item->location}}</option>
														@endforeach
													<select>
												</div>
											</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_stname">House No/ Bldg/ Street Name</label>
												<input id="addr_stname" name="addr_stname" class="form-control addr_inp" type="text" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_brgy">Barangay</label>
												<input id="addr_brgy" style="text-transform: capitalize;" name="addr_brgy" class="form-control addr_inp" type="text" required  value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_city">City/Municipality</label>
												<input id="addr_city" style="text-transform: capitalize;" name="addr_city" class="form-control addr_inp" type="text" required value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_prov">Province</label>
												<input id="addr_prov" style="text-transform: capitalize;" name="addr_prov" class="form-control addr_inp" type="text" required  value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="addr_othrnotes">Other Notes</label>
												<textarea id="addr_othrnotes" name="addr_othrnotes" class="form-control addr_inp_txtarea" required rows="5" value=""></textarea>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<label> Set As :</label>
											<div class="form-group">
												<input type="checkbox" id="addr_billing" name="addr_billing" class="addr_chk" value="1"/>
												<label for="variable_name">Billing Address</label>
											</div>
											<div class="form-group">
												<input type="checkbox" id="addr_shipping" name="addr_shipping" class="addr_chk" value="1"/>
												<label for="variable_name">Shipping  Address</label>
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
										</div>
					    </div>
					</div>
					@endif
	            </div>
	            <div class="panel-footer">
	              <div class="row">
	                
	                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                	<input type="hidden" name="uaddress_id" id="uaddress_id" class="addr_inp" value="" />
	                  <div  class="btn btn-gold addr_sbmt_btn">Add</div>
	                  <div type="button" class="btn btn-default modcancel" data-dismiss="modal">Cancel</div>
	                </div>
	              </div>
	            </div>
            </form>
        </div>       
    </div>
  </div>

@stop

@section('scripts')
<script  type="text/javascript">
	$('.add_address_btn').on('click',function(){
		$('.addr_inp').val('');
		$('.addr_chk').prop('checked', false);
		$('.addr_inp_txtarea').val('');
		$('.addr_sbmt_btn').html('Add');
	});
	$('.edit-uaddr').on('click',function(){
		console.log($(this).data());
		$('#addr_frst_name').val($(this).data('uaddr_fname'));
		$('#addr_lst_name').val($(this).data('uaddr_lname'));
		$('#addr_mobnum').val($(this).data('mobnum'));
		$('#addr_bdate').val($(this).data('birthdate'));
		$('#addr_stname').val($(this).data('stname'));
    	$('#area_region').val($(this).data('area_region'));
		$('#addr_brgy').val($(this).data('brgy'));
		$('#addr_city').val($(this).data('city_municipality'));
		$('#addr_prov').val($(this).data('province'));
		$('#addr_othrnotes').val($(this).data('othernotes'));
		$('#addr_telbnum').val($(this).data('tel_num'));
		
		$('#uaddress_id').val($(this).data('uaddr_id'));
		prop_billing = ($(this).data('billing') == '1' ? true : false);
		prop_shipping = ($(this).data('shipping') == '1' ? true : false);
		$('#addr_billing').prop('checked',prop_billing);
		$('#addr_shipping').prop('checked',prop_shipping);
		
		$('.addr_sbmt_btn').html('Update');
		$('#address_modal').modal('show');
	});

	$('.addr_sbmt_btn').on('click',function(e){ 
		if(confirm("Are you sure you want to continue?")){
			$data_address = $('#editVariableForm').serializeArray();
			e.preventDefault();
			$('#addr_frst_name').val(),
			$('#addr_lst_name').val(),
			$('#addr_stname').val(),
			$('#addr_brgy').val(),
			$('#addr_city').val(),
			$('#addr_prov').val();
        	$('#area_region').val();

			$.ajax({
				url: base_url+'/customer/update_address',
				method: "post",
				dataType: "json",
				data:$data_address,
				success: function (data) {
				
				$('.address_msg').html(data.msg_text);
				setTimeout(function(){
					$('.address_msg').fadeOut('slow');
					$('#address_modal').modal('hide');
					location.reload();
				},500);
				}
			});
		}
	});
</script>
@stop
