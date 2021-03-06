@extends('layouts.user.app')


@section('content')

<div id ="request-a-qoute">
{!! csrf_field() !!}
	<div class="container">
			<!-- Contact Details -->
			<div class="contact-details">
				<div class="con-dtls">
					<div class="contact-form-bx">
					  	<!-- <form action="/"> -->
						  	<div class="contact-form">
						  		<div class="heading">Request A Quote</div>
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Your Name<span>*</span></div>
									    <input type="text" id="fname" name="firstname" placeholder="Your Name Here.." required>
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Contact Number<span>*</span></div>
									    <input type="text" id="cnum" name="contactnum" placeholder="Contact Number Here.." required>
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Email Address<span>*</span></div>
									    <input type="text" id="eadd" name="em" placeholder="Email Address Here" required>
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Address<span>*</span></div>
									    <input type="text" id="add" name="em" placeholder="Complete Address Here" required>
									</div>
									<div class="box">
									<div class="box-header with-border">
									<h3 class="box-title">Products</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
									<table class="table table-bordered" id="productTable">
												<tbody>
												<tr>
														<th style="width: 10px">#</th>
														<th>Product Name</th>
														<th>Color</th>
														<th>Qty</th>
														<th>Price</th>
												</tr>
												@for ($i=0; $i < count($cart); $i++) 
														@foreach($cart[$i]['product_details'] as $key=>$index)
														@php 
														$ctr = 0;
														@endphp
														<tr>
																<td>{{++$ctr}}</td>
																<td>{{ $index['name'] }}</td>
																<td style="background-color: {{$cart[$i]['css_color']}}">{{ $cart[$i]['color_name'] }}</td>
																@php
																$totalprice = $index['is_sale'] ? $index['sale_price'] * $index['qty'] : $index['price'] * $index['qty'];
																@endphp
																<td>{{$index['qty']}}</td>
																<td>{{ $totalprice }} </td>
														</tr>
														@endforeach
												@endfor
											</tbody>
										</table>
									</div>
									<!-- /.box-body -->
									<div class="box-footer clearfix">

									</div>
								</div>
								</div>
								<div class="btn button-bx send-request" style="background-color: #94978c; color: white">Send Now</div>
							</div>
					  	<!-- </form> -->
					</div>
				</div>
				<!-- <div class="con-dtls">
					<div class="contact-form-bx">
					  	<form action="/">
						  	<div class="contact-form">
						  		<div class="heading">Request for callback or estimate</div>
							  	<div class="c-form">
							  		<div class="widget-box">
									    <div class="label-top">Your Name<span>*</span></div>
									    <input type="text" id="fname2" name="firstname2" placeholder="Your Name Here..">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Email Address<span>*</span></div>
									    <input type="text" id="eadd2" name="eadd2" placeholder="Email Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Complete Project Address<span>*</span></div>
									    <input type="text" id="add2" name="add2" placeholder="Complete Project Address Here">
									</div>
							  		<div class="widget-box">
									    <div class="label-top">Preferred Date Of Visit or Call<span>*</span></div>
									    <input type="text" id="cnum2" name="cnum2" placeholder="Date of Visit">
									</div>
								</div>
								<div class="button-bx"><input type="submit" value="Send Now"></div>
							</div>
					  	</form>
					</div>
				</div> -->
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
						<div class="desc"><b>Tel.</b>(+632) 8997 8777</br> (+632) 8646 8801 </br> (+632) 8646 8701</br> (+632) 8646 3571 </br> (+632) 8646 8967 </br> <b>Mobile</b> +63917 106 4579 </br><b>Fax</b> +632 8646 8329</div>
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

@section('scripts')
<script type="text/javascript">

$(document).ready(function (){
	$('.send-request').on('click', function(){
		var _token = $('input[name="_token"]').val(),
		name = $('#fname').val(),cnum = $('#cnum').val(),eadd = $('#eadd').val();
		$.ajax({
		url:"{{ route('sendmail.quote') }}",
		method:"POST",
		data:{ name:name,cnum:cnum,eadd:eadd, _token},
		beforeSend: function() {
			alert('Please wait....');
		},
		success:function(data){
			alert(data);
			setTimeout(function(){ window.location = '/'; }, 2000);
		},error: function(xhr, status, error) {
  		console.log(xhr.responseText);
			console.log(error);
		}
		});
	});
})
</script>
@endsection