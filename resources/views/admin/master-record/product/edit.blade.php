@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	
	
	  <section class="content-header">
	    <h1>
	      Product
	    </h1>
	
	    @if (session('status'))
	    	@php
	    	$class = (session('status') == 'success' ? 'success' : 'danger' );
	    	@endphp
	        <br>
	        <div class="alert alert-{{$class}}">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('msg') }}
	        </div>
	    @endif
	    
	
	  </section>
	  <section class="content">
      <div class="row">
      	<form id="create_product_form" action="{{ URL::action('Admin\ProductController@update', [$productdetails->id]) }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data">
        <div class="col-md-7 col-sm-7 col-xs-12">
          <div class="box box-gold">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-plus-circle"></i> Edit Product </h3>
            </div>



        <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">

                <div class="row">
                	
                  <div class="col-md-12 col-sm-12 col-xs-12">
					@php
						$promo_start_var = date('m/d/Y', strtotime($productdetails->promo_start));
						$promo_end_var = date('m/d/Y', strtotime($productdetails->promo_start));
						
						$promo_start = ($promo_start_var == '01/01/1970') ? '' : $promo_start_var;
						$promo_end = ($promo_end_var == '01/01/1970') ? '' : $promo_end_var;
					@endphp
                    
                			{!! csrf_field() !!}
                			<div class="row">
                				<div class="col-md-6 col-sm-6 col-xs-12">
                					<div class="form-group">
		            					<label for="prodcode">Product Code</label>
		            					<input id="prodcode" name="prodcode" class="form-control" type="text" required value="{{$productdetails->product_code}}">
						            </div>
						       </div>
                				<div class="col-md-6 col-sm-6 col-xs-12">
                					<div class="form-group">
		            					<label for="prodname">Brand Name</label>
		            					<select class="form-control" name="prod_brandname" required>
		            						<option>--- Select Brand ---</option>
		            						@foreach($brandlist as $bl)
							            		<option {{($productdetails->brand_id  == $bl->id) ? 'selected' : ''}} required value="{{$bl->id}}">{{$bl->name}}</option>
							            	@endforeach
		            					</select>
						            </div>
						        </div>
                			</div>
                			<div class="form-group">
            					 <div class="form-group">
	            					<label for="prodname">Product Name</label>
	            					<input id="prodname" name="prodname" class="form-control" type="text" required value="{{$productdetails->name}}">
					            </div>
				            </div>														
								@php
									$interior_checked = '';
									$exterior_checked = '';
									$surface_preparation_checked = '';
									$industrial_checked = '';
								@endphp	

									@if($productdetails->interior == 1)										
										@php
											$interior_checked = 'checked';
										@endphp	
									@elseif($productdetails->exterior == 1)										
										@php
											$exterior_checked = 'checked';
										@endphp	
									@elseif($productdetails->surface_preparation == 1)	
										@php
											$surface_preparation_checked = 'checked';
										@endphp	
									@elseif($productdetails->industrial == 1)
										@php
											$industrial_checked = 'checked';
										@endphp	
									@endif
																
							<div class="form-group">
								<label for="prodname">Product Parent Category</label><br />
								<div class="row">
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input type="checkbox" {{$interior_checked}} name="interior" value="1" ><strong for="prodname">Interior</strong>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input type="checkbox" {{$exterior_checked}} name="exterior" value="1" ><strong for="prodname">Exterior</strong>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input type="checkbox" {{$surface_preparation_checked}} name="surface_preparation" value="1" ><strong for="prodname">Surface Preparation Product</strong>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input type="checkbox" {{$industrial_checked}} name="industrial" value="1" ><strong for="prodname">Industrial Paint</strong>
									</div>
								</div>								
							</div>
							
		                	<div class="form-group">
            					<label for="prodname">Product Category</label><br />
            					<div class="row">
	            					@foreach($categorylist as $cl)
	            					@php
	            						$is_checked = '';
	            					@endphp
	            					<div class="col-md-3 col-sm-6 col-xs-12">
	            						@foreach($productcategory as $pd)
		            						@if($pd->category_id == $cl->id)
		            							@php
				            						$is_checked = 'checked';
				            						break;
				            					@endphp
		            						@endif
	            							
	            							
	            						@endforeach
	            						<input type="checkbox" {{$is_checked}} name="categorylist[]" value="{{$cl->id}}" /> <strong>{{$cl->name}}</strong> 
	            					</div>
						            	@endforeach
	            					<!--select class="form-control" name="prod_category">
	            						<option value="0">--- Select Brand ---</option>
	            						@foreach($categorylist as $cl)
						            		<option value="{{$cl->id}}">{{$cl->name}}</option>
						            	@endforeach
	            					</select-->
            					</div>
				            </div>
				            <div class="form-group">
            					<label for="proddesc">Product Description</label>
            					<textarea name="proddesc" class="form-control proddesc" rows="5" required id="proddesc">{{$productdetails->description}}</textarea>
				            </div>
				            <div class="row mb20">
				            	<div class="col-md-12 col-sm-12 col-xs-12">
				            		<label for="variable_name">Product Type</label>
				            	</div>
				            	@foreach($product_type as $pt =>$p)
				            		<div class="col-md-2 col-sm-3 col-xs-12">
	                					<input type="radio" {{$productdetails->product_type == $pt ? 'checked' : ''}} name="product_type" class="prodtype" value="{{$pt}}" /> {{$p}}
	                				</div>
				            	@endforeach
                			</div>
                			<div class="row">
                				<div class="product_other_details">
                					<div class="single_product" style="{{$productdetails->product_type == 'single' ? 'display:inline;' : ''}}">
                						<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="prodqty">Quantity</label>
				            					<input id="prodqty" name="single_product_qty" class="form-control" type="text"  value="{{$productdetails->quantity}}">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12 price_div">
                							<div class="form-group">
				            					<label for="prodprice">Price</label>
				            					<input id="prodprice" name="single_product_price" class="form-control trig_saleprice" type="text"  value="{{$productdetails->price}}">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
                							<div class="form-group">
				            					<label for="proddscnt">Discount</label>
				            					<input id="proddscnt" name="single_product_dscnt" class="form-control trig_saleprice1" type="text"  value="{{$productdetails->discount}}">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
                							<div class="form-group">
				            					<label for="proddscnt_type">Discount Type</label>
				            					<select id="proddscnt_type" name="single_product_dscnt_type" class="form-control">
				            						@foreach($discount_type as $dt =>$dt_val)
				            							<option {{($productdetails->discount_type == $dt) ? 'selected' : ''}} value="{{$dt}}">{{$dt_val}}</option>
				            						@endforeach
				            					</select>
								            </div>
                						</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="where_to_use">Where to use</label>
												<input id="where_to_use" name="single_where_to_use" required class="form-control" type="text"  value="{{$productdetails->where_to_use}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="area">Area</label>
												<input id="area" name="single_area" required class="form-control" type="text"  value="{{$productdetails->area}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="best_used_for">Best Used For</label>
												<input id="best_used_for" name="single_best_used_for" required class="form-control" type="text"  value="{{$productdetails->best_used_for}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="features">Features</label>
												<input id="features" name="single_features" required class="form-control" type="text"  value="{{$productdetails->features}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="coverage">Coverage per 4L</label>
												<input id="coverage" name="single_coverage" required class="form-control" type="text"  value="{{$productdetails->coverage}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="finish">Finish</label>
												<input id="finish" name="single_finish" required class="form-control" type="text"  value="{{$productdetails->finish}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="application">Application</label>
												<input id="application" name="single_application" required class="form-control" type="text"  value="{{$productdetails->application}}">
											</div>
										</div>
										<div class="col-md-3 col-sm-3 col-sm-12">
											<div class="form-group">
												<label for="packaging">Packaging</label>
												<input id="packaging" name="single_packaging" required class="form-control" type="text"  value="{{$productdetails->packaging}}">
											</div>
										</div>
                						<div class="col-md-3 col-sm-3 col-sm-12 saleprice_div">
                							<div class="form-group">
				            					<label for="prodsaleprice">Sale Price</label>
				            					<input id="prodsaleprice" name="single_product_saleprice" class="form-control" type="text" readonly="readonly"  value="{{$productdetails->sale_price}}">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="prodissale">Is Sale?</label>
				            					<input id="prodissale" name="single_product_issale" class="" type="checkbox" {{ ($productdetails->is_sale == 1) ? 'checked' : '' }}  value="1">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="prodpromofrom">Promotion From</label>
				            					<input id="prodpromofrom" name="single_product_promofrom" class="form-control datepick3r" type="text"  value="{{$promo_start}}">
								            </div>
                						</div>
                						<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="prodpromoto">Promotion To</label>
				            					<input id="prodpromoto" name="single_product_promoto" class="form-control datepick3r" type="text"  value="{{$promo_end}}">
								            </div>
                						</div>
                						<div class="col-md-12 col-sm-12 col-sm-12">
                							<div class="form-group">
				            					<label>Shipping Details</label>
				            				</div>
				            			</div>
				            			<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="shipping_width">Width</label>
				            					<input id="shipping_width" name="single_shipping_width" class="form-control" type="text"  value="{{$productdetails->shipping_width}}">
				            				</div>
				            			</div>
				            			<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="shipping_length">Length</label>
				            					<input id="shipping_length" name="single_shipping_length" class="form-control" type="text"  value="{{$productdetails->shipping_length}}">
				            				</div>
				            			</div>
				            			<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="shipping_weight">Weight</label>
				            					<input id="shipping_weight" name="single_shipping_weight" class="form-control" type="text"  value="{{$productdetails->shipping_weight}}">
				            				</div>
				            			</div>
				            			<div class="col-md-3 col-sm-3 col-sm-12">
                							<div class="form-group">
				            					<label for="shipping_height">Height</label>
				            					<input id="shipping_height" name="single_shipping_height" class="form-control" type="text"  value="{{$productdetails->shipping_height}}">
				            				</div>
				            			</div>
				            			<div class="col-md-4 col-sm-4 col-sm-12">
				            				<div class="form-group">
				            					<label for="single_keywords" style="width:100%;">Keywords or Tags</label>
				            					<input id="single_keywords" name="single_keywords"  data-role="tagsinput"  class="form-control" type="text"  value="{{$productdetails->keywords}}">
				            				</div>
				            			</div>
				            			<div class="col-md-8 col-sm-8 col-sm-12">
                							<div class="form-group">
				            					<!--label >Upload Image</label>
				            					<div class="btn btn-app btnupload">
				            						<input name="upload_image" class="form-control upload_image" type="file"  value="{{ !empty($productdetails->featured_image) ? asset('img/'.$productdetails->featured_image) : '' }}">
				            						<i class="fa fa-upload"></i>  Upload Here!
				            					</div-->
				            				
					            				<div class="col-md-3">
	            									<label for="upload_image">Upload Image</label><br/>
	            									<div class="btn btn-app btnupload">
					            						<input name="upload_image" class="form-control upload_image" type="file" value="{{ !empty($productdetails->featured_image) ? asset('img/products/'.$productdetails->featured_image) : '' }}">
					            						<i class="fa fa-upload"></i>  Upload Here!
					            					</div>
	            								</div>
	            								<div class="col-md-6">
	            									<div class="preview_image">
				            							<span class="img_prev_wrap">
				            								<span class="remove" style="position: absolute;"><i class="fa fa-trash"></i></span>
				            								<img class="imageThumb" style="width:100%;border:solid 1px #000;" src="{{ !empty($productdetails->featured_image) ? asset('img/products/'.$productdetails->featured_image) : '' }}" />
				            							</span>
				            							
				            						</div>
	            								</div>
            								</div>
				            			</div>
                					</div>
                					<div class="multiple_product" style="{{$productdetails->product_type == 'multiple' ? 'display:inline;' : ''}}">
                						
                						<div class="variable_section">
                							<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="prodqty">Quantity</label>
					            					<input id="prodqty" name="parent_product_qty" class="form-control" type="text"  value="{{$productdetails->quantity}}">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12 price_div">
	                							<div class="form-group">
					            					<label for="prodprice">Price</label>
					            					<input id="prodprice" name="parent_product_price" class="form-control" type="text"  value="{{$productdetails->price}}">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
	                							<div class="form-group">
					            					<label for="parent_proddscnt">Discount</label>
					            					<input id="parent_proddscnt" name="parent_product_dscnt" class="form-control trig_saleprice" type="text"  value="{{$productdetails->discount}}">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
	                							<div class="form-group">
					            					<label for="parent_proddscnt_type">Discount Type</label>
					            					<select id="parent_proddscnt_type" name="parent_product_dscnt_type" class="form-control trig_saleprice1">
					            						@foreach($discount_type as $dt =>$dt_val)
					            							<option {{($productdetails->discount_type == $dt) ? 'selected' : ''}} value="{{$dt}}">{{$dt_val}}</option>
					            						@endforeach
					            					</select>
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12 saleprice_div">
	                							<div class="form-group">
					            					<label for="prodsaleprice">Sale Price</label>
					            					<input id="prodsaleprice" name="parent_product_saleprice" class="form-control" type="text" readonly="readonly"  value="{{$productdetails->sale_price}}">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="prodissale">Is Sale?</label>
					            					<input id="prodissale" name="parent_product_issale" class="" type="checkbox"  {{ ($productdetails->is_sale == 1) ? 'checked' : '' }} value="1">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="prodpromofrom">Promotion From</label>
					            					<input id="prodpromofrom" name="parent_product_promofrom" class="form-control datepick3r" type="text"  value="{{$promo_start}}">
									            </div>
	                						</div>
	                						<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="prodpromoto">Promotion To</label>
					            					<input id="prodpromoto" name="parent_product_promoto" class="form-control datepick3r" type="text"  value="{{$promo_end}}">
									            </div>
	                						</div>
	                						<div class="col-md-12 col-sm-12 col-sm-12">
	                							<div class="form-group">
					            					<label>Shipping Details</label>
					            				</div>
					            			</div>
					            			<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="shipping_width">Width</label>
					            					<input  name="parent_shipping_width" class="form-control" type="text"  value="{{$productdetails->shipping_width}}">
					            				</div>
					            			</div>
					            			<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="shipping_length">Length</label>
					            					<input  name="parent_shipping_length" class="form-control" type="text"  value="{{$productdetails->shipping_length}}">
					            				</div>
					            			</div>
					            			<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="shipping_weight">Weight</label>
					            					<input  name="parent_shipping_weight" class="form-control" type="text"  value="{{$productdetails->shipping_weight}}">
					            				</div>
					            			</div>
					            			<div class="col-md-3 col-sm-3 col-sm-12">
	                							<div class="form-group">
					            					<label for="shipping_height">Height</label>
					            					<input  name="parent_shipping_height" class="form-control" type="text"  value="{{$productdetails->shipping_height}}">
					            				</div>
					            			</div>
					            			<div class="col-md-4 col-sm-4 col-sm-12">
					            				<div class="form-group">
					            					<label for="single_keywords" style="width:100%;">Keywords or Tags</label>
					            					<input  name="parent_keywords"  data-role="tagsinput"  class="form-control" type="text"  value="{{$productdetails->keywords}}">
					            				</div>
					            			</div>
					            			<div class="col-md-8 col-sm-8 col-sm-12">
	                							<div class="form-group upl_img">
	                								<div class="col-md-3">
	                									<label for="upload_image">Upload Image</label><br/>
	                									<div class="btn btn-app btnupload">
						            						<input name="parent_upload_image" class="form-control upload_image" type="file" value="{{ !empty($productdetails->featured_image) ? asset('img/products/'.$productdetails->featured_image) : '' }}">
						            						<i class="fa fa-upload"></i>  Upload Here!
						            					</div>
	                								</div>
	                								<div class="col-md-6">
	                									<div class="preview_image">
					            							<span class="img_prev_wrap">
					            								<span class="remove" style="position: absolute;"><i class="fa fa-trash"></i></span>
					            								<img class="imageThumb" style="width:100%;border:solid 1px #000;" src="{{ !empty($productdetails->featured_image) ? asset('img/products/'.$productdetails->featured_image) : '' }}" />
					            							</span>
					            						
					            						</div>
	                								</div>
					            				</div>
					            			</div>
                							<div class="col-md-12 col-sm-12 col-sm-12">
	                							<div class="form-group">
					            					<label>Select Variable</label>
					            				</div>
					            			</div>
					            			<div class="col-md-12 col-sm-12 col-sm-12">
					            				@foreach($variablelist as $vl)
					            					@php
					            						$is_checked = '';
					            					@endphp
					            					@foreach($productvariable as $pv)
					            						@if($pv->variable_id == $vl->id)
					            							@php
							            						$is_checked = 'checked';
							            						break;
							            					@endphp
					            						@endif
				            						@endforeach
					            				<div class="col-md-2 col-sm-2 col-xs-12">
					            					<div class="form-group">
					            						<input type="checkbox" class="variable_opt" {{$is_checked}} name="variable_opt_arr[]" value="{{$vl->id}}" /> <strong>{{$vl->name}}</strong>
					            					</div>
					            				</div>
	                							@endforeach
					            			</div>
					            			<div class="col-md-12 col-sm-12 col-sm-12 text-right">
	                							<div class="form-group">
					            					<div class="btn btn-gold variable_next"  style="display:none;">
					            						Next
					            					</div>
					            				</div>
					            			</div>
                						</div>
                						<div class="variation_section" style="display:{{($productdetails->product_type == 'multiple') && ($subproduct->count() > 0) ? 'inline' : 'none'}};">
                							<div class="col-md-12 col-sm-12 col-sm-12">
	                							<div class="form-group">
					            					<label>Create Variation <span><a class="badge bg-orange add_variation" href="#" data-reccounter = "{{($subproduct->count()+1 )}}"><i class="	fa fa-plus"></i> Add Variation</a></span></label>
					            				</div>
					            			</div>
					            			<div class="col-md-12 col-sm-12 col-sm-12 text-center">
	                							<table class="table table-striped table-condensed" style="border-collapse:collapse;">
								                    <thead>
									                    <tr role="row" id="variation_tbl_header">
									                      <!--th>Color</th>
									                      <th>Size</th>
									                       <th></th-->
									                    </tr>
								                    </thead>
													<tbody id="variation_tbl_body">
														@php
															$sp_count = 1;
														@endphp
														
														@foreach($subproduct as $sp)
															@php
																$promo_start_var = date('m/d/Y', strtotime($sp->promo_start));
																$promo_end_var = date('m/d/Y', strtotime($sp->promo_start));
																$sp_promo_start = ($promo_start_var == '01/01/1970') ? '' : $promo_start_var;
																$sp_promo_end = ($promo_end_var == '01/01/1970') ? '' : $promo_end_var;
																
															@endphp
														
														<tr class="activeRow"  id="variation_Row{{$sp_count}}">
															@foreach($productvariable as $pv)
																@foreach($variablelist as $vl)
																	@if($pv->variable_id == $vl->id)
																		<td>
																			<select name="variation_attributes[]" class="form-control">
											                        			<!--option value="0">Any {{$vl->name}}</option-->
											                        			@foreach($vl->AttributeData as $attr)
											                        				@php
											                        					$selected = '';
											                        				@endphp
											                        				@foreach($sp->ProductAttributeData as $pad)
											                        					@if($pad->attribute_id == $attr->id)
											                        						@php
											                        							$selected = 'selected';
											                        							break;
											                        						@endphp
											                        					@endif
											                        				@endforeach
											                        				<option {{$selected}} value="{{$attr->id}}">{{$attr->name}}</option>
											                        			@endforeach
											                        		</select>
											                        	</td>
											                        	@php
											                        		break;
											                        	@endphp
										                        	@endif
									                        	@endforeach
								                        	@endforeach
								                        	<td class="text-left">
								                        		<a class="badge bg-orange edit-varation" 
																data-id="{{ $sp->id }}"
																data-attr_price="{{ $sp->price }}"
																data-attr_qty="{{ $sp->quantity }}"
																data-attr_name="{{ $attr->name }}" 
																data-target="#variation_det{{$sp_count}}" class="accordion-toggle" ><i class="fa fa-pencil-square-o"></i> Edit Details</a>
								                        		@if($sp_count >= 2)
													       			<a class="badge bg-orange delete_details" data-myrow = "variation_Row{{$sp_count}}" data-nxtrow="variation_detRow{{$sp_count}}"><i class="	fa fa-trash"></i> Delete Details</a>
													       		@endif
								                        	</td>
								                        	
								                        </tr>
														<tr class="active_childRow hiddenRow" id="variation_detRow{{$sp_count}}">
															<td  colspan="3" class="hiddenRow">
																<div class="accordian-body collapse" id="variation_det{{$sp_count}}">
																	<div class="row text-left">
																		 <div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Quantity</label>
												            					<input name="variation_product_qty[]" class="form-control" type="text"  value="{{$sp->quantity}}">
												            					<input name="variation_subprod[]" class="form-control" type="hidden"  value="{{$sp->id}}">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12 price_div">
								                							<div class="form-group">
												            					<label >Price</label>
												            					<input  name="variation_product_price[]" class="form-control" type="text"  value="{{$sp->price}}">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
								                							<div class="form-group">
												            					<label for="var_proddscnt">Discount</label>
												            					<input id="var_proddscnt" name="variation_product_dscnt[]" class="form-control trig_saleprice" type="text"  value="{{$sp->discount}}">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">
								                							<div class="form-group">
												            					<label for="var_proddscnt_type">Discount Type</label>
												            					<select id="var_proddscnt_type" name="variation_product_dscnt_type[]" class="form-control trig_saleprice1">
												            						@foreach($discount_type as $dt =>$dt_val)
												            							<option {{($dt == $sp->discount_type) ? 'selected' : ''}} value="{{$dt}}">{{$dt_val}}</option>
												            						@endforeach
												            					</select>
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12 saleprice_div">
								                							<div class="form-group">
												            					<label >Sale Price</label>
												            					<input  name="variation_product_saleprice[]" class="form-control" type="text" readonly="readonly"  value="{{$sp->sale_price}}">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Is Sale?</label>
												            					<input  name="variation_product_issale[]" class="" type="checkbox" {{$sp->is_sale == 1 ? 'checked' : ''}}  value="1">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Promotion From?</label>
												            					<input name="variation_product_promofrom[]" class="form-control datepick3r" type="text"  value="{{$sp_promo_start}}">
																            </div>
								                						</div>
								                						<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Promotion To?</label>
												            					<input name="variation_product_promoto[]" class="form-control datepick3r" type="text"  value="{{$sp_promo_end}}">
																            </div>
								                						</div>
								                						<div class="col-md-12 col-sm-12 col-sm-12">
								                							<div class="form-group">
												            					<label>Shipping Details</label>
												            				</div>
												            			</div>
												            			<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Width</label>
												            					<input name="variation_shipping_width[]" class="form-control" type="text"  value="{{$sp->shipping_width}}">
												            				</div>
												            			</div>
												            			<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Length</label>
												            					<input name="variation_shipping_length[]" class="form-control" type="text"  value="{{$sp->shipping_length}}">
												            				</div>
												            			</div>
												            			<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label>Weight</label>
												            					<input  name="variation_shipping_weight[]" class="form-control" type="text"  value="{{$sp->shipping_weight}}">
												            				</div>
												            			</div>
												            			<div class="col-md-3 col-sm-3 col-sm-12">
								                							<div class="form-group">
												            					<label >Height</label>
												            					<input  name="variation_shipping_height[]" class="form-control" type="text"  value="{{$sp->shipping_height}}">
												            				</div>
												            			</div>
												            			<div class="col-md-4 col-sm-4 col-sm-12">
												            				<div class="form-group">
												            					<label  style="width:100%;">Brief Description</label>
												            					<textarea rowspan="5" class="form-control" name="variation_description[]">{{$sp->description}}</textarea>
												            				</div>
								                							<div class="form-group">
												            					<label  style="width:100%;">Keywords or Tags</label>
												            					<input  name="variation_keywords[]"  data-role="tagsinput"  class="form-control" type="text"  value="{{$sp->keywords}}">
												            				</div>
												            			</div>
												            			<div class="col-md-8 col-sm-8 col-sm-12">
								                							<div class="form-group upl_img">
												            					<!--label >Upload Image</label>
												            					<div class="btn btn-app btnupload">
												            						<input name="variation_upload_image[]" class="form-control upload_image" type="file"  value="{{ !empty($sp->featured_image) ? asset('img/products/'.$sp->featured_image) : '' }}">
												            						<i class="fa fa-upload"></i>  Upload Here!
												            					</div-->
												            					
												            					<div class="col-md-3">
									            									<label for="upload_image">Upload Image</label><br/>
									            									<div class="btn btn-app btnupload">
													            						<input name="variation_upload_image[]" class="form-control upload_image" type="file" value="{{ !empty($sp->featured_image) ? asset('img/products/'.$sp->featured_image) : '' }}">
													            						<i class="fa fa-upload"></i>  Upload Here!
													            					</div>
									            								</div>
									            								<div class="col-md-6">
									            									<div class="preview_image">
												            							<span class="img_prev_wrap">
												            								<span class="remove" style="position: absolute;"><i class="fa fa-trash"></i></span>
												            								<img class="imageThumb" style="width:100%;border:solid 1px #000;" src="{{ !empty($sp->featured_image) ? asset('img/products/'.$sp->featured_image) : '' }}" />
												            							</span>
												            							
												            						</div>
									            								</div>
												            				</div>
												            			</div>
												            			
												            			
												            			<div class="col-md-12 col-sm-12 col-xs-12">
												            				<div class="row">
													            				<div class="col-md-6 col-sm-6 col-xs-12">
													            					<div class="">
											                							<div class="form-group">
															            					<label>User Type Discount</label>
															            				</div>
															            			</div>
													            					@foreach($usertypes as $ut)
																			          	@php
																			          		$value = 0;
																			          	@endphp
													            					
														            					<div class="row">
																           					<div class="col-md-4 col-sm-4 col-xs-12">
																			          			<div class="form-group">
																									<label>
																										{{$ut->name}}
																										<input name="utype_id_child[]" class="form-control" type="hidden" value="{{$ut->id}}">
																									</label>
																								</div>
																							</div>
																							@foreach($sp->ProductUserPrice as $pup)
												                        						@if($pup->user_types_id == $ut->id)
																									<div class="col-md-4 col-sm-4 col-xs-12">
																										<div class="form-group">
																										<input name="utype_discntval_child[]" class="form-control" type="text" value="{{$pup->price}}">
																										</div>
																									</div>
																									<div class="col-md-4 col-sm-4 col-xs-12">
																										<div class="form-group">
																			            					<select id="utype_discntval_child"  name="utype_discnt_type_child[]" class="form-control"  >
																												@foreach($discount_type as $dt =>$dt_val)
																												@php $sel = ''; @endphp
																													@foreach($productuserprice as $pup)
																													
																														@if($dt == $pup->discount_type)
																															@php
																																  $sel = 'selected';
																																  break;
																															  @endphp
																														@endif
																													@endforeach
																													<option  {{$sel}} value="{{$dt}}">{{$dt_val}}</option>
																												@endforeach
																			            					</select> 
																							            </div>
																									</div>
																								@endif
																							@endforeach
																						</div>
																					  @endforeach
																					
													            					
													            				</div>
												            				</div>
												            			</div>
												            			

												            			
											            			</div>
																</div>
															</td>
														</tr>
															@php
																$sp_count++;
															@endphp
														@endforeach

								                    </tbody>
								                 </table>
					            			</div>
					            			
                						</div>
                					</div>
                					 
                				</div>
                			</div>
							{{ $subproduct->links() }}
							<!-- @if($productdetails->product_type == 'multiple')
								<a class="btn btn-warning">Back</a>
							@else
			                <div class="form-group text-right">
			            		<button class="btn btn-gold btn-md btn_saveprod" type="button" style="display: {{($productdetails->product_type == 'multiple') && ($subproduct->count() > 0) ? 'inline' : 'none'}};">Save Product</button>
			            		<button class="btn btn-gold btn-md btn_saveprod" type="button" >Save Product</button>        
			                </div>
							@endif -->
                  </div>
                </div>
        <!-- /.box-body -->
          
        </div>



      </div>
    
  </div>

