@extends('layouts.admin.signin')

@section('content')

<style>
	.form-group.has-error .form-control, .form-group.has-error .input-group-addon{
		    border-color: #d8a421;
	}
</style>
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Universal Paint</b> | Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  	<div class="row">
  		<div class="col-md-12 col-sm-12 col-xs-12">
    		<p class="login-box-msg">Sign in to start your session</p>

    @if (session('status'))
	        <br>
	        <div class="alert alert-danger">
	        	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
	        </div>
    @endif
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/signin') }}">
		    {{ csrf_field() }}
		    <div class="col-md-12 col-sm-12 col-xs-12">
		    	
		    
		      <div class="form-group has-feedback {{ (isset($userName)) ? ' has-error' : '' }}">
		        <input type="email" class="form-control" placeholder="Email" name="emailadd">
		        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		        @if (isset($userName))
		            <span class="help-block">
		                <strong>{{ $userName }}</strong>
		            </span>
		        @endif
		      </div>
		      <div class="form-group has-feedback {{ (isset($passWord)) ? ' has-error' : '' }}">
		        <input type="password" class="form-control" placeholder="Password" name="passwd">
		        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		        @if (isset($passWord))
		            <span class="help-block">
		                <strong>{{ $passWord }}</strong>
		            </span>
		        @endif
		      </div>
		      <div class="row">
		        <div class="col-md-8 col-sm-8 col-xs-12">
		          <div class="checkbox icheck">
		            <label>
		              <input type="checkbox" name="rememberme"> Remember Me
		            </label>
		          </div>
		        </div>
		        <!-- /.col -->
		        <div class="col-md-4 col-sm-4 col-xs-12" style="padding-right:0;">
		          <button type="submit" class="btn btn-primary btn-block btn-flat" style="color:#d8a421;background:rgb(29, 29, 29);    border-color: #CCC;">Sign In</button>
		        </div>
		        <!-- /.col -->
		      </div>
		      
		      </div>
		    </form>
    
    <a href="#">I forgot my password</a><br>
    </div>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@stop