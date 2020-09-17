@extends('layouts.user.app')

@section('content')

<div id="registration-form">
	<div class="registration-table">
		<div class="title">Create an EZDEAL Account</div>
		@include('flash-message')
		<div class="row reg-data">
			<form action="{{ URL::action('User\RegisterController@register_customer') }}" id="register_form" method="post" accept-charset="UTF-8">  
				{!! csrf_field() !!}
				<div class="col-md-12 content">
					<div class="box box-primary box-gold">
					<!-- /.box-header -->
					<!-- form start -->
						<div class="box-body col-md-8">
							<div class="col-md-6">
								<div class="form-group">
								<label for="">First Name</label>
								<input id="firstname" name="firstname" style="text-transform: capitalize;" class="form-control" value="{!! old('firstname')!!}" placeholder="Enter first name" type="text" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="">Last Name</label>
								<input id="lastname" name="lastname" style="text-transform: capitalize;" class="form-control" value="{!! old('lastname') !!}" placeholder="Enter last name" type="text" required>
								</div>
							</div>
							<div class="col-md-6"> 
								<div class="form-group">
									<label for="">Select Gender</label>
									<select class="form-control" name="gender" id="" data-parsley-required="true" required>
										<option value="" >Male / Female</option>
										@foreach($gender as $g => $val)
											<option value="{{$g}}">{{$val}}</option>
										@endforeach
									</select>
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="">Birthdate</label>
								<input type="text" id="" name="birthdate" value="{{ old('birthdate') }}" class="form-control bday" placeholder="MM/DD/YYYY" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="emailadd">Email Address</label>
								<input type="email" id="emailadd" name="emailadd" value="{{ old('emailadd') }}" class="form-control" placeholder="Enter Email Address" required>
								</div>
							</div>
							<div class="col-md-6">
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
							<div class="col-md-6">
								<div class="form-group">
								<label for="no_bldg_st_name">House No/ Bldg/ Street Name</label>
								<input id="no_bldg_st_name" name="no_bldg_st_name" class="form-control" value="{!! old('no_bldg_st_name') !!}" placeholder="Enter House No/ Bldg/ Street Name" type="text" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="brgy">Barangay</label>
								<input id="brgy" name="brgy" class="form-control" value="{!! old('brgy') !!}" placeholder="Enter Barangay" type="text" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="">City/Municipality</label>
								<input id="city_municipality" name="city_municipality" style="text-transform: capitalize;" class="form-control" value="{!! old('city_municipality') !!}" placeholder="Enter City/Municipality" type="text" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="province">Province</label>
								<input id="province" name="province" class="form-control" style="text-transform: capitalize;" value="{!! old('province') !!}" placeholder="Enter Province" type="text" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="">Phone Number</label>
								<input type="number" id="" name="phone_number" value="{{ old('phone_number') }}" class="form-control" placeholder="ex. 09123456789" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="passwd">Password</label>
								<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="confpasswd">Confirm Password</label>
								<input type="password" id="confpassword" name="confpassword" class="form-control" placeholder="Enter Confirm Password" required>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="col-md-4 right-btns">
							<div class="signup-notes"><input type="checkbox" name="agree_box" required> By signing up, you agree to EZ Deal Online Shopping's <span class="note-link"><a href="">Terms and Conditions</a></span> & <span class="note-link"><a href="">Privacy Policy</a></span>.</div>
							<div class="save-reg">
							<button type="submit" class="btn btn-gold">Create an EZDEAL Account</button>
							</div>
							<div class="signup-other">
								<div class="title">Sign Up with</div>
								<div class="other-btns">
									<div class="fb-btn">
										<button type="submit" class="btn btn-blue"><i class="fa fa-facebook"></i> Facebook</button>
									</div>
									<div class="email-btn">
										<button type="submit" class="btn btn-red"><i class="fa fa-google-plus"></i> Email</button>
									</div>
								</div>
							</div>
						</div>
					</div>
			 	</div>
			</form>
		</div>
	</div>
</div>

@endsection