</div>
<div class="col-md-5 col-sm-5 col-xs-12">
	<div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-10 col-sm-10 col-xs-12"><i class="fa fa-list-alt"></i> Overview </h3>
	      <div class="col-md-2 col-sm-2 col-xs-12">
	      	<div class="btn btn-gold" id="ovrview_addbtn"><i class="fa fa-plus"></i> Add New</div>
	      </div>
	    </div>
	    <div class="box-body">
	      <div  class="dataTables_wrapper dt-bootstrap">
	      	<div class="row ovrview_container">
	      	@php
	      		$po_counter = 0;
	      	@endphp	
	      	@foreach($productothers as $prodothers)
	          <div class="col-md-12 col-sm-12 col-xs-12 ovrview_details_wrap">
	          	@if($po_counter > 0 )
	          	<div class="text-right "><span class="btn btn-danger ovrview_deletebtn"><i class="fa fa-trash"></i></span></div>
	          	@endif
	          	<div class="form-group">
					<label for="ovrview_title">Title</label>
					<input  name="ovrview_title[]" class="form-control" type="text"  value="{{$prodothers->title}}">
					<input  name="ovrview_id[]" class="form-control" type="hidden"  value="{{$prodothers->id}}">
	            </div>
	            <div class="form-group">
					<label for="ovrview_desc">Description</label>
					<textarea  name="ovrview_desc[]" class="form-control ovrview_desc" rows="5">{{$prodothers->description}}</textarea>
	            </div>
	            
	          </div>
	          @php
	      		$po_counter++;
	      	@endphp
	          @endforeach
	          
	          
	          
	        </div>
	       </div>
	     </div>
   </div>
   
   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-10 col-sm-10 col-xs-12"><i class="fa fa-list-alt"></i> Tabs </h3>
	      
	    </div>
	    <div class="box-body">
	      <div  class="dataTables_wrapper dt-bootstrap">
	      	<div class="row ">
	      	  
	      	  <div class="col-md-12 col-sm-12 col-xs-12 ovrview_details_wrap mb10">
	      	  	<label>Include</label>
	      	  </div>
	      	  @php
	      	  	$arr_tabs = explode(',',$productdetails->list_tab);
	      	  @endphp
	      	  <div class="col-md-12 col-sm-12 col-xs-12 ovrview_details_wrap mb10">
	      	  	<div class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" name="howtouse" value="howtouse" {{(in_array('howtouse',$arr_tabs) ? 'checked' : '')}}  /> How to use </div>
	      	  	<div class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" name="aboutbrand" value="aboutbrand" {{(in_array('aboutbrand',$arr_tabs) ? 'checked' : '')}} /> About Brand </div>
	      	  	<div class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" name="deliveropt" value="deliveropt" {{(in_array('deliveropt',$arr_tabs) ? 'checked' : '')}} /> Delivery Option </div>
	      	  </div>
	          <div class="col-md-12 col-sm-12 col-xs-12 ovrview_details_wrap">
	          	
	          	
	            <div class="form-group">
					<label for="htu_desc">How to Use</label>
					<textarea  name="htu_desc" class="form-control htu_desc" rows="5">{{$productdetails->howtousetab_details}}</textarea>
	            </div>
	            <div class="form-group">
					<label for="htu_desc">Delivery Option</label>
					<textarea  name="delopt_desc" class="form-control delopt_desc" rows="5">{{$productdetails->deliveryopt_tab_details}}</textarea>
	            </div>
	          </div>
	          
	          
	        </div>
	       </div>
	     </div>
   </div>
   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-10 col-sm-10 col-xs-12"><i class="fa fa-list-alt"></i> User Type Discount </h3>
	      <!--div class="col-md-2 col-sm-2 col-xs-12">
	      	<div class="btn btn-gold" id="ovrview_addbtn"><i class="fa fa-plus"></i> Add New</div>
	      </div-->
	    </div>
	    <div class="box-body">
	      <div  class="dataTables_wrapper dt-bootstrap">
	      	<div class="row dscnt_baseonUsers">
	      		
	          <div class="col-md-12 col-sm-12 col-xs-12 dscnt_baseonUsers_wrap">
	          	@php
	          		$utype = "";
	          		$utype_id = "";
	          		$utype_dscntype = "";
		          	$utype_dscntype_val = "";
	          	@endphp
	          	@foreach($usertypes as $ut)
	          	@php
	          		$value = 0;
	          		$sel = '';
	          		$utype .= $ut->name.',';
		          	$utype_id .= $ut->id.',';
	          	@endphp
	          	<div class="row">
	          		<div class="col-md-12 col-sm-12 col-xs-12">
			          	<div class="col-md-4 col-sm-4 col-xs-12">
		          			<div class="form-group">
								<label>
									{{$ut->name}}
									<input  name="utype_id[]" class="form-control" type="hidden"  value="{{$ut->id}}">
								</label>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
							@foreach($productuserprice as $pup)
								@if($ut->id == $pup->user_types_id)
									@php
						          		$value = $pup->price;
						          		break;
						          	@endphp
								@endif
							@endforeach
							<input  name="utype_discntval[]" class="form-control" type="text"  value="{{$value}}">
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
            					<select id="utype_discntval"  name="utype_discnt_type[]" class="form-control"  >
            						@foreach($discount_type as $dt =>$dt_val)
            						@php $sel = ''; @endphp
            							@foreach($productuserprice as $pup)
            							
											@if($dt == $pup->discount_type)
												@php
									          		$sel = 'selected';
									          		break;
									          	@endphp
											@endif
										@endforeach
            							<option  {{$sel}} value="{{$dt}}">{{$dt_val}}</option>
            						@endforeach
            					</select>
				            </div>
						</div>
						
					</div>
	            </div>
	            
	            @endforeach
	            @foreach($discount_type as $dt =>$dt_val)
	            	@php
		            	$utype_dscntype .= $dt.',';
			          	$utype_dscntype_val .= $dt_val.',';
		          	@endphp
				@endforeach
	            
	            
	            <input type="hidden" class="utype_name" value="{{$utype}}" />
	            <input type="hidden" class="utype_id"  value="{{$utype_id}}" />
	            <input type="hidden" class="utype_dscnttype" value="{{$utype_dscntype}}" />
	            <input type="hidden" class="utype_dscnttype_val"  value="{{$utype_dscntype_val}}" />
	          </div>
	          
	          
	        </div>
	       </div>
	     </div>
   </div>

   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-9 col-sm-9 col-xs-12"><i class="fa fa-image"></i> Gallery </h3>
	      <!--div class="col-md-3 col-sm-3 col-xs-12" style="overflow: hidden;">
	      	<div class="btn btn-gold gallery_btn" style="position:relative;">
	      		<input type="file" multiple="multiple" id="gallery_input" style="opacity:0;position:absolute;	" />
	      		<i class="fa fa-plus"></i> Upload Gallery
	      	</div>
	      </div-->
	      <div class="col-md-3 col-sm-3 col-sm-12">
	      	<div class="btn btn-gold" id="gallery_addbtn"><i class="fa fa-plus"></i> Add Image</div>
	      </div>
	    </div>
	    <div class="box-body">
	      <div  class="row gallery_wrapview">
	      		@foreach($productimages as $pi)
	      		<div class="col-md-6 col-sm-6 col-xs-12 per_image_wrap col-md-offset-3 col-sm-offset-3 mb10">
	      			<div class="image_view">
	      				<div class="col-md-12 col-sm-12 col-xs-12 img_prev_wrap">
							<meta name="csrf-token" content="{{ csrf_token() }}">
        					<span class="remove_gallery" data-id="{{$pi->ProductImagesData['id']}}" style="position:absolute;"><i class="fa fa-trash"></i></span>
			            	<img class="imageThumb" src="{{asset('img/gallery/'.$pi->ProductImagesData['file_name'])}}" title="" style="width:100%;"/>
			            </div>
					  </div>
	      			<input type="hidden" name="gallery_img_id[]" class="gallery_img_id" value="{{$pi->ProductImagesData['id']}}"  />
	      		</div>
	      		@endforeach
	       </div>
	     </div>
   </div>

   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-9 col-sm-9 col-xs-12"><i class="fa fa-image"></i> Brochure pdf </h3>
	      <!--div class="col-md-3 col-sm-3 col-xs-12" style="overflow: hidden;">
	      	<div class="btn btn-gold gallery_btn" style="position:relative;">
	      		<input type="file" multiple="multiple" id="gallery_input" style="opacity:0;position:absolute;	" />
	      		<i class="fa fa-plus"></i> Upload Gallery
	      	</div>
	      </div-->
	    </div>
	    <div class="box-body">
	      <div  class="row brochure_wrapview">
		  	<div class="col-md-6 col-sm-6 col-xs-12 per_image_wrap col-md-offset-3 col-sm-offset-3 mb10">
			  	Current File:<a href="/pdf/{{$productdetails->brochure_path}}">{{$productdetails->brochure_path}}</a>
				<input type="file" name="brochure_img" class="inp_brochure_view"  accept=".doc, .docx, .pdf,"
				style="max-width: 202px;float:left;" />
			</div>
	       </div>
	     </div>
   </div>

   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-9 col-sm-9 col-xs-12"><i class="fa fa-image"></i> Safety Sheet pdf </h3>
	      <!--div class="col-md-3 col-sm-3 col-xs-12" style="overflow: hidden;">
	      	<div class="btn btn-gold gallery_btn" style="position:relative;">
	      		<input type="file" multiple="multiple" id="gallery_input" style="opacity:0;position:absolute;	" />
	      		<i class="fa fa-plus"></i> Upload Gallery
	      	</div>
	      </div--> 
	    </div>
	    <div class="box-body">
	      <div  class="row safety_wrapview">
		  	<div class="col-md-6 col-sm-6 col-xs-12 per_image_wrap col-md-offset-3 col-sm-offset-3 mb10">
			  	Current File:<a href="/pdf/{{$productdetails->safety_path}}">{{$productdetails->safety_path}}</a>
				<input type="file" name="safety_img" class="inp_safety_view"   accept=".doc, .docx, .pdf,"
				style="max-width: 202px;float:left;"/>
			</div>
	       </div>
	     </div>
   </div>

   <div class="box box-gold">
	    <div class="box-header">
	      <h3 class="box-title col-md-9 col-sm-9 col-xs-12"><i class="fa fa-image"></i> Technical Sheet pdf </h3>
	      <!--div class="col-md-3 col-sm-3 col-xs-12" style="overflow: hidden;">
	      	<div class="btn btn-gold gallery_btn" style="position:relative;">
	      		<input type="file" multiple="multiple" id="gallery_input" style="opacity:0;position:absolute;	" />
	      		<i class="fa fa-plus"></i> Upload Gallery
	      	</div>
	      </div--> 
	    </div>
	    <div class="box-body">
	      <div  class="row technical_wrapview">
		  	<div class="col-md-6 col-sm-6 col-xs-12 per_image_wrap col-md-offset-3 col-sm-offset-3 mb10">
			  	Current File:<a href="/pdf/{{$productdetails->technical_path}}">{{$productdetails->technical_path}}</a>
				<input type="file" name="technical_img"  accept=".doc, .docx, .pdf,"
				class="inp_technical_view"  style="max-width: 202px;float:left;" />
			</div>
	       </div>
	     </div>

   </div>

