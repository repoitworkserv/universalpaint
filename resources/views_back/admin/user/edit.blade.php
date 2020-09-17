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

  </section>
 <form action="{{ URL::action('Admin\UserController@update', [$userID->id]) }}" method="post" accept-charset="UTF-8">  
  <div class="col-md-8 content">
    <div class="box box-gold">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-plus-circle"></i> Edit New User
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

     

        <input type="hidden" value="PATCH" name="_method">
        {!! csrf_field() !!}

        <div class="box-body">

          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Name</label>
              <input id="name" name="name" value="{{$userID->name}}" class="form-control" placeholder="Enter name" type="text" required>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="emailadd">Email Address</label>
              <input type="email" id="emailadd" value="{{$userID->email}}" name="emailadd" class="form-control" placeholder="Enter Email Address" readonly>
            </div>
          </div>


          <!--div class="col-md-6">
            <div class="form-group">
              <label for="phonenum">Phone Number</label>
              <input type="number" id="phonenum" name="phonenum" value="{{$userID->phonenum}}" class="form-control" placeholder="ex. 09123456789" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="companyname">Company Name</label>
              <input type="text" id="companyname" name="companyname" value="{{$userID->companyname}}" class="form-control" placeholder="Enter Company Name" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="province">Province</label>
              <input type="text" id="province" name="province" value="{{$userID->province}}" class="form-control" placeholder="Enter Province" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="city">City/Municipality</label>
              <input type="text" id="city" name="city" value="{{$userID->city}}" class="form-control" placeholder="Enter City" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address" value="{{$userID->address}}" class="form-control" placeholder="Enter Address" required="">
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="postalcode">Posta Code</label>
              <input type="text" id="postalcode" name="postalcode" value="{{$userID->postalcode}}" class="form-control" placeholder="Enter Postal Code" required="">
            </div>
          </div-->

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
                   

        </div>
        <!-- /.box-body -->

        <div class="box-footer text-right">
          <button type="submit" class="btn btn-gold"><i class="fa fa-save"></i> Save</button>
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
      				<input type="checkbox" {{in_array($bl->id, $exlist) ? 'checked' : ''}} name="user_brandlist[]" value="{{$bl->id}}" />
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