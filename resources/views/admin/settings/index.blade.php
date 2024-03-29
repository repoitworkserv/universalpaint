@extends('layouts.admin.main')

@section('styles')

<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  
<section class="content-header">
	<h1>
      Settings
    </h1>
    
    @if (session('status'))
        
	<br>
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        
		</div>
    @endif

		<?php 
      $myPermit = explode(",",Auth::user()->permission);
    ?>
  
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="box box-gold">
					<div class="box-header">
						<h3 class="box-title">
							<i class="fa fa-plus-circle"></i> Maintenance Mode 
						</h3>
                    {!! csrf_field() !!}
                
					</div>
					<div class="box-body">
						<form  id="modeform">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group mode_msg"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Mode</label>
										<select class="form-control" name="selectmode">
		                    			@foreach($mode as $key =>$value)
		                    				
											<option {{count($settings) > 0 ? (($settings['mode'] == $key) ? 'selected' : '')  : ''}} value="{{$key}}">{{$value}}</option>
		                    			@endforeach
		                    			
											<!--option value="under_maintenance">Under Maintenance</option><option value="live">Live</option-->
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 text-right">
								@if(in_array(7.2, $myPermit))
									<div class="btn btn-gold mode_btn_sbmt" data-tags="mode">
	                    			Submit
	                </div>
								@endif
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="box box-gold">
					<div class="box-header">
						<h3 class="box-title">
							<i class="fa fa-plus-circle"></i> Email Address
						</h3>
					</div>
					<div class="box-body">
						<form id="emailform">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group email_msg"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Customer Services</label>
										<input type="text" name="inpemail" class="form-control" value="{{(array_key_exists('email_address',$settings) ? $settings['email_address'] : '' )}}" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Delivery and Order</label>
										<input type="text" name="inpemail_delopt" class="form-control" value="{{(array_key_exists('delivery_and_order_email',$settings) ? $settings['delivery_and_order_email'] : '' )}}" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 text-right">
									@if(in_array(7.2, $myPermit))
									<div class="btn btn-gold email_btn_sbmt" data-tags="email">
	                    			Submit
	                </div>
									@endif
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="box box-gold">
					<div class="box-header">
						<h3 class="box-title">
							<i class="fa fa-plus-circle"></i> Product Brochure PDF
						</h3>
					</div>
					<div class="box-body">
						<form id="brochureform" method="POST" action="{{URL::action('Admin\SettingsController@product_brochure_save')}}" enctype="multipart/form-data">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group email_msg"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>PDF @if(!empty($settings['product_brochure_pdf']))<a id="brochure_link" href="{{URL::to('/')}}/img/product_brochure/{{$settings['product_brochure_pdf']}}">{{URL::to('/')}}/img/product_brochure/{{$settings['product_brochure_pdf']}}</a> @endif </label>
										<input type="hidden" id="brochure_form_action" name="brochure_form_action" value="UPDATE">
										<input type="file" accept="application/pdf" class="form-control" name="product_brochure" id="product_brochure" />
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12 text-right">
											@if(in_array(7.2, $myPermit))
											<button type="submit" class="btn btn-gold product_brochure_btn_sbmt" data-tags="brochure">
																Submit
															</button>
											@endif
											@if(in_array(7.3, $myPermit))
											<button class="btn btn-danger delete_brochure" data-tags="brochure">
																Delete
															</button>
											@endif
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop

@section('scripts')

	<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
	<script>
	$('.mode_btn_sbmt,.email_btn_sbmt').on('click',function(){
		tags = $(this).data('tags');
		form_name = (tags == 'mode') ? 'modeform' : 'emailform';
		serializedata = $('#'+form_name).serializeArray();
		var Token = $('input[name="_token"]').val(); 
		addarr = {name : 'tags', value:tags,};
		addtoken = {name : '_token', value : Token,};
		
		serializedata.push(addarr);
		serializedata.push(addtoken);
		//  console.log(serializedata);
		$.ajax({
	        url: '/admin/settings/setting_save',
	        method: "post",
	        dataType: "json",
	        data: serializedata,
	       
	        success: function (data) {
	            if(data.msg){
	            	msg_prompt = (tags == 'mode' ? 'mode_msg' : 'email_msg');
	            	$('.'+msg_prompt).html(data.msg)
	            	
	            }
	        }
	    });
	});

	$('.delete_brochure').click(function(e) {
		if(confirm("Are you sure you want to delete?")) {
			e.preventDefault();
			$('#brochure_form_action').val("DELETE");
			$('#brochureform').submit();
		}
	});
	
	
</script>
@stop