</div>
</form>
</div>


<div id="myModal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
<div class="modal-dialog modal-lg">
        <div class="panel panel-primary">
            <form action="{{ URL::action('Admin\ProductController@updateAttri') }}" method="post"accept-charset="UTF-8">
			{!! csrf_field() !!}
                <div class="panel-heading"><h4 class="modal-title">Edit <span id="colortitle"></span></h4></div>
                <div class="panel-body">
                	<div class="row">
                		<div class="col-md-12 col-sm-12 col-xs-12">
	                		<div class="col-md-6 col-sm-12 col-xs-12">
	                			<div class="row form-group">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Product ID</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
			                        	<input class="form-group" type="text" id="prodid" name="prodid" readonly>
			                        </div>
			                    </div>
			                    <div class="row form-group">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Price</label>
			                        <div class="col-md-8 col-sm-8 col-xs-12">
			                        	<input class="form-group" type="text" id="attriprice" name="attriprice">
			                        </div>
			                    </div>
	                		</div>
	                		<div class="col-md-6 col-sm-12 col-xs-12">
	                			<div class="row form-group">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Quantity</label>
			                       <div class="col-md-8 col-sm-8 col-xs-12">
			                        	<input class="form-group" type="text" id="attriqty" name="attriqty">
			                        </div>
			                    </div>
			                    <!-- <div class="row form-group">
			                        <label class="col-md-4 col-sm-4 col-xs-12" >Total Amount</label>
			                        <div class="col-md-8 col-sm-8 col-xs-12">
			                        	&#8369; <span class="totamount_div ">asdasd</span>
			                        </div>
			                    </div> -->
	                		</div>
                		</div>
                	</div>
                	<div class="row billshipp_details">
                		
                	</div>
                </div>
                <div class="panel-footer" style="text-align: right">
					<div class="button-group">
                        <button type="submit" class="btn btn-success"  >Add</button>
                    </div>
                    <div class="button-group">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
