@extends('layouts.user.app')


@section('content')

@php
$contact_us_post = \App\Post::where('post_name','contact_us')->orWhere('post_title','Contact Us')->first();
@endphp
@if(!empty($contact_us_post))
<div id ="contact-us">
	<div class="container">
		<div class="heading-box">
			{!! $contact_us_post->post_content !!}
		</div>
			<!-- Contact Details -->
			<div class="contact-details">
				<div class="left-dtls">
				@php
				$postmeta_values = "";
				$postmetadata = \App\PostMetaData::where('source_id',$contact_us_post->id)->where('meta_key','contact_us_post')->first();
				@endphp
				@if(!empty($postmetadata))
				@php  
				$postmeta_values = $postmetadata->meta_value;
				$posts = explode(',',$postmetadata->meta_value);
				@endphp
				@foreach($posts as $post)
				@php 
				$post_data = \App\Post::find($post);
				@endphp 
				@if(!empty($post_data))
					<div class="widget-box" style="background-image: url({{ url('img/post/'.$post_data->featured_banner) }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/post/'.$post_data->featured_image) }}"></div>
						@if($post_data->displayed_title)
						<div class="title">{{$post_data->post_title}}</div>
						@endif
						@if($post_data->displayed_post_content)
						<div class="desc">{!!$post_data->post_content!!}</div>
						@endif
					</div>
					@endif
					@endforeach
					@endif
					<!-- <div class="widget-box" style="background-image: url({{ url('img/icontact/emailbg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/mailicon.png') }}"></div>
						<div class="title">Email Address</div>
						<div class="desc">sales@universalpaint.net</div>
					</div>
					<div class="widget-box" style="background-image: url({{ url('img/icontact/phonebg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/phoneicon.png') }}"></div>
						<div class="title">Call Us</div>
						<div class="desc"><b>Tel.</b>(+632) 8997 8777</br> (+632) 8646 8801 </br> (+632) 8646 8701, (+632) 8646 3571 </br> (+632) 8646 8967</br> <b>Mobile</b> +63917 106 4579 </br><b>Fax</b> +632 8646 8329</div>
					</div>
					<div class="widget-box" style="background-image: url({{ url('img/icontact/locbg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/locicon.png') }}"></div>
						<div class="title">Our Location</div>
						<div class="desc">53 F. Pasco Ave, Brgy. Santolan, Pasig City. Metro Manila, Philippines 1610</div>
					</div> -->
				</div>
				<div class="right-dtls">
					<div class="contact-form-bx">
					  	<form action="/">
						  	<div class="contact-form">
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Your Name<span>*</span></div>
									    <input type="text" id="fname" name="firstname" placeholder="Your Name Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Email Address<span>*</span></div>
									    <input type="text" id="eadd" name="em" placeholder="Email Address Here">
									</div>
								</div>
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Contact Number<span>*</span></div>
									    <input type="text" id="cnum" name="contactnum" placeholder="Contact Number Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Subject<span>*</span></div>
									    <input type="text" id="subj" name="subj" placeholder="Inquiry Subject Here">
									</div>
								</div>
								<div class="c-form-bg">
							  		<div class="widget-box">
									    <div class="label-top">Message / Inquiries<span>*</span></div>
									    <textarea id="subject" name="subject" placeholder="Messsage or Inquiries Here"></textarea>
									</div>
								</div>
								<div class="button-bx"><input type="submit" value="Send Now"></div>
							</div>
					  	</form>
					</div>
					<div class="maps">
						<iframe src="{{$contact_us_post->button_link}}" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
					</div>
				</div>
			</div>
			<!-- Contact Details -->
		</div>
	</div>
</div>
@endif


@endsection