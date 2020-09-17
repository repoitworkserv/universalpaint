@extends('layouts.user.app')

@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row mb20">
			<a href="{{URL::to('/customer/profile')}}">
			<div align="right" class="col-md-12 col-sm-12 col-xs-12">
				<button class="button button--aylen" tabindex="0" style="margin: 0;">Back to Profile</button>
			</div></a>
		</div>
		<div class="row">
			<h3 class="box-title">Manage Credit Card 
				<span class=" pull-right add_cc_btn" data-toggle="modal" data-target="#cc_modal">
					<small>
						<i class="fa fa-plus-circle"></i> Add New
					</small>
				</span>
			</h3>
		</div>
		<div class="row">
			@php
				$count_cc = $cclist->count();
			@endphp
			@if($count_cc > 0 )
				@foreach($cclist as $cc)
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="col-md-12 col-sm-12 col-xs-12" style="border-radius: 10px; border:solid 2px #CCC;">
							<h3>{{strtoupper($cc->type)}} <span class="pull-right editcc" data-ccid="{{$cc->id}}" data-cctype="{{strtoupper($cc->type)}}" data-ccnum="{{$cc->number}}" data-expdate="{{date('m/Y', strtotime($cc->expiry_date))}}" data-ccholder="{{$cc->holder}}" data-toggle="modal" data-target="#cc_modal"><small>Edit</small></span></h3>
							<h4>{{$cc->number}}</h4>
							<small>Exp. Date : {{date('m/Y', strtotime($cc->expiry_date))}}</small>
							<br />
							<strong>{{$cc->holder}}</strong>
						</div>
					</div>
				
				@endforeach
			@else
			
			@endif
			<!-- <div class="col-md-4 col-sm-4 col-xs-12">
				<div class="col-md-12 col-sm-12 col-xs-12" style="border-radius: 10px; border:solid 2px #CCC;">
					<h3>VISA <span class="pull-right"><small>Edit</small></span></h3>
					<h4>1234 5678 9876 5432</h4>
					<small>Exp. Date : 12/2023</small>
					<br />
					<strong>Juan Dela Cruz</strong>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="col-md-12 col-sm-12 col-xs-12" style="border-radius: 10px; border:solid 2px #CCC;">
					<h3>Master Card <span class="pull-right"><small>Edit</small></span></h3>
					<h4>1234 5678 9876 5432</h4>
					<small>Exp. Date : 12/2023</small>
					<br />
					<strong>Juan Dela Cruz</strong>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="col-md-12 col-sm-12 col-xs-12" style="border-radius: 10px; border:solid 2px #CCC;">
					<h3>BancNet <span class="pull-right"><small>Edit</small></span></h3>
					<h4>1234 5678 9876 5432</h4>
					<small>Exp. Date : 12/2023</small>
					<br />
					<strong>Juan Dela Cruz</strong>
				</div>
			</div> -->
			
		</div>
	</div>
</div>


 <div id="cc_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
          <div class="panel panel-primary panel-brdr-orange">
          	<form id="editVariableForm" action="" method="post" accept-charset="UTF-8">
	            <div class="panel-heading panel-orange"><h4 class="modal-title">Credit Card Form</h4></div>
	            <div class="panel-body">
	            	<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12 cc_msg">
	                	</div>
	               </div>
					<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12">
	                		{!! csrf_field() !!}
	                		<div class="row">
	                			
					            <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="cc_type">Type</label>
		            					<input id="cc_type" name="cc_type" class="form-control cc_inp" type="text"  value="">
						            </div>
					            </div>
					            <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="cc_number">Number</label>
		            					<input id="cc_number" name="cc_number" class="form-control cc_inp" type="text"  value="">
						            </div>
					            </div>
					            <div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		            					<label for="cc_holder">Holder Name</label>
		            					<input id="cc_holder" name="cc_holder" class="form-control cc_inp" type="text"  value="">
						            </div>
					            </div>
					            
	                			<div class="col-md-6 col-sm-6 col-xs-12">
						            <div class="form-group">
		            					<label for="cc_exp_date">Expiration Date</label>
		            					<input id="cc_exp_date" name="cc_exp_date" class="form-control cc_inp" type="text"  value="">
						            </div>
					            </div>
	                			
				            </div>
					    </div>
					</div>
	            </div>
	            <div class="panel-footer">
	              <div class="row">
	                
	                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                  <input type="hidden" name="cc_id" id="cc_id" class="cc_inp" value="" />
	                  <div  class="btn btn-gold cc_sbmt_btn">Add</div>
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
<script>
	$('.editcc').click('click', function(){
		cc_type = $(this).data('cctype');
		cc_number = $(this).data('ccnum');
		cc_holder = $(this).data('ccholder');
		cc_exp_date = $(this).data('expdate');
		cc_id = $(this).data('ccid');
		
		
		$('.cc_sbmt_btn').html('Update');
		$('#cc_type').val(cc_type);
		$('#cc_number').val(cc_number);
		$('#cc_holder').val(cc_holder);
		$('#cc_exp_date').val(cc_exp_date);
		$('#cc_id').val(cc_id);
		
	});


	$('.cc_sbmt_btn').on('click',function(){ 
		$data_address = $('#editVariableForm').serializeArray();
		$.ajax({
            url: base_url+'/customer/update_creditcard',
            method: "post",
            dataType: "json",
            data:$data_address,
            success: function (data) {
              
               $('.cc_msg').html(data.msg_text);
               setTimeout(function(){
               	 $('.cc_msg').fadeOut('slow');
               	$('#cc_modal').modal('hide');
               	$('.cc_inp').val('');
               	location.reload();
               },3000);
            }
        });
	});
	
	$('.add_cc_btn').on('click',function(){
		$('.cc_inp').val('');
		$('.cc_sbmt_btn').html('Add');
	});
</script>
@endsection	