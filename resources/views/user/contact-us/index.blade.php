@extends('layouts.user.app')


@section('content')

<div id ="contact-us">
	<div class="container">
		<div class="heading-box">
			<div class="desc-list">
				<div class="main-heading">VISION, MISSION AND VALUES</div>
				<div class="main-description">What we believe. This is who we are.</div>
			</div>
			<div class="desc-list">
				<div class="heading">VISION</div>
				<div class="description">To be globally recognized as the most trusted paint and coating company in the Philippines</div>
			</div>
			<div class="desc-list">
				<div class="heading">MISSION</div>
				<div class="description">To produce the best quality paint and coating products for our customers and ensure the best interest of our shareholders, business partners and community.</div>
			</div>
			<div class="desc-list">
				<div class="heading">VALUES</div>
				<div class="description"><font style="color: #dd2032; font-weight: bold;">P</font>erseverance – despite difficulty there’s a determination</div>
				<div class="description"><font style="color: #dd2032; font-weight: bold;">A</font>bove and beyond – to do much better than necessary or expected</div>
				<div class="description"><font style="color: #dd2032; font-weight: bold;">I</font>ntegrity – being honest and fair; doing the right thing even no one is watching</div>
				<div class="description"><font style="color: #dd2032; font-weight: bold;">N</font>urture – encourage growth</div>
				<div class="description"><font style="color: #dd2032; font-weight: bold;">T</font>rustworthiness – able to relied on as honest and always truthful</div>
			</div>
		</div>
			<!-- Contact Details -->
			<div class="contact-details">
				<div class="left-dtls">
					<div class="widget-box" style="background-image: url({{ url('img/icontact/emailbg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
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
					</div>
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
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.672743903757!2d121.08321201410723!3d14.6177091897916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b82226bb32ad%3A0x355a48528e7cab2f!2s53%20F.%20Pasco%20Ave%2C%20Pasig%2C%201800%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1599132791387!5m2!1sen!2sph" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
					</div>
				</div>
			</div>
			<!-- Contact Details -->
		</div>
	</div>
</div>


@endsection