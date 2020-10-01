@extends('layouts.user.app')

@section('content')
<div id="color-swatches">
	<div class="container">
        <div class="heading">Color Chats and brochures</div>
        <div class="sub-heading">Browse by colour scheme</div>
		<div class ="color-tab">
			<div class="tab">
			  <div class="tablinks" data-color="White">
	          <div class="color-picker">
	            <div class="color-box" style="background-color:#F6F7F2;"></div>
	            <div class="ttl">Whites </br>& Neutrals</div>
	          </div>
			  </div>
			  <div class="tablinks" data-color="Grey">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#373E42;"></div>
		            <div class="ttl">Greys</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Brown" id="defaultOp">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#B39F94;"></div>
		            <div class="ttl">Browns</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Purple">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#7E7999;"></div>
		            <div class="ttl">Purples</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Blue">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#29436E;"></div>
		            <div class="ttl">Blue</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Green">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#9DBFAF;"></div>
		            <div class="ttl">Greens</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Yellow">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#FAE196;"></div>
		            <div class="ttl">Yellows</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Orange">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#CC5327;"></div>
		            <div class="ttl">Oranges</div>
		          </div>
			  </div>
			  <div class="tablinks" data-color="Red">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#A8312F;"></div>
		            <div class="ttl">Reds</div>
		          </div>
			  </div>
			</div>
		</div>
		<div class="color-section">
			<div id="White" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">						
						@if(!empty($cat_off_whites))
							@foreach($cat_off_whites as $color)
							<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
								<div class="title">{{ $color->name }}</div>
							</div>						
							@endforeach
						@endif               
					</div>
				</div>
			</div>
			<div id="Grey" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_gray))
								@foreach($cat_gray as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
									<div class="title">{{ $color->name }}</div>
								</div>						
								@endforeach
							@endif
					</div>
				</div>
			</div>
			<div id="Brown" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_brown))
								@foreach($cat_brown as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
									<div class="title">{{ $color->name }}</div>
								</div>						
								@endforeach
							@endif
					</div>
				</div>
			</div>
			<div id="Purple" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_violet))
								@foreach($cat_violet as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
									<div class="title">{{ $color->name }}</div>
								</div>						
								@endforeach
							@endif
					</div>
				</div>
			</div>
			<div id="Blue" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
						@php 						
						@endphp
						@if(!empty($productAttributes))
							@foreach($productAttributes as $color)								
								@if($color->attributeData->cat_color == 'Blue')																
									<div class="color-box" data-product-id="{{ $color->product_id }}" style="background-color:rgb({{ $color->attributeData->r_attr }}, {{ $color->attributeData->g_attr }}, {{ $color->attributeData->b_attr }} );">							
										<div class="title">{{ $color->attributeData->name }}</div>
									</div>			
								@else
									@break									
								@endif
							@endforeach
						@endif
						@if(!empty($cat_blue) )			
							@foreach($cat_blue as $color)
							<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
								<div class="title">{{ $color->name }}</div>
							</div>						
							@endforeach
						@endif		            
					</div>
				</div>
			</div>
			<div id="Green" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
						@if(!empty($cat_green))							
							@foreach($cat_green as $color)
							<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
								<div class="title">{{ $color->name }}</div>
							</div>						
							@endforeach
						@endif		                
		          </div>
				</div>
			</div>
			<div id="Yellow" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_yellow))
								@foreach($cat_yellow as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
									<div class="title">{{ $color->name }}</div>
								</div>						
								@endforeach
							@endif 
					</div>
		        </div>
			</div>
			<div id="Orange" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_orange))
								@foreach($cat_orange as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
									<div class="title">{{ $color->name }}</div>
								</div>						
								@endforeach
							@endif 
					</div>
		        </div>
			</div>
			<div id="Red" class="tabcontent">
				<div class="box-widget">
					<div class="color-picker">
							@if(!empty($cat_red))
								@foreach($cat_red as $color)
								<div class="color-box" style="background-color:rgb({{ $color->r_attr }}, {{ $color->g_attr }}, {{ $color->b_attr }} );">							
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

			<button id="proceed" class="btn btn-default">Select and Proceed</button>	
		<!-- </form> -->
		</div>
	</div>
</div>
@endsection