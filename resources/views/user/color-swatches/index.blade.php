@extends('layouts.user.app')

@section('content')

<div id="color-swatches">
	<div class="container">
	@if(session()->has('error'))
	<div class="form-message" style= "display:block">
		<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{session()->get('error')}}</div>
	</div>
	@endif
	@if(session()->has('success'))
	<div class="form-message" style= "display:block">
		<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{session()->get('success')}}</div>
	</div>
	@endif
		<div class="heading">Color Charts and Brochures</div>
		<div class="sub-heading">Browse by colour scheme</div>
		<div class="color-tab">
			<div class="tab">
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12 active" data-color="View-All-Colors">
					<div class="color-picker">
						<div class="color-box" id="view-all-colors" style="background-color:#ccc;"></div>
						<div class="ttl">View </br>All Colors</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="White">
					<div class="color-picker">
						<div class="color-box" style="background-color:#F6F7F2;"></div>
						<div class="ttl">Whites </br>& Neutrals</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Grey">
					<div class="color-picker">
						<div class="color-box" style="background-color:#373E42;"></div>
						<div class="ttl">Greys</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Brown" id="defaultOp">
					<div class="color-picker">
						<div class="color-box" style="background-color:#B39F94;"></div>
						<div class="ttl">Browns</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Purple">
					<div class="color-picker">
						<div class="color-box" style="background-color:#7E7999;"></div>
						<div class="ttl">Purples</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Blue">
					<div class="color-picker">
						<div class="color-box" style="background-color:#0045C7;"></div>
						<div class="ttl">Blue</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Green">
					<div class="color-picker">
						<div class="color-box" style="background-color:#9DBFAF;"></div>
						<div class="ttl">Greens</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Yellow">
					<div class="color-picker">
						<div class="color-box" style="background-color:#FAE196;"></div>
						<div class="ttl">Yellows</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Orange">
					<div class="color-picker">
						<div class="color-box" style="background-color:#CC5327;"></div>
						<div class="ttl">Oranges</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Red">
					<div class="color-picker">
						<div class="color-box" style="background-color:#A8312F;"></div>
						<div class="ttl">Reds</div>
					</div>
				</div>
				<div class="tablinks col-lg-1 col-md-4 col-sm-6 col-12" data-color="Regular-Colors">
					<div class="color-picker">
						<div class="color-box" id="regular-colors" style="background-color:#ccc;"></div>
						<div class="ttl">Best </br>Selling Colors</div>
					</div>
				</div>
			</div>
		</div>
		<div class="color-section row">
			<div id="White" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'white')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_off_whites))
							@foreach($cat_off_whites as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Grey" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'gray')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_gray))
							@foreach($cat_gray as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Brown" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'brown')
									<div class="color-box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_brown))
							@foreach($cat_brown as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Purple" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'violet')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_violet))
							@foreach($cat_violet as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Blue" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'blue')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_blue) )
							@foreach($cat_blue as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Green" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'green')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}"  data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_green))
							@foreach($cat_green as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Yellow" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'yellow')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_yellow))
							@foreach($cat_yellow as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Orange" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'orange')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_orange))
							@foreach($cat_orange as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Red" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if(strtolower(trim($color->attributeData->cat_color)) == 'red')
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_red))
							@foreach($cat_red as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="Regular-Colors" class=" tabcontent" style="display: none;">
				<div class="box-widget">
					<div class="color-picker row">
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)
								@if($color->attributeData->best_selling)
									<div class="color-box box" data-id="{{ $color->attributeData->id }}" data-name="{{ $color->attributeData->name }}" data-rcolor="{{ $color->attributeData->r_attr }}" data-gcolor="{{ $color->attributeData->g_attr }}" data-bcolor="{{ $color->attributeData->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@endif
							@endforeach
						@endif
						@if(!empty($cat_regColors))
							@foreach($cat_regColors as $color)
								<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">
									<div class="title">{{ $color->name }}</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>

		</div>
		<div>
			@if(isset($product_id)) 
			<form id="preselectcolor_form" action="{!! URL::action('User\ProductPageController@preselectedColors') !!}" method="post" accept-charset="UTF-8"  enctype="multipart/form-data"> 
				{!! csrf_field() !!}
				<input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">
				<button type="submit" id="multple-colors-proceed" class="btn btn-default">Select and Proceed</button>
			</form>
			@else
			<button id="proceedQuote" class="btn btn-default"><a href="{{ url('/cart') }}" >Select and Proceed</a> </button>
			@endif
		</div>
	</div>
</div>


<div id="addToCart" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><div id="colorName" style="text-transform: uppercase;"><br><br><br><br></div></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form action="{!! URL::action('User\CartController@colorSwatchesAddToCart') !!}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	  {!! csrf_field() !!}
		<div class="colorSwatches" width="100%"></div>
		<input type="hidden" id="productName" name="productName" value>
			<div class="form-group">
        <label for="product-reasearch" class="col-form-label">Product:</label>
				<select class="form-control"  id="productId" name="productId" required></select>
      </div>
			<div class="form-group">
        <label for="product-reasearch" class="col-form-label">Liters:</label>
				<select class="form-control"  id="product_liters" name="product_liters"></select>
      </div>
			<div class="form-group">
        <label for="product-reasearch" class="col-form-label">Quantity:</label>
				<input type="number"  class="form-control prod_qty numbers-only" min="1" value="1" name="quantity" required>
      </div>
    </div>
      <div class="modal-footer">
		<input type="hidden" name="colorNameP" id="colorNameP">
	  	<input type="hidden" name="colorChoose" id="colorChoose">
		<input type="hidden" name="colorCss" id="colorCss">
        <button class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">


$(document).ready(function (){

	var product_id = "@if(isset($product_id)) {{$product_id}} @endif";

	if (product_id == "") {
		$('.box').on('click', function(){
			$('#colorChoose').val($(this).data('id'));
			$('div#addToCart').modal('show');
			var rgb = "rgb("+ $(this).data('rcolor') +","+ $(this).data('gcolor') +","+ $(this).data('bcolor')+")";
			$('#colorCss').val(rgb);
			$('div#colorName').html($(this).data('name'));
			$('#colorNameP').val($(this).data('name'));
			$('.modal-header').css("background-color", rgb);
			$('.modal-body').css("background-color", rgb);
			if($('.btn-secondary').on('click') || $('.btn-primary').on('click')){
			$(this).removeClass('color-selected')
			var query = $('#colorChoose').val();
				if(query != '')
				{
				var _token = $('input[name="_token"]').val();
				$.ajax({
				url:"{{URL::to('autocomplete/fetch')}}",
				method:"POST",
				data:{query:query, _token: _token},
				success:function(data){
					$('#productId').fadeIn();  
					$('#productId').html(data);
				}
				});
				$(document).on('click', 'li', function(){  
				$('#design_code').val($(this).text());  
				$('#productId').fadeOut();  
			});  	
			}
			}
		});
	} else {
		$('#multple-colors-proceed').click(function(e) {
			e.preventDefault();
			$('.color-selected').each(function() {
				$('#preselectcolor_form').append('<input type="hidden" name="color_ids[]" class="color_id" value="'+$(this).data("id")+'">');
				$('#preselectcolor_form').append('<input type="hidden" name="color_names[]" class="color_name" value="'+$(this).data("name")+'">');
			});
			$('#preselectcolor_form').submit();
			
		})
	}

	$('#productId').on('change',function() {
		var product_id = $(this).val();
		var product_name = $('option:selected', this).text();
		var attrib_id   = $('#colorChoose').val();
		var _token     = $('input[name="_token"]').val();
		$('#productName').val(product_name);
		var send_data = {
			product_id,
			attrib_id,
			_token
		};
		$.ajax({
			url:"{{URL::to('/get-productattrib')}}",
			method:"POST",
			data: send_data,
			dataType: "json",
			success:function(data){
				console.log(data.id);
				var response = {
					prod_attr_id: data.id,
					_token
				};
				$.ajax({
					url: '/subproduct-variance',
					method: "post",
					dataType: "json",
					data: response,
					success: function (data) {        
						console.log(data);  
						if(data.status == false) {
								alert(data.msg);
						} else {
							if(data !== null && data.length !== 0) {
								$('#product_liters').html('<option value>Select Liters</option');
								$.each(data,function(key,value) {
									$('#product_liters').append(
											'<option value="' + data[key].product_id + '">' + data[key].liters + '</option>'
									);
								}); 
								$('#product_liters').unbind('change');
								$('#product_liters').on('change', function(e) {
									var product_id = $(this).val();
									var liter      = $("option:selected",this).text();
									$('.product_liters_single').val(liter);
									$.ajax({
										url: '/get-subproductdetails',
										method: "post",
										dataType: "json",
										data: {
												product_id,
												_token
										},
										success: function (data) {          
												if(data.status == false) {
														alert(data.msg);
												} else {
														if(data.quantity == 0) {
																$('.prod_qty').val(data.quantity);
																alert('Sorry! Selected Variation is out of stock! Please contact customer service for assistance!');
														} else {
																$('.prod_qty').attr('max',data.quantity);
																$('.product_price_single').val(data.price);
														}
												}
										},
										error: function(e) {
												console.log(e);
										}
									});
								});
							} else {
								$('#product_liters').parent().hide();
							}
						}
					},
					error: function (request, status, error) {
        		alert(request.responseText);
    			}
				});

			},
			error: function (request, status, error) {
        alert(request.responseText);
    	}
		});
	});
});
</script>
@endsection