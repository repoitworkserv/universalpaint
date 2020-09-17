@extends('layouts.user.app')


@section('content')

<div id ="request-a-qoute">
	<div class="container">
			<!-- Contact Details -->
			<div class="contact-details">
				<div class="con-dtls">
					<div class="contact-form-bx">
					  	<form action="/">
						  	<div class="contact-form">
						  		<div class="heading">Request A Qoute</div>
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Your Name<span>*</span></div>
									    <input type="text" id="fname" name="firstname" placeholder="Your Name Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Contact Number<span>*</span></div>
									    <input type="text" id="cnum" name="contactnum" placeholder="Contact Number Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Email Address<span>*</span></div>
									    <input type="text" id="eadd" name="em" placeholder="Email Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Address<span>*</span></div>
									    <input type="text" id="add" name="em" placeholder="Complete Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Product<span>*</span></div>
									    <input type="text" id="prod" name="prod" placeholder="Product Name">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Quantity<span>*</span></div>
									    <input type="text" id="qty" name="qty" placeholder="QTY">
									</div>
								</div>
								<div class="button-bx"><input type="submit" value="Send Now"></div>
							</div>
					  	</form>
					</div>
				</div>
				<div class="con-dtls">
					<div class="contact-form-bx">
					  	<form action="/">
						  	<div class="contact-form">
						  		<div class="heading">Request for callback or estimate</div>
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Your Name<span>*</span></div>
									    <input type="text" id="fname" name="firstname" placeholder="Your Name Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Email Address<span>*</span></div>
									    <input type="text" id="eadd" name="em" placeholder="Email Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Complete Project Address<span>*</span></div>
									    <input type="text" id="add" name="em" placeholder="Complete Project Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Preferred Date Of Visit or Call<span>*</span></div>
									    <input type="text" id="cnum" name="contactnum" placeholder="Date of Visit">
									</div>
								</div>
								<div class="button-bx"><input type="submit" value="Send Now"></div>
							</div>
					  	</form>
					</div>
				</div>
			</div>
			<!-- Contact Details -->
				<div class="bot-dtls">
					<div class="widget-box" style="background-image: url({{ url('img/icontact/emailbg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/mailicon.png') }}"></div>
						<div class="title">Email Address</div>
						<div class="desc">sales@universalpaint.net</div>
					</div>
					<div class="widget-box" style="background-image: url({{ url('img/icontact/phonebg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/phoneicon.png') }}"></div>
						<div class="title">Call Us</div>
						<div class="desc"><b>Tel.</b>+632 8646 8701, +632 8646 3571 </br> +632 8646 896 </br> <b>Mobile</b> +63917 106 4579 </br><b>Fax</b> +632 8646 8329</div>
					</div>
					<div class="widget-box" style="background-image: url({{ url('img/icontact/locbg.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center left;">
						<div class="icon"><img src="{{ url('img/icontact/locicon.png') }}"></div>
						<div class="title">Our Location</div>
						<div class="desc">53 F. Pasco Ave, Brgy. Santolan, Pasig City. Metro Manila, Philippines 1610</div>
					</div>
				</div>
		</div>
	</div>
</div>


@endsection