<!-- close modal container -->
</section>
<!-- /.content-wrapper -->

@stop

@section('scripts')
<script>
    $("a[id*=alert]").on("click", function(){

        if(confirm("Do you want to delete this item?")){
            $(this).parent('form').submit();
        }
        
    }); 

</script>

<script>
	$('.prodtype').on('change',function(){
		prodtype = $('input[name=product_type]:checked').val();
		
		s_div = (prodtype == 'multiple') ?  'none' :'block';
		m_div = (prodtype == 'multiple') ?  'block' :'none';
		
		$('.single_product').css('display',s_div);
		$('.multiple_product').css('display',m_div);
		$('.btn_saveprod').css('display','none');
		if(prodtype == 'single'){
			$('.btn_saveprod').css('display','inline');
		}
		
		
	});
	
	$('.variable_opt').on('change',function(){
		var variable_check = $(".variable_opt:checked");
		var len = variable_check.length;
		if(len > 0){
			$('.variable_next').css('display','inline');
			
		}else{
			$('.variable_next').css('display','none');
		}
		$('.variation_section').css('display','none');
		$('.add_variation').data('reccounter','1');
		$('.btn_saveprod').css('display','none');
		
	});
	$('.variable_next').on('click',function(){
		arr_push = [];
		var Token = $('input[name="_token"]').val();
		var variable_check = $(".variable_opt:checked");
		var len = variable_check.length;
		if(len > 0){
			variable_check.each(function(){
				arr_push.push($(this).val());
			});
			$.ajax({
	            url: base_url + '/admin/product/variation-details',
	            dataType: 'json',
	            method: 'post',
	            cache: false,
	            data: {_token : Token,variable_id :arr_push},
	            success: function (data) {
	               product_variation(data,0,'');
	            }, error: function (e) {
	                console.log(e.responseText);
	            }
	        });
		}
		
	});
	
	$('.add_variation').on('click',function(){
		reccounter = $(this).data('reccounter');
		console.log(reccounter);
		arr_push = [];
		var Token = $('input[name="_token"]').val();
		var variable_check = $(".variable_opt:checked");
		var len = variable_check.length;
		if(len > 0){
			variable_check.each(function(){
				arr_push.push($(this).val());
			});
			$.ajax({
	            url: base_url + '/admin/product/variation-details',
	            dataType: 'json',
	            method: 'post',
	            cache: false,
	            data: {_token : Token,variable_id :arr_push},
	            success: function (data) {
	               product_variation(data,1,reccounter);
	            }, error: function (e) {
	                console.log(e.responseText);
	            }
	        });
		}
		
	});
	
	function fn_delete_row(){
		$('.delete_details').on('click',function(){
	       		myrow = $(this).data('myrow');
	       		nxtrow = $(this).data('nxtrow');
	       		$('#'+myrow).remove();
	       		$('#'+nxtrow).remove();
	       });
	}
	
	function product_variation(data,tag,reccounter){
		if(data.length > 0){
       		tbl_header = '';
       		tbl_col = '<tr class="activeRow "  id="variation_Row'+reccounter+'">';
       		for($v=0;$v<data.length;$v++){
				tbl_header += '<th>'+data[$v].name+'</th>';   
				attributedata = data[$v].attribute_data;
				if(attributedata.length > 0){
					tbl_col += '<td>'+
					             '<select name="variation_attributes[]" class="form-control">'+
					              '<!--option value="0">Any '+data[$v].name+'</option-->';
					for(att=0;att<attributedata.length;att++){
						tbl_col += '<option value="'+attributedata[att].id+'">'+attributedata[att].name+'</option>';
					}
					tbl_col += '</select>'+
					            '</td>';                      		
					                        		
					                        		
					
				}   			
       		}
       		$opt_discount = $('#parent_proddscnt_type').html();
       		tbl_header +=  '<th></th>';
       		delete_row = '';
       		if(tag == 1){
       			delete_row = '<a class="badge bg-orange delete_details" data-myrow = "variation_Row'+reccounter+'" data-nxtrow="variation_detRow'+reccounter+'"><i class="	fa fa-trash"></i> Delete Details</a>';
       		}
       		
       		tbl_col +='<td class="text-left">'+
                    		'<a class="badge bg-orange "  data-toggle="collapse" data-target="#variation_det'+reccounter+'" class="accordion-toggle"  ><i class="	fa fa-pencil-square-o"></i> Edit Details</a> '+
                    		delete_row+
                    	'</td></tr>';
             colspan_td = parseInt(data.length) + parseInt(3);
             
             
             
             utype_name = $('.utype_name').val();
             utype_name = utype_name.split(',');
            utype_name =  utype_name.filter(Boolean);
            
             //utype id
             utype_id = $('.utype_id').val();
             utype_id = utype_id.split(',');
            utype_id =  utype_id.filter(Boolean);
            utype_html = '';
            
            utype_dscnt_id = $('.utype_dscnttype').val();
             utype_dscnt_id = utype_dscnt_id.split(',');
            utype_dscnt_id =  utype_dscnt_id.filter(Boolean);
           
            
            utype_dscnt_val = $('.utype_dscnttype_val').val();
            utype_dscnt_val = utype_dscnt_val.split(',');
            utype_dscnt_val =  utype_dscnt_val.filter(Boolean);
           
            
            for(ut=0;ut < utype_name.length; ut++){
            	 utype_dscnt_html = '';
	            for(ut_dscnttype = 0;ut_dscnttype<utype_dscnt_id.length;ut_dscnttype++){
	            	utype_dscnt_html += '<option value="'+utype_dscnt_id[ut_dscnttype]+'">'+utype_dscnt_val[ut_dscnttype]+'</option>';
	            }
          
             
	           utype_html += '<div class="row">'+
	           					'<div class="col-md-4 col-sm-4 col-xs-12">'+
				          			'<div class="form-group">'+
										'<label>'+
											utype_name[ut]+
											'<input name="utype_id_child[]" class="form-control" type="hidden" value="'+utype_id[ut]+'">'+
										'</label>'+
									'</div>'+
								'</div>'+
								'<div class="col-md-4 col-sm-4 col-xs-12">'+
									'<div class="form-group">'+
									'<input name="utype_discntval_child[]" class="form-control" type="text" value="0">'+
									'</div>'+
								'</div>'+
								'<div class="col-md-4 col-sm-4 col-xs-12">'+
									'<div class="form-group">'+
		            					'<select id="utype_discnt_type_child"  name="utype_discnt_type_child[]" class="form-control"  >'+
		            						utype_dscnt_html+
		            					'</select>'+
						            '</div>'+
								'</div>'+
							'</div>';
            }
             
             
             
            tbl_variation_details = '<tr class="active_childRow hiddenRow" id="variation_detRow'+reccounter+'"><td  colspan="'+colspan_td+'" class="hiddenRow">'+
										'<div class="accordian-body collapse" id="variation_det'+reccounter+'">'+
											'<div class="row text-left">'+
												 '<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Quantity</label>'+
						            					'<input name="variation_product_qty[]" class="form-control" type="text"  value="">'+
						            					'<input name="variation_subprod[]" class="form-control" type="hidden"  value="0">'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12 price_div">'+
		                							'<div class="form-group">'+
						            					'<label >Price</label>'+
						            					'<input  name="variation_product_price[]" class="form-control" type="text"  value="">'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">'+
		                							'<div class="form-group">'+
						            					'<label for="var_proddscnt">Discount</label>'+
						            					'<input id="var_proddscnt" name="variation_product_dscnt[]" class="form-control trig_saleprice" type="text"  value="">'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12 dscnt_div">'+
		                							'<div class="form-group">'+
						            					'<label for="var_proddscnt_type">Discount Type</label>'+
						            					'<select id="var_proddscnt_type" name="variation_product_dscnt_type[]" class="form-control trig_saleprice1">'+
						            						$opt_discount+
						            					'</select>'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12 saleprice_div">'+
		                							'<div class="form-group">'+
						            					'<label >Sale Price</label>'+
						            					'<input  name="variation_product_saleprice[]" class="form-control" readonly="readonly" type="text"  value="">'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Is Sale?</label>'+
						            					'<input  name="variation_product_issale[]" class="" type="checkbox"  value="1">'+
										           ' </div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Promotion From?</label>'+
						            					'<input name="variation_product_promofrom[]" class="form-control datepick3r" type="text"  value="">'+
										            '</div>'+
		                						'</div>'+
		                						'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Promotion To?</label>'+
						            					'<input name="variation_product_promoto[]" class="form-control datepick3r" type="text"  value="">'+
										           ' </div>'+
		                						'</div>'+
		                						'<div class="col-md-12 col-sm-12 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label>Shipping Details</label>'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Width</label>'+
						            					'<input name="variation_shipping_width[]" class="form-control" type="text"  value="">'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Length</label>'+
						            					'<input name="variation_shipping_length[]" class="form-control" type="text"  value="">'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label>Weight</label>'+
						            					'<input  name="variation_shipping_weight[]" class="form-control" type="text"  value="">'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-3 col-sm-3 col-sm-12">'+
		                							'<div class="form-group">'+
						            					'<label >Height</label>'+
						            					'<input  name="variation_shipping_height[]" class="form-control" type="text"  value="">'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-4 col-sm-4 col-sm-12">'+
						            				'<div class="form-group">'+
						            					'<label  style="width:100%;">Brief Description</label>'+
						            					'<textarea rowspan="5" class="form-control" name="variation_description[]"></textarea>'+
						            				'</div>'+
		                							'<div class="form-group">'+
						            					'<label  style="width:100%;">Keywords or Tags</label>'+
						            					'<input  name="variation_keywords[]"  data-role="tagsinput"  class="form-control keywords" type="text"  value="">'+
						            				'</div>'+
						            			'</div>'+
						            			'<div class="col-md-8 col-sm-8 col-sm-12">'+
		                							'<div class="form-group upl_img">'+
						            					'<!--label >Upload Image</label>'+
						            					'<div class="btn btn-app btnupload">'+
						            						'<input name="variation_upload_image[]" class="form-control upload_image" type="file"  value="">'+
						            						'<i class="fa fa-upload"></i>  Upload Here!'+
						            					'</div-->'+
						            					
						            					
						            					'<div class="col-md-3">'+
			            									'<label for="upload_image">Upload Image</label><br/>'+
			            									'<div class="btn btn-app btnupload">'+
							            						'<input name="variation_upload_image[]" class="form-control upload_image" type="file" value="">'+
							            						'<i class="fa fa-upload"></i>  Upload Here!'+
							            					'</div>'+
			            								'</div>'+
			            								'<div class="col-md-6">'+
			            									'<div class="preview_image">'+
						            							
						            							
						            						'</div>'+
			            								'</div>'+
						            				'</div>'+
						            			'</div>'+
						            			
						            			'<div class="col-md-12 col-sm-12 col-xs-12">'+
						            				'<div class="row">'+
							            				'<div class="col-md-6 col-sm-6 col-xs-12">'+
							            					'<div class="">'+
					                							'<div class="form-group">'+
									            					'<label>User Type Discount</label>'+
									            				'</div>'+
									            			'</div>'+
							            					utype_html+
							            				'</div>'+
						            				'</div>'+
						            			'</div>'+
						            			
					            			'</div>'+
										'</div>'+
									'</td></tr>';
			if(tag == 0){
				$('#variation_tbl_header').html(tbl_header);
				$('#variation_tbl_body').html(tbl_col+tbl_variation_details);
            }
           /* $('.activeRow').html(tbl_col);
            $('.active_childRow').html(tbl_variation_details);*/
           if(tag == 1){
             $('#variation_tbl_body').append(tbl_col+tbl_variation_details);
             newcount = parseInt(reccounter) + 1;
             $('.add_variation').data('reccounter',newcount);
            }
            
            $('.variation_section').css('display','block');
            $('.variable_next').css('display','none');
            //refresh tagsinput
            $('.keywords').tagsinput('refresh'); 
            
            $('.btn_saveprod').css('display','inline');
            fn_delete_row();
       }
       
      $('.datepick3r').datepicker({ dateFormat: 'yy-mm-dd' });
      compute_saleprice();
      $(".upload_image").on("change", function(e) {
		 	umg = this;
		 	onchange_img(e,umg);
	    });
	}
	$('.btn_saveprod').on('click',function(){
		 $( "#create_product_form" ).submit();
	});
	
	window.onload = fn_delete_row();
	 $('.datepick3r').datepicker({ dateFormat: 'yy-mm-dd' });
	 
	 
	 
	 
	 
	function onchange_img(e,umg){
		html_appender = $(umg).parents('.upl_img').find('.preview_image');
		var files = e.target.files,
        filesLength = files.length;
	      for (var i = 0; i < filesLength; i++) {
	        var f = files[i]
	        var fileReader = new FileReader(umg);
	        fileReader.onload = (function(e,umg) {
	          var file = e.target;
            $('.preview_image .imageThumb').attr('src', e.target.result);
	          // prev_img = "<span class=\"img_prev_wrap\">" +
	          //   				"<span class=\"remove\" style='position:absolute;'><i class='fa fa-trash'></i></span>" +
	          // "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
	          // "</span>";
	          html_appender.html(prev_img);
	          
	          $(".remove").click(function(){
	            $(this).parent(".img_prev_wrap").remove();
	          });
	        });
	        fileReader.readAsDataURL(f);
	      }
	}
	
	 $(".upload_image").on("change", function(e) { 
	 	umg = this;
	 	onchange_img(e,umg);
    });
     $(".remove").click(function(){
     	$(".upload_image").val('');
	    $('.preview_image .imageThumb').attr('src', '');
	 });
	  function compute_saleprice(){
    	$('.trig_saleprice,.trig_saleprice1').on('change',function(){
	    	
	    	curr_onchange = '';
	    	val1 = '';
	    	sale_price = 0;
	    	identifier_ ='';
	    	identifier_val ='';
	    	
	    	
	    	val = $(this).val(); console.log(val);
	    	if(val == 'fix' || val == 'percentage'){
	    		val1 = $(this).parents('.dscnt_div').siblings('.dscnt_div').find('input').val();
	    		curr_onchange = 'discount_type';
	    	}else{
	    		val1 = $(this).parents('.dscnt_div').siblings('.dscnt_div').find('select').val();
	    		curr_onchange = 'discount';
	    	}
	    	div_siblings = $(this).parents('.dscnt_div');
	    	
	    	sale_price_inp = div_siblings.siblings('.saleprice_div').find('input').attr('id');
	    	price = div_siblings.siblings('.price_div').find('input').val();
	    	
	    	identifier_ = (curr_onchange == 'discount_type') ? val : val1;
	    	identifier_val = (curr_onchange == 'discount_type') ? val1 : val;
	    	
	    	if(identifier_ == 'fix'){
	    		sale_price = parseInt(price) - parseInt(identifier_val);
	    	}else if(identifier_ == 'percentage'){
	    		sale_price = parseInt(price) - (parseInt(price) * (parseInt(identifier_val) /100));
	    	}
	    	div_siblings.siblings('.saleprice_div').find('input').val(sale_price);
	    });
    } 
    window.load = compute_saleprice();
    
    //overview section
    $('#ovrview_addbtn').on('click',function(){
    	inserter = '<div class="col-md-12 col-sm-12 col-xs-12 ovrview_details_wrap">'+
		          	'<div class="text-right "><span class="btn btn-danger ovrview_deletebtn"><i class="fa fa-trash"></i></span></div>'+
		          	'<div class="form-group">'+
						'<label for="ovrview_title">Title</label>'+
						'<input  name="ovrview_title[]" class="form-control" type="text"  value="">'+
						'<input  name="ovrview_id[]" class="form-control" type="hidden"  value="0">'+
		            '</div>'+
		            '<div class="form-group">'+
						'<label for="ovrview_desc">Description</label>'+
						'<textarea  name="ovrview_desc[]" class="form-control ovrview_desc" rows="5"></textarea>'+
		           ' </div>'+
		          '</div>';
	          $('.ovrview_container').append(inserter);
	          $('.ovrview_deletebtn').on('click',function(e){
	          	e.stopImmediatePropagation();
	          	$(this).parents('.ovrview_details_wrap').remove();
	          });
	           summernote_txtarea();
	          
    }); 
    
    $('#gallery_addbtn').on('click',function(){
    	inserter_img = '<div class="col-md-6 col-sm-6 col-xs-12 per_image_wrap col-md-offset-3 col-sm-offset-3 mb10">'+
			      			'<div class="image_view">'+
			      				
			      			'</div>'+
			      			'<input type="file" name="gallery_img[]" class="inp_gallery_view"  />'+
			      			'<input  name="ovrview_id[]" class="form-control" type="hidden"  value="0">'+
			      		'</div>';
    	
    	$('.gallery_wrapview').append(inserter_img);
    	
    	$(".inp_gallery_view").on("change", function(e) {
    		e.stopImmediatePropagation();
		 	umg = this;
		 	html_appender = $(umg).siblings('.image_view');
		 	html_appender.html('');
			var files = e.target.files,
	        filesLength = files.length;
	        if(filesLength > 0 ){
	      for (var i = 0; i < filesLength; i++) {
	        var f = files[i]
	        var fileReader = new FileReader(umg);
	        fileReader.onload = (function(e,umg) {
	          var file = e.target;
	          prev_img = "<div class='col-md-12 col-sm-12 col-xs-12 img_prev_wrap'>" +
	            				"<span class=\"remove_gallery\" style='position:absolute;'><i class='fa fa-trash'></i></span>" +
					            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
					            "</div>";
	          html_appender.append(prev_img);
	          
	          $(".remove_gallery").click(function(){
	            $(this).parents(".per_image_wrap").remove();
	          });
	        });
	        fileReader.readAsDataURL(f);
	      }
	      }else{
	      	html_appender.parents(".per_image_wrap").remove();
	      }
	      $(umg).css({'opacity':'0','width':'0','height':'0'});
	    });
    });



 
	
    
    $('.ovrview_deletebtn').on('click',function(e){
  		e.stopImmediatePropagation();
  		$(this).parents('.ovrview_details_wrap').remove();
  	});
	  $(".remove_gallery").click(function(){
		var id = $(this).data("id");
		var token = $("meta[name='csrf-token']").attr("content");
		if (confirm('Are you sure you want to delete this thing into the database?')) {
			$.ajax(
				{
					url: "/admin/product/product-image/"+id,
					type: 'DELETE',
					// dataType: 'json',
					// cache: false,
					data: {
						"id": id,
						"_token": token,
					},
					success: function (){
						console.log("it Works");
					}
				});
				$(this).parents(".per_image_wrap").remove();
			// Save it!
		} else {
			// Do nothing!
		}
  	});

	$('.edit-varation').on('click', function(e){
		$('#prodid').val($(this).data('id'));
		$('#attriqty').val($(this).data('attr_qty'));
		$('#attriprice').val($(this).data('attr_price'));
		$('#colortitle').html($(this).closest('tr').find('td:first-child').find(':selected').text());
		$('#myModal').modal('show')
	});
</script>
@stop