@extends('layouts.user.app')

@section('content')
@if($postmetadata->count() > 0)
	@foreach($postmetadata as $pmd)
		@php
			$metaval_expl = explode(',',$pmd->meta_value);
			$count_metaval = count($metaval_expl);
		@endphp
			@if($count_metaval > 0)
			<div id="banner-slider" class="carousel slide" data-ride="carousel">
        <div class="slick"> 
					@for($mve= 0; $mve<$count_metaval;$mve++)
						
						@if($metaval_expl[$mve] > 0)

							@php 
								$postdata = \App\Post::find($metaval_expl[$mve]); 
							@endphp <!-- slick -->
							
							<div class="carousel-inner"> <!-- banner content -->
								<div class="item active bg-img" style="background: url({{ URL::asset('/img/post/'.$postdata->featured_banner) }})">
									<div class="bg-overlay"></div>
									<div class="banner-content" >
										<div class="row vcenter">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            	@if($postdata->displayed_title === null)
                                                <div class="md-txt">

												</div>
                                            	@else
                                            	<div class="md-txt">
													<h1>{!!$postdata->post_title!!}</h1>
												</div>
                                            	@endif
												<div class="short-desc">

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					@endif
				@endfor
				</div> <!-- close slick -->
			</div>
			@endif
<div class="container">
    <div class="page-header">
        <div class="page-title"><h2 class="text-center">{{$pmd->display_name}}</h2></div>       
    </div>
    @if (Request::path() == 'single_page/Contact%20Us' && !empty($uid));
	
	<div id="contact-us-form" >
	@include('flash-message')
		<div class="contact-us">
			<div class="title">Contact Us</div>
			<div class="row ">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="map">
						<div class="title-cont">MAP</div>
						<div class="map-img"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3859.986897812066!2d120.98336700000002!3d14.656685000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x185d2e010b4a3d33!2sAraneta+Square!5e0!3m2!1sen!2ssg!4v1521193893934" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="title-cont">ADDRESS</div>
					<div class="address">
						<div class="details">Unit T8 3rd Floor Araneta, Square Mall Monumento, Caloocan City</div>
						<div class="number">
							<div class="details">Landline: (02) 366 44 45</div>
							<div class="details">Smart: 0998 790 16 00</div>
							<div class="details">Globe: 0977 834 81 19</div>
							<div class="details">Sun: 0922 819 98 84</div>
						</div>
						<div class="details">glamour.mihs@gmail.com</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="inquery">
						<div class="title-cont">FOR INQUIRY</div>
						<!-- <form action="{{ URL::action('User\ContactUsController@contact_form') }}" method="post" accept-charset="UTF-8"> -->
						<form id="inquiry_form" action="{{ URL::action('User\SinglePageController@contact_form') }}"  method="post">
							<div class="form-group contact_us_msg"></div>
							{!! csrf_field() !!}
							<div class="input-group inquiry-form">
								<input type="text" id="fullname" name="fullname" class="form-control" placeholder="Name">

								<input type="text" id="contactnumber" name="contactnumber" class="form-control" placeholder="Contact">
								<input type="text" id="emailadd" name="emailadd" class="form-control" placeholder="Email">
								<select class="form-control" name="titlesubject">
									<option value="" disabled selected>< - - - - Subject Title - - - - ></option>
									<option value="product_inquiry">Product Inquiry</option>
									<option value="account_safety">Account Safety and Others</option>
									<option value="orders_payments">Orders & Payments</option>
									<option value="shipping_delivery">Shipping & Delivery</option>
									<option value="tracking_updates">Tracking Updates</option>
								</select>
								<textarea class="form-control"  id="messagecontact" name="messagecontact" placeholder="Your Message"></textarea>
								<button type="submit" class="btn btn-gold" id="send_contactus_btn">Send</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
    <!-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
        	{{$pmd->meta_key}}
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">   
        	picture here
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
        	content here
        </div>
    </div> -->
    <div class="page-content mb20">
	@if($pmd->meta_value)
		@php
			
			$metaval_expl = explode(',',$pmd->meta_value);
			$count_metaval = count($metaval_expl);
		@endphp	
			@if($count_metaval > 0)
				
				@for($mve= 0; $mve<$count_metaval;$mve++)
					
					@if($metaval_expl[$mve] > 0)
						@php 
							$postdata = \App\Post::find($metaval_expl[$mve]); 
						@endphp
						
						<div class="row">
					        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
<!-- 					        	<h3 class="text-center mb20"><strong>{{$postdata->post_title}}</strong></h3> -->
					        </div>
							@if(empty($postdata->featured_image))
							<div class="col-md-4 col-sm-4 col-xs-12">
							</div>
							@else
							@php
							 $info = pathinfo($postdata->featured_image);
							@endphp
								<div class="col-md-4 col-sm-4 col-xs-12">
								@if($info['extension'] == 'pdf')
									<iframe style="width:100%;" frameborder="0" allowfullscreen width="420" height="315" src="{{URL::to('/img/post/'.$postdata->featured_image)}}"></iframe>
									<!-- <a style="width:100%;"  href="{{ asset('/img/post/'.$postdata->featured_image)}}">{{$info['basename']}} </a> -->
									<a href="{{ asset('/img/post/'.$postdata->featured_image)}}" target="_blank">
										<button class="btn"><i class="fa fa-download"></i> {{$info['basename']}}</button>
									</a>
								@else
									<img style="width:100%;" src="{{URL::to('/img/post/'.$postdata->featured_image)}}" />
								@endif	
								</div>
							@endif
					        <div class="{{($postdata->featured_image) ? 'col-md-8 col-sm-8 col-xs-12' : 'col-md-12 col-sm-12 col-xs-12'}}">  
					        	{!!$postdata->post_content!!}
					        </div>
					       
					    </div>
					@endif
				@endfor
			@endif
		
	@endif
	</div>
</div>
	@endforeach
@endif
@endsection


@section('scripts')

@stop
