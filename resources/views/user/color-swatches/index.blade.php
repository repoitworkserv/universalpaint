@extends('layouts.user.app')

@section('content')
<div id="color-swatches">
	<div class="container">
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
								@if($color->attributeData->cat_color == 'White')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Gray')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Brown')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Violet')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Blue')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Green')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}"  data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Yellow')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Orange')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == 'Red')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
								@if($color->attributeData->cat_color == '')
									<div class="color-box box col-lg-1 col-md-2 col-sm-3 col-4" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-rcolor="{{ $color->r_attr }}" data-gcolor="{{ $color->g_attr }}" data-bcolor="{{ $color->b_attr }}" data-parent-id="{{ $color->parent_id }}" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>
								@else
									@break
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
			<!-- <form action="{!! URL::action('User\CartController@addcart') !!}" method="post" accept-charset="UTF-8"  enctype="multipart/form-data"> -->
			{!! csrf_field() !!}
			<!-- <input type="hidden" name="item_quantity" id="item_quantity"> -->

			<!-- <button id="proceed" class="btn btn-default">Select and Proceed</button> -->
			<button id="proceedQuote" class="btn btn-default"><a href="{{ url('/request-a-quote') }}" >Select and Proceed</a> </button>
			<!-- </form> -->
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
	  <form action="{!! URL::action('User\CartController@coloraddtocart') !!}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	  {!! csrf_field() !!}
		<div class="colorSwatches" width="100%"></div>
		<div class="form-group">
            <label for="product-reasearch" class="col-form-label">Product:</label>
			<select class="form-control"  id="productName" name="productName"></select>
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
	$('.box').on('click', function(){
		var query = $(this).data('id'), values = [];
		console.log(query);
		$(this).toggleClass('active');
		if($(this).hasClass('active') == false){
			$(this).removeClass('color-selected');
		}
		
		$.ajax({
			url:"{{ route('autocomplete.fetch') }}",
			method:"POST",
			data:{query:query, _token: "{{ csrf_token() }}"},
			success:function(data){
			}
		});
	});	
})
</script>
@endsection