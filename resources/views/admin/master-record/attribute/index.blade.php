@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	<style>
		.color_attrib {
			display: none;
		}
	</style>
	
	  <section class="content-header">
	    <h1>
	      Attribute
	    </h1>
	    @include('flash-message')
			<?php 
        $myPermit = explode(",",Auth::user()->permission);
    	?>
	  </section>
	  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-gold">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Attribute </h3>
            </div>



        <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">

                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>

                <div class="row">
                	
                	<div class="col-md-5 col-5 col-xs-12">
                		<form action="{{ URL::action('Admin\AttributeController@store') }}" method="post"  accept-charset="UTF-8">
                			{!! csrf_field() !!}
                			
		                	<div class="form-group">
            					<label for="attrb_variable_name">Variable Name</label>
            					<select id="attrb_variable_name" name="attrb_variable_name" class="form-control">
            						<option >Select Variable</option>
            						@php
            						$str_id = '';
            						$str_name = '';									
            						@endphp
            						@foreach($variablelist as $vl)
            							<option value="{{$vl->id}}">{{$vl->name}}</option>
            							@php
		            						$str_id .= $vl->id.',';
		            						$str_name .= $vl->name.',';
		            					@endphp
            						@endforeach
            					</select>
            					<input type="hidden" id="str_id" value="{{$str_id}}" />
            					<input type="hidden" id="str_name" value="{{$str_name}}" />
				            </div>
		                	<div class="form-group">
            					<label for="attrb_name">Name</label>
            					<input id="attrb_name" name="attrb_name" class="form-control" type="text"  value="">
				            </div>
							<div class="form-group color_attrib">
            					<label for="attrb_catcolor">Cat Color</label>
								<select id="attrb_catcolor" name="attrb_catcolor" class="form-control">
            					<option value="">Select Category Color</option>
								<option value="Red">Red</option>
								<option value="Blue">Blue</option>
								<option value="Yellow">Yellow</option>
								<option value="Green">Green</option>
								<option value="White">White & Neutrals</option>
								<option value="Gray">Gray</option>
								<option value="Brown">Brown</option>
								<option value="Purple">Purple</option>
								<option value="Orange">Orange</option>
								</select>
            					<!-- <input id="attrb_catcolor" name="attrb_catcolor" class="form-control" type="text"  value=""> -->
				            </div>
							<div class="form-group color_attrib">
            					<label for="attrb_red">Red</label>
            					<input id="attrb_red" name="attrb_red" class="form-control" type="text"  value="">
				            </div>
							<div class="form-group color_attrib">
            					<label for="attrb_green">Green</label>
            					<input id="attrb_green" name="attrb_green" class="form-control" type="text"  value="">
				            </div>
							<div class="form-group color_attrib">
            					<label for="attrb_blue">Blue</label>
            					<input id="attrb_blue" name="attrb_blue" class="form-control" type="text"  value="">
				            </div>

				            <div class="form-group">
            					<label for="attrb_description">Description</label>
            					<textarea name="attrb_description" class="form-control" rows="5" id="attrb_description"></textarea>
				            </div>
							<div class="form-group color_attrib">
									<div class="form-group">
										<label>Best Selling</label>
										<input type="checkbox" name="best_selling" id="best_selling" class="checkbox">
									</div>
                            </div>
			                <div class="form-group text-right">
											@if(in_array(3.2, $myPermit))
			            		<button class="btn btn-gold btn-md" type="submit">Add Attribute</button>
											@endif    
			                </div>
				                
				        
                		</form>
                	</div>
                  <div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row ">
                		<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
		                  	<!-- <form  action="{{ URL::action('Admin\AttributeController@index') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data"> -->
		                  		{!! csrf_field() !!}
			                  	<div class="input-group">
			                  		<input type="text" class="form-control input-gold" id="search_item" name="search_item" value="{{($search_item) ? $search_item : ''}}">
				                    <span class="input-group-btn">
				                      <!-- <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Attribute</button> -->
									  <a href="#" id="btn-search" class="btn btn-gold" > <i class="fa fa-search"></i> Search Attribute </a>
				                    </span>
					              </div>
				            <!-- </form> -->
		                  </div>
                	</div>
                    <table id="example1" class="table table-striped" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr role="row">
						<th>Cat Color</th>
                      <th>Name</th>
                      <th>Desciption</th>
                      <th>Variable</th>
					  <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
					@if(!empty($attributelist))
                     @foreach( $attributelist as $att )
						<tr role="row" class="odd">
							<td>{{ $att->cat_color }}</td>
                        	<td>{{ $att->name }}</td>
                        	<td>{{ $att->description }}</td>
                        	<td>{{ isset($att->VariableData['name']) ?  $att->VariableData['name'] : '' }}</td>
                        	<td>
                        		<a class="badge bg-orange edit-attrb" 
								data-attrb_varid="{{ $att->variable_id }}" 
								data-attrbid="{{ $att->id }}" 
								data-attrbname="{{ $att->name }}" 
								data-catcolor="{{ $att->cat_color}}" 
								data-rattr="{{ $att->r_attr }}" 
								data-gattr="{{ $att->g_attr }}" 
								data-battr="{{ $att->b_attr }}" 
								data-attrbdesc = "{{ $att->description }}" 
								data-attrbbestselling = "{{ $att->best_selling }}" 
								data-variabletype="{{ isset($att->VariableData['name']) ?  $att->VariableData['name'] : '' }}" ><i class="	fa fa-pencil-square-o"></i> View</a>
								@if(in_array(3.4, $myPermit))
								<form action="{{ URL::action('Admin\AttributeController@destroy', $att->id) }}" method="POST">
										<input type="hidden" name="_method" value="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<a id="alert{{$att->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
								</form>
								@endif
                        	</td>
                        </tr>
                        <tr>
                        	<td colspan="4"></td>
                        </tr>
					@endforeach
					@endif
                    </tbody>
                    </table>
                  </div>
                </div>
          

        <!-- /.box-body -->
          <div class="pagination"> {{ $attributelist->appends($_GET)->links() }} </div>
        </div>

      </div>
    
  </div>

</div>
</section>
<!-- /.content-wrapper -->
<div id="editAttributeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
          <div class="panel panel-primary panel-brdr-gold">
          	<form id="editAttributeForm" action="" method="post" accept-charset="UTF-8">
	            <div class="panel-heading panel-gold"><h4 class="modal-title">Edit Attribute</h4></div>
	            <div class="panel-body">
					<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12">
	                		{!! csrf_field() !!}
	                		<div class="form-group">
            					<label for="edit_variable_name">Variable</label>
            					<select id="edit_variable_name" name="edit_variable_name" class="form-control">
            					</select>
				            </div>
                			<div class="form-group">
            					<label for="edit_attrb_name">Name</label>
            					<input id="edit_attrb_name" name="edit_attrb_name" class="form-control" type="text"  value="">
				            </div>							
							<div class="form-group color_attrib">
            					<label for="edit_attrb_catcolor">Cat Color</label>
								<select id="edit_attrb_catcolor" name="edit_attrb_catcolor" class="form-control">
            					<option value="">Select Category Color</option>
								<option value="Red">Red</option>
								<option value="Blue">Blue</option>
								<option value="Yellow">Yellow</option>
								<option value="Green">Green</option>
								<option value="White">White & Neutrals</option>
								<option value="Gray">Gray</option>
								<option value="Brown">Brown</option>
								<option value="Purple">Purple</option>
								<option value="Orange">Orange</option>
								</select>
            					<!-- <input id="attrb_catcolor" name="attrb_catcolor" class="form-control" type="text"  value=""> -->
				            </div>
							<div class="form-group color_attrib">
            					<label for="edit_attrb_red">Red</label>
            					<input id="edit_attrb_red" name="edit_attrb_red" class="form-control" type="text"  value="">
				            </div>
							<div class="form-group color_attrib">
            					<label for="edit_attrb_green">Green</label>
            					<input id="edit_attrb_green" name="edit_attrb_green" class="form-control" type="text"  value="">
				            </div>
							<div class="form-group color_attrib">
            					<label for="edit_attrb_blue">Blue</label>
            					<input id="edit_attrb_blue" name="edit_attrb_blue" class="form-control" type="text"  value="">
				            </div>

				            <div class="form-group">
            					<label for="edit_attrb_description">Description</label>
            					<textarea id="edit_attrb_description" name="edit_attrb_description" class="form-control" rows="5"></textarea>
				            </div>
							<div class="form-group color_attrib">
								<label>Best Selling</label>
								<input type="checkbox" name="edit_attrb_best_selling" id="edit_attrb_best_selling" class="checkbox">
                            </div>
					    </div>
					</div>
	            </div>
	            <div class="panel-footer">
	              <div class="row">
	                
	                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                  <input id="edit_attrb_id" name="edit_attrb_id" class="form-control" type="hidden"  value="">
										@if(in_array(3.3, $myPermit))
	                  <button type="submit" class="btn btn-primary">Update</button>
										@endif
	                  <button type="button" class="btn btn-default modcancel" data-dismiss="modal">Cancel</button>
	                </div>
	              </div>
	            </div>
            </form>
        </div>       
    </div>
  </div>
@stop

@section('scripts')
<script>
    $("a[id*=alert]").on("click", function(){

        if(confirm("Do you want to delete this item?")){
            $(this).parent('form').submit();
        }
        
	});

	$('#search_item').keyup(function(e) {
		if(e.keyCode == '13') {
			$('#btn-search').trigger('click');
		}
	})

	$('#btn-search').click(function() {
		var search = $('#search_item').val();
		window.location = '/admin/attribute?search_item='+search;
	});
	
	$("#attrb_variable_name").on('change',function(){
	attr = $(this).children('option:selected').html();
		if(attr == 'Color') {
			$(".color_attrib").css("display","block");
		}else{
			$(".color_attrib").css("display","none");
		}
	});
</script>
@stop