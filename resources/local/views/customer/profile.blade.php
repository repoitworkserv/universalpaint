@extends('layouts.user.app')
@section('css')
<style>
    #footer {
        display: none !important;
	}
    #loading-container {
       background: #F7F7F7;
    }
    .hrcolor{
    	    border-top: 1px solid #daa521;
    }
</style>
@endsection
@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row">
			<div id="profile" class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
								@if($uimage)
									@foreach($uimage as $uimg)
										<img src="{!! asset('img/customer/profile').'/'.$uimg->ImageData['file_name'] !!}" style="display:block; margin: 0 auto;width: 100%;" />
									@endforeach
								@else
								<img src="{!! asset('img/users/default.jpg') !!}" style="display:block; margin: 0 auto;width: 100%;" />
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- Profile Start -->
				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
					<hr class="hrcolor">
					<h4>Profile <span><a href="{{URL::to('/customer/manage-profile')}}"><small style="float:right;"><i class="fa fa-edit" ></i> edit</small></a></span></h4>
					@foreach($uprofile as $uprof)
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							First Name :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ (!empty($uprof->first_name)) ? $uprof->first_name : 'N/A' }}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							Last Name :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ (!empty($uprof->last_name)) ? $uprof->last_name : 'N/A' }}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							Birth Date :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ (!empty($uprof->birthdate)) ? date('F j, Y', strtotime($uprof->birthdate)) : 'N/A' }}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-4 col-xs-12">
							Gender :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ !empty($uprof->gender) ? ucfirst($uprof->gender): 'N/A' }}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-4 col-xs-12">
							Email Address :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								{{ (!empty($uprof->UserData['email'])) ? $uprof->UserData['email'] : 'N/A'}}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-4 col-xs-12">
							Mob Number :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ (!empty($uprof->mobile_num)) ? $uprof->mobile_num : 'N/A' }}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-4 col-xs-12">
							Tel Number :
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							{{ (!empty($uprof->tel_num)) ? $uprof->tel_num : 'N/A' }}
						</div>
					</div>
				@endforeach
				</div>
					<!-- Profile End -->
					<!-- Address Book Start -->
				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
					<hr class="hrcolor">
					<h4>Address Book <span><a href="{{URL::to('/customer/manage-addressbook')}}"><small style="float:right;"><i class="fa fa-edit" ></i> edit</small></a></span></h4>
					@if(!empty($useraddress_billing))
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h5><strong>Billing Address</strong></h5>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							@foreach($useraddress_billing as $uaddr_b)
								{{$uaddr_b->no_bldg_st_name.', '.ucfirst($uaddr_b->brgy).', '.ucfirst($uaddr_b->city_municipality).', '.ucfirst($uaddr_b->province)}}
							@endforeach
						</div>
					</div>
					@endif
					@if(!empty($useraddress_shipping))
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h5><strong>Shipping Address</strong></h5>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							@foreach($useraddress_shipping as $uaddr_s)
								{{$uaddr_s->no_bldg_st_name.', '.ucfirst($uaddr_s->brgy).', '.ucfirst($uaddr_s->city_municipality).', '.ucfirst($uaddr_s->province)}}
							@endforeach
						</div>
					</div>
					@endif
					@if(!empty($useraddress))
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h5><strong>Others</strong></h5>
						</div>
						@foreach($useraddress as $uaddr)
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							{{$uaddr->no_bldg_st_name.', '.ucfirst($uaddr->brgy).', '.ucfirst($uaddr->city_municipality).', '.ucfirst($uaddr->province)}}
						</div>
						@endforeach
					</div>
					@endif
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
					<hr class="hrcolor">
					<h4>Credit Card Details <span><a href="{{URL::to('/customer/manage-creditcard')}}"><small style="float:right;"><i class="fa fa-edit" ></i> edit</small></a></span></h4>
					<hr class="hrcolor">
				</div>
			</div>
			<div class="anchor col-lg-8 col-md-7 col-sm-12 col-xs-12" id="my-reviews"></div>
			<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">My Reviews</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body no-padding">
			            	@if($userreviewandreatings)
			            		@if(!empty($userreviewandreatings[0]))
				            		@foreach($userreviewandreatings as $k)
				            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
												@php
													$prodimg =$k->ProductData['featured_image'];
												@endphp
												<img src="{!! asset('img/products').'/'.$k->ProductData['featured_image'] !!}" style="display:block; margin: 0 auto; width: 100%" />
											</div>
											<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="col-lg-12 col-md-12 col-sm-12">
															<label>{{$k->ProductData['name']}}</label>
															<p>{{$k->ProductData['product_code']}}</p>
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{($k->is_approved == 1) ? '' : 'text-center'}}">
														@if($k->is_approved == 1)
														<div class="rate-star">
															<span>{{$k->title}}</span> 
															<span class="text-right" style="float:right;">
																@php
																$rate = $k->rate;
																@endphp
																@for($r=0;$r<$rate;$r++)
																	<i class="fa fa-star rated-star"></i>
															@endfor
															</span>
														</div>
														<!-- <label>Awesome!!!</label> -->
														<p>{{$k->reviews}}</p>
														@else
															<!-- <a href="{{URL::to('/product').'/'.$k->ProductData['slug_name']}}"><div class="btn btn-orange">Make a Review Now!</div></a> -->
															<h4>For Approval</h4>
														@endif
													</div>
												</div>
											</div>
								        </div>
				            		@endforeach
				            		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
				            			<div class="pagination"> {{ $userreviewandreatings->links() }} </div>
				            		</div>
			            		@else
			            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
					            		<h4 class="text-center">No Ratings and Reviews Found!</h4>
					            	</div>
			            		@endif
			            	@else
			            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
			            		<h4 class="text-center">No Ratings and Reviews Found!</h4>
			            	</div>
			            	@endif
			            </div>
			            <!-- /.box-body -->
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
@stop