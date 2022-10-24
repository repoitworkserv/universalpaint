@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/dropzone/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Edit Profile
    </h1>
    
    <!-- @if (session('status'))
        <br>
        <div class="alert alert-danger">
        {!! nl2br(session('status')) !!}
        </div>
    @endif -->

  </section>

  <div class="col-md-8 content">
    <div class="box box-gold">
      <div class="box-header with-border">
        <h3 class="box-title">
           Information Details
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->


        <div class="box-body">
		<div class="col-md-12 col-sm-12 col-xs-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Profile and Account Settings</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Address List</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                 <form action="{{ URL::action('Admin\UserController@update_profile', [$userID->id]) }}" method="post" accept-charset="UTF-8">  
		 			{!! csrf_field() !!}
					<div class="col-md-4 col-sm-4 col-xs-12 " >
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="form-group">
								<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
								@if($uimage)
									@foreach($uimage as $uimg)
										<img src="{!! asset('img/customer/profile').'/'.$uimg->ImageData['file_name'] !!}" style="display:block; margin: 0 auto;width: 100%;" />
									@endforeach
								@else
								<img src="{!! asset('img/users/default.jpg') !!}" style="display:block; margin: 0 auto;width: 100%;" />
								@endif
								</div>
							</div>
							<h4 class="col-md-12 col-sm-12 col-xs-12 text-center">
								<span  data-toggle="modal" data-target="#upl_modal">
									<i class="fa fa-upload"></i>  Upload Photo
								</span>
							</h4>
						</div>
						
					</div>
					
				</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h4>Profile</h4>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						@if (session('status'))
					        <br>
					        <div class="alert alert-{{ session('class_html') }}">
					        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
					        </div>
					    @endif
					</div>
					@if(count($userprofile) > 0)
					@foreach($userprofile as $up)
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label for="name">Full Name</label>
							<input id="full_name" name="full_name" value="{{$up->name}}" class="form-control" placeholder="Full Name" type="text" required>
						</div>
					</div> -->
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="first_name">First Name</label>
							<input id="first_name" name="first_name" value="{{$up->first_name}}" class="form-control" placeholder="First Name" type="text" required>
						</div>
					</div>
					
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<label for="last_name">Last Name</label>
							<input id="last_name" name="last_name" value="{{$up->last_name}}" class="form-control" placeholder="Last Name" type="text" required>
						</div>
					</div>
					
					
					<div class="col-md-3">
						<div class="form-group">
							<label for="bdate_accnt">Birthday</label>
							<input  id="bdate_accnt" value="{{$up->birthdate}}" name="bdate" class="form-control bdate" placeholder="mm/dd/yyyy" >
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="age">Age</label>
							<input id="age" value="{{$up->age}}" name="age" class="form-control" placeholder="" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="gender">Gender</label>
							<select class="form-control" name="gender">
								@foreach($gender as $g =>$gval)
								<option {{($up->gender == $g) ? 'selected' : ''}} value="{{$g}}">{{$gval}}</option>
								@endforeach
							</select>
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="mobnum">Mobile Number</label>
							<input type="input" id="mobnum" value="{{$up->mobile_num}}" name="mobnum" class="form-control" placeholder="+639xx-xxx-xxxx">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tel_num">Telephone Number</label>
							<input type="input" id="tel_num" value="{{$up->tel_num}}" name="tel_num" class="form-control" placeholder="">
						</div>
					</div>
					@endforeach
					@else
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label for="name">Full Name</label>
							<input id="full_name" name="full_name" value="" class="form-control" placeholder="Full Name" type="text" required>
						</div>
					</div> -->
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="first_name">First Name</label>
							<input id="first_name" name="first_name" value="" class="form-control" placeholder="First Name" type="text" required>
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="last_name">Last Name</label>
							<input id="last_name" name="last_name" value="" class="form-control" placeholder="Last Name" type="text" required>
						</div>
					</div>
					  
					
					
					<div class="col-md-3">
						<div class="form-group">
							<label for="emailadd">Birthday</label>
							<input  id="bdate_accnt" value="" name="bdate" class="form-control bdate" placeholder="mm/dd/yyyy" >
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="emailadd">Age</label>
							<input  id="age" value="" name="age" class="form-control" placeholder="" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="emailadd">Gender</label>
							<select class="form-control" name="gender">
								@foreach($gender as $g =>$gval)
								<option  value="{{$g}}">{{$gval}}</option>
								@endforeach
							</select>
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="emailadd">Mobile Number</label>
							<input type="input" id="mobnum" value="" name="mobnum" class="form-control" placeholder="+639xx-xxx-xxxx">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tel_num">Telephone Number</label>
							<input type="input" id="tel_num" value="" name="tel_num" class="form-control" placeholder="">
						</div>
					</div>
					@endif
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h4>Account</h4>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="name">Name</label>
							<input id="name" name="name" value="{{$userID->name}}" class="form-control" placeholder="Enter name" type="text" required>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="emailadd">Email Address</label>
							<input type="email" id="emailadd" value="{{$userID->email}}" name="emailadd" class="form-control" placeholder="Enter Email Address" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="passwd">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
						</div>
					</div>
					  
					<div class="col-md-6">
						<div class="form-group">
							<label for="confpasswd">Confirm Password</label>
							<input type="password" id="confpassword" name="confpassword" class="form-control" placeholder="Enter Confirm Password">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
							<label for="role">User Types</label>
							<select class="form-control" name="usertypes_id" id="usertypes_id" data-parsley-required="true" required>
								<option value="" disabled selected>Select User Types {{$userID->users_type_id}}</option>
								@foreach ($utype_list as $key => $val)
									<option value="{{$key}}" {{ ($key == $userID->users_type_id) ?  ' selected' : '' }}>{{$val }}</option>
								@endforeach
							</select>
						</div> 
					</div> 
					
					@if(auth()->user()->role_id == 1)
					<div class="col-md-6">
						<div class="form-group">
							<label for="role">Role</label>
							<select class="form-control" name="role_id" id="role_id" data-parsley-required="true" required>
								@foreach ($role_list as $key => $val) 
									<option value="{{ $key }}" {{($key == $userID->role_id) ? 'selected' : '' }}>{{ $val }}</option>
								@endforeach
							</select>
						</div>
					</div>
					@endif
					<div class="text-right form-group">
						<button type="submit" class="btn btn-gold"><i class="fa fa-save"></i> Save</button>
						<a href="{!! URL::action('Admin\UserController@index') !!}"><button type="button" class="btn btn-default"><i class="fa fa-times-circle"></i> Cancel</button></a>
					</div>
        		 </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
              	<div class="row">
	                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                    <div class="row">
                        	<div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                            <div class="btn btn-gold pull-right add_address_btn" data-toggle="modal" data-target="#address_modal"><i class="fa fa-plus-circle"></i> Add Address</div>
	                        </div>
                        </div>
	                </div>
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
	                                <td>{{$ua->first_name}}</td>
	                                <td>{{$ua->mobile_num}}</td>
	                                <td>{{$ua->no_bldg_st_name.", ".$ua->brgy." ".$ua->city_municipality.", ".$ua->province}}</td>
	                                <td>{{$ua->other_notes}}</td>
	                                <td>{{($ua->is_billing == 1) ? (($ua->is_shipping == 1) ? 'Billing Address and Shipping Address' : 'Billing Address')  : (($ua->is_shipping == 1) ? 'Shipping Address' : '')}}</td>
	                                <td>
	                                    <a class="badge bg-orange edit-uaddr" data-uaddr_id = '{{$ua->id}}' data-uaddr_name="{{$ua->fullname}}"  data-mobnum = '{{$ua->mobile_num}}' data-stname = '{{$ua->no_bldg_st_name}}'  data-brgy = '{{$ua->brgy}}'   data-city_municipality = '{{$ua->city_municipality}}' data-province = '{{$ua->province}}'   data-othernotes = '{{$ua->other_notes}}' data-billing = '{{$ua->is_billing}}' data-shipping = '{{$ua->is_shipping}}' >
	                                        <span class="fa fa-edit"></span> Edit
	                                    </a>
	                                </td>
		                         </tr>
		                          <tr><td colspan="3"></td></tr>
		                          @endforeach
		                          @endif
		                    </tbody>
		                </table>  
		                <div class="pagination">  </div>  
	                </div>
                </div>
              </div>
              
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer text-right">
          
        </div>
    </div>
  </div>
  <div id="address_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
          <div class="panel panel-primary panel-brdr-gold">
          	<form id="editVariableForm" action="" method="post" accept-charset="UTF-8">
	            <div class="panel-heading panel-gold"><h4 class="modal-title">Address Form</h4></div>
	            <div class="panel-body">
	            	<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12 address_msg">
	                	</div>
	               </div>
					<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12">
	                		{!! csrf_field() !!}
	                		<div class="row">
	                			<!-- <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="addr_name">Name</label>
		            					<input id="addr_name" name="addr_name" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div> -->
					            <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="addr_frst_name">First Name</label>
		            					<input id="addr_frst_name" name="addr_frst_name" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
					            <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="addr_lst_name">Last Name</label>
		            					<input id="addr_lst_name" name="addr_lst_name" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
					            <!-- <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="addr_bdate">Birth Date</label>
		            					<input id="addr_bdate" name="addr_bdate" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div> -->
					            <!-- <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="addr_age">Age</label>
		            					<input id="addr_age" name="addr_age" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div> -->
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="addr_mobnum">Mobile Number</label>
		            					<input id="addr_mobnum" name="addr_mobnum" class="form-control addr_inp" type="text"  value="">
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
		            					<label for="addr_stname">House No/ Bldg/ Street Name</label>
		            					<input id="addr_stname" name="addr_stname" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="addr_brgy">Barangay</label>
		            					<input id="addr_brgy" name="addr_brgy" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="addr_city">City/Municipality</label>
		            					<input id="addr_city" name="addr_city" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="addr_prov">Province</label>
		            					<input id="addr_prov" name="addr_prov" class="form-control addr_inp" type="text"  value="">
						            </div>
					            </div>
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="addr_othrnotes">Other Notes</label>
		            					<textarea id="addr_othrnotes" name="addr_othrnotes" class="form-control addr_inp_txtarea" rows="5"></textarea>
						            </div>
					            </div>
					            <div class="col-md-6 col-sm-6 col-xs-12">
					            	<label> Set As :</label>
					            	<div class="form-group">
		            					<input type="checkbox" id="addr_billing" name="addr_billing" class="addr_chk"  value="1" />
		            					<label for="variable_name">Billing Address</label>
						            </div>
						            <div class="form-group">
		            					<input type="checkbox" id="addr_shipping" name="addr_shipping" class="addr_chk" value="1" />
		            					<label for="variable_name">Shipping  Address</label>
						            </div>
					            </div>
					            <div class="col-md-3 col-sm-3 col-xs-12">
						            
					            </div>
					            <div class="col-md-3 col-sm-3 col-xs-12">
						            
					            </div>
				            </div>
					    </div>
					</div>
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

  <div id="upl_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background:#c1c1c1;">
           
            
            <div class="modal-body">
			<button type="button" class="close custom-close-modal" aria-label="close" data-dismiss="modal">&times; </button>
            	<form action="{{ URL::action('Admin\UserController@image_upl') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data" >
            		{!! csrf_field() !!}
        		<div class="row">
					<div class="form-group upl_img">
						
						<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1 preview_image mb10">
							<!-- <img src="{!! asset('img/users/default.jpg') !!}" style="display:block; margin: 0 auto;" /> -->
						</div>
						<h4 class="text-center cpointer">
							<div class="btn btn-orange btn-app btnupload">
	    						<input name="profpic" class="form-control upload_image" type="file" value="">
	    						<i class="fa fa-upload"> Choose Photo</i>
	    					</div>
    					</h4>
						
					</div>
				</form>
				</div>
				<!-- <div class="row">
            		<div class="col-md-12 col-sm-12 col-xs-12">
            			<div class="btn btn-success">
            				Upload Now!
            			</div>
            		</div>
            	</div> -->
        	</div>
        	
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
	$('.add_address_btn').on('click',function(){
		$('.addr_inp').val('');
		$('.addr_chk').prop('checked', false);
		$('.addr_inp_txtarea').val('');
		$('.addr_sbmt_btn').html('Add');
	});
	$('.edit-uaddr').on('click',function(){
		$('#addr_name').val($(this).data('uaddr_name'));
		$('#addr_mobnum').val($(this).data('mobnum'));
		$('#addr_stname').val($(this).data('stname'));
		$('#addr_brgy').val($(this).data('brgy'));
		$('#addr_city').val($(this).data('city_municipality'));
		$('#addr_prov').val($(this).data('province'));
		$('#addr_othrnotes').val($(this).data('othernotes'));
		
		$('#uaddress_id').val($(this).data('uaddr_id'));
		prop_billing = ($(this).data('billing') == '1' ? true : false);
		prop_shipping = ($(this).data('shipping') == '1' ? true : false);
		$('#addr_billing').prop('checked',prop_billing);
		$('#addr_shipping').prop('checked',prop_shipping);
		
		$('.addr_sbmt_btn').html('Update');
		$('#address_modal').modal('show');
	});

	$('.addr_sbmt_btn').on('click',function(){
		$data_address = $('#editVariableForm').serializeArray();
		$.ajax({
            url: base_url+'/admin/address_details',
            method: "post",
            dataType: "json",
            data:$data_address,
            success: function (data) {
              
               $('.address_msg').html(data.msg_text);
               setTimeout(function(){
               	 $('.address_msg').fadeOut('slow');
               	$('#address_modal').modal('hide');
               	location.reload();
               },3000);
            }
        });
	});

function onchange_img(e,umg){
	html_appender = $(umg).parents('.upl_img').find('.preview_image');
	var files = e.target.files,
    filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader(umg);
        fileReader.onload = (function(e,umg) {
          var file = e.target;
          prev_img = "<span class=\"img_prev_wrap\">" +
            				"<span class=\"remove btn btn-danger\" style=''><i class='fa fa-trash'></i> Remove</span>" +
            				"<button class=\"uploadnow btn btn-success\" type=\"submit\" style='position:absolute;'><i class='fa fa-check-circle'></i> Upload</button>" +
				            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
				            "</span>";
          html_appender.html(prev_img);
          
          $(".remove").click(function(){
            $(this).parent(".img_prev_wrap").remove();
          });
        });
        fileReader.readAsDataURL(f);
      }
}

 $(".upload_image").on("change", function(e) {
 	umg = this;
 	onchange_img(e,umg);
});


</script>
@stop

