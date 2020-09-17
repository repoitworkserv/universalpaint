@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	
	
	  <section class="content-header">
	    <h1>
	      Attribute
	    </h1>
	    @include('flash-message')
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
				            <div class="form-group">
            					<label for="attrb_description">Description</label>
            					<textarea name="attrb_description" class="form-control" rows="5" id="attrb_description"></textarea>
				            </div>
			                <div class="form-group text-right">
			            		<button class="btn btn-gold btn-md" type="submit">Add Attribute</button>    
			                </div>
				                
				        
                		</form>
                	</div>
                  <div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row ">
                		<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
		                  	<form  action="{{ URL::action('Admin\AttributeController@index') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data">
		                  		{!! csrf_field() !!}
			                  	<div class="input-group">
			                  		<input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : ''}}">
				                    <span class="input-group-btn">
				                      <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Attribute</button>
				                    </span>
					              </div>
				            </form>
		                  </div>
                	</div>
                    <table id="example1" class="table table-striped" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr role="row">
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
                        	<td>{{ $att->name }}</td>
                        	<td>{{ $att->description }}</td>
                        	<td>{{ $att->VariableData['name'] }}</td>
                        	<td>
                        		<a class="badge bg-orange edit-attrb" data-attrb_varid="{{ $att->variable_id }}" data-attrbid="{{ $att->id }}" data-attrbname="{{ $att->name }}" data-attrbdesc = "{{ $att->description }}" ><i class="	fa fa-pencil-square-o"></i> Edit</a>
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
          <div class="pagination"> {{ $attributelist->links() }} </div>
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
				            <div class="form-group">
            					<label for="edit_attrb_description">Description</label>
            					<textarea id="edit_attrb_description" name="edit_attrb_description" class="form-control" rows="5"></textarea>
				            </div>
					    </div>
					</div>
	            </div>
	            <div class="panel-footer">
	              <div class="row">
	                
	                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                  <input id="edit_attrb_id" name="edit_attrb_id" class="form-control" type="hidden"  value="">
	                  <button type="submit" class="btn btn-primary">Update</button>
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
</script>
@stop