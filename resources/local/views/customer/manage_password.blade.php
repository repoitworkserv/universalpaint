@extends('layouts.user.app')



@section('styles')
<link href="{!! asset('static/dropzone/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row mb20">
			<div class="col-md-12 col-sm-12 col-xs-12" align="right">
				<a href="{{URL::to('/customer/profile')}}">
				<button class="button button--aylen" tabindex="0" style="margin: 0;">Back to Profile</button>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="alert alert-{{session('myclass')}}">
				{!! nl2br(session('status')) !!}
			</div>
			<h3 class="box-title">Manage Password 
				<!-- <span class=" pull-right add_address_btn" data-toggle="modal" data-target="#address_modal">
					<small>
						<i class="fa fa-plus-circle"></i> Add Address
					</small>
				</span> -->
			</h3>
			{!! Form::open(['action'=>'Customer\ProfileController@update_password', 'method'=>'post','id'=>'updatepass']) !!}
				{!! csrf_field() !!}
            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                <div class="form-group">
					{!! Form::label('curr_pass','Current Password') !!}									
					{!! Form::password('curr_pass',['class'=>'form-control', 'maxlength'=>16]) !!}
	            </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                <div class="form-group">
					{!! Form::label('new_pass','New Password') !!}									
					{!! Form::password('new_pass',['class'=>'form-control', 'placeholder'=>'At least 8 characters', 'maxlength'=>16]) !!}
	            </div>
	            <div class="form-group">
					{!! Form::label('cnfrm_new_pass','Confirm New Password') !!}									
					{!! Form::password('cnfrm_new_pass',['class'=>'form-control', 'placeholder'=>'Confirm New Password','maxlength'=>16]) !!}
	            </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3 text-center">
                <div class="form-group">
					<div class="btn btn-success resetpass"> Update Password</div>
	            </div>
			</div>
			{!! Form::close()!!}
    	</div>
	</div>
</div>
  

@stop
