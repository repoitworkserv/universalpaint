@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/dropzone/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      User Management
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-danger">
        {!! nl2br(session('status')) !!}
        </div>
    @endif
    <?php 
      $myPermit = explode(",",Auth::user()->permission);
   	?>  

  </section>
<form action="{{ URL::action('Admin\UserController@store') }}" method="post" accept-charset="UTF-8">  
  <div class="col-md-8 content">
    <div class="box box-primary box-gold">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-plus-circle"></i> Create New User
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      
      

        {!! csrf_field() !!}

        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Full Name</label>
              <input id="name" name="name" class="form-control" placeholder="Enter name" type="text" required>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="emailadd">Email Address</label>
              <input type="email" id="emailadd" name="emailadd" class="form-control" placeholder="Enter Email Address" required="">
            </div>
          </div>

          <!--div class="col-md-6">
            <div class="form-group">
              <label for="phonenum">Phone Number</label>
              <input type="number" id="phonenum" name="phonenum" class="form-control" placeholder="ex. 09123456789" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="companyname">Company Name</label>
              <input type="text" id="companyname" name="companyname" class="form-control" placeholder="Enter Company Name" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="province">Province</label>
              <input type="text" id="province" name="province" class="form-control" placeholder="Enter Province" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="city">City/Municipality</label>
              <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" required="">
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="postalcode">Posta Code</label>
              <input type="text" id="postalcode" name="postalcode" class="form-control" placeholder="Enter Postal Code" required="">
            </div>
          </div-->
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="passwd">Password</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required="">
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="confpasswd">Confirm Password</label>
              <input type="password" id="confpassword" name="confpassword" class="form-control" placeholder="Enter Confirm Password" required="">
            </div>
          </div>
		  <!-- <div class="col-md-6"> 
           	<div class="form-group">
	            <label for="role">User Types</label>
	            <select class="form-control" name="usertypes_id" id="usertypes_id">
	            	<option value="" disabled selected>Select User Types</option>
                <option value="Admin">Admin</option>
	            @foreach ($utype_list as $key => $val)
	            	<option value="{{ $key }}">{{ $val }}</option>
	            @endforeach
	            </select>
	          </div> 
			</div>  -->
		 <div class="col-md-6">
	          <div class="form-group">
	            <label for="role">Role</label>
	            <select class="form-control" name="role_id" id="role_id" data-parsley-required="true" required>
	            	<option value="" disabled selected>Select Role</option>
	            @foreach ($role_list as $key => $val)
	             <option value="{{ $key }}">{{ $val }}</option>
	            @endforeach
	            </select>
	          </div> 
          </div>  
          
        </div>
        <!-- /.box-body -->

        <div class="box-footer text-right">
          @if(in_array(6.2, $myPermit))
          <button type="submit" class="btn btn-gold"><i class="fa fa-save"></i> Save</button>
          @endif
          <a href="{!! URL::action('Admin\UserController@index') !!}"><button type="button" class="btn btn-default"><i class="fa fa-times-circle"></i> Cancel</button></a>
        </div>
      
     

    </div>
  </div>
  <div class="col-md-4 content">
    <div class="box box-primary box-gold">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-list"></i> Brand List
        </h3>
      </div>
      <div class="box-body">
      	<div class="row">
      		@foreach($brandlist as $bl)
				<div class="col-md-6 col-xs-6 col-xs-12">
      				<input type="checkbox" name="user_brandlist[]" value="{{$bl->id}}" />
      				<label>{{$bl->name}}</label>
      			</div>
      		@endforeach
      	</div>
      </div>
    </div>
  </div>
 </form>
@stop

@section('scripts')

@stop