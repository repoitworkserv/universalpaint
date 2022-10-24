@extends('layouts.user.app')



@section('content')

<link href="http://localhost:8000/static/bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />

<style>
	.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
			background-color: #dd2032;
			border-color: #dd2032;
	}
</style>

<script src="{{asset('/vendor/download/download.min.js')}}"></script>

<div id="brochures">
	@php 
	$subheading = \App\ProductBrochuresContent::where('component','subheading')->first();
	$brochures = \App\ProductBrochure::paginate(10);
	@endphp
	{!! csrf_field() !!}
	<div class="brochures_herodrop" style="background-image: url(https://universalpaint.net/img/banner-brochures-min.png); background-size: cover; background-repeat: no-repeat; background-position: center center;">

		<div class="container">

			<div class="herodrop-txt">

				<p class="herodrop-txt_ttl">PRODUCT BROCHURES</p>

				<div class="herodrop-txt_desc">@if($subheading){!! $subheading->content !!}@endif</div>

			</div>			

		</div>

	</div>

	<div class="brochures_body">

		<div class="container">

			<div class="contain-brochures">

				@forelse($brochures as $item)

				<div class="brochure_solo">

					<div class="brochure_solo-img" style="background-image: url({{asset('/images/brochures/'.$item->brochure_image)}}); background-size: cover; background-repeat: no-repeat; background-position: center center;"></div>

					<p class="brochure_solo-ttl">{{$item->brochure_title}}</p>					

					<a href="#" class="brochure_solo-link" data-title="{{$item->brochure_file}}" data-file="{{asset('/images/brochures/files/'.$item->brochure_file)}}">DOWNLOAD</a>

				</div>

				@empty
				<h1>No Brochure Available at this moment...</h1>

				@endforelse

			</div>
			<div style="display:flex; justify-content: center">
				{{ $brochures->links() }}
			</div>

		</div>

	</div>

	<div class="brochures_popup" style="display:none">

		<div class="container">

			<div class="contain-popup">

				<img class="popup_img" src="{{asset('/img/popup-logo.png')}}"/>

				<div class="popup_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</div>

				<div class="popup_form">
					<form id="sendDetailsForm" action="{{ URL::action('Admin\PageController@add_contact_us_post') }}" method="post"  accept-charset="UTF-8">
						<input type="hidden" id="brochure_file" name="brochure_file" value="" />
			  		<div class="form-entry">
					    <div class="label-top">YOUR NAME<span>*</span></div>
					    <input type="text" id="fname" name="fname" placeholder="Your Name Here">

						</div>
			  		<div class="form-entry">
					    <div class="label-top">CONTACT NUMBER<span>*</span></div>
					    <input type="text" id="mobilenum" name="mobilenum" placeholder="Contact Number">

						</div>
			  		<div class="form-entry">
					    <div class="label-top">EMAIL ADDRESS<span>*</span></div>
					    <input type="text" id="eadd" name="eadd" placeholder="Email Address">
						</div>
						<div class="form-entry"><button id="sendDetailsBtn" type="submit">SEND</button></div>
					</form>

				</div>

				<img class="popup_close" src="{{asset('/img/popup-close.png')}}"/>

			</div>

		</div>

	</div>

</div>

@endsection

@section('scripts')
<script type="text/javascript">

	$(function() {

			function getCookie(name) {
				let cookie = {};
				document.cookie.split(';').forEach(function(el) {
					let [k,v] = el.split('=');
					cookie[k.trim()] = v;
				})
				return cookie[name];
			}

			function setCookie(name,value,days) {
					var expires = "";
					if (days) {
							var date = new Date();
							date.setTime(date.getTime() + (days*24*60*60*1000));
							expires = "; expires=" + date.toUTCString();
					}
					document.cookie = name + "=" + (value || "")  + expires + "; path=/";
			}

	    $("#brochures .brochures_popup img.popup_close").click(function(){

	    	$("#brochures .brochures_popup").css("display", "none");

	    });

			$('.brochure_solo-link').click(function() {

				var file = $(this).data('file');

				if (typeof getCookie('data_submitted') === 'undefined') {
					$("#brochures .brochures_popup").css("display", "flex");
					$('#brochure_image').val(file);
				} else {
					download(file); 
				}
			});

			$('#sendDetailsBtn').click(function(e) {
					e.preventDefault();
					var file = $('#brochure_file').val();
					var fname = $('#fname').val();
					var num   = $('#mobilenum').val();
					var eadd  = $('#eadd').val();
					var _token = $('input[name="_token"]').val();

					if(fname !== "" && num !== "" && eadd !== "") {
						$.ajax({
							url: '/product-brochures/email',
							method: 'post',
							dataType: "json",
							data: {_token, fname, num, eadd },
							success: function (data) {    
								setCookie('data_submitted',true,20*365);
								download(file);
								$("#brochures .brochures_popup").css("display", "none");
							}
						});
					} else {
						alert('Complete all the fields to download selected brochure!');
					}
			});

	});

</script>
@stop