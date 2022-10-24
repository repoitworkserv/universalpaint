@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	
	
	  <section class="content-header">
	    <h1>
	      Variable
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
              <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Variable </h3>
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
                		<form action="{{ URL::action('Admin\VariableController@store') }}" method="post"  accept-charset="UTF-8">
                			{!! csrf_field() !!}
                			
		                	<div class="form-group">
            					<label for="variable_name">Name</label>
            					<input id="variable_name" name="variable_name" class="form-control" type="text"  value="">
				            </div>
				            <div class="form-group">
            					<label for="variable_name">Description</label>
            					<textarea name="variable_description" class="form-control" rows="5" id="variable_description"></textarea>
				            </div>
			                <div class="form-group text-right">
											@if(in_array(3.2, $myPermit))
			            		<button class="btn btn-gold btn-md" type="submit">Add Variable</button>  
											@endif  
			                </div>
				                
				        
                		</form>
                	</div>
                  <div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row ">
                		<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
		                  	<form  action="{{ URL::action('Admin\VariableController@index') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data">
		                  		{!! csrf_field() !!}
			                  	<div class="input-group">
			                  		<input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : ''}}">
				                    <span class="input-group-btn">
				                      <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Variable</button>
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
					  <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
					@if(!empty($variablelist))
                      @foreach( $variablelist as $vl )
						<tr role="row" class="odd">
                        	<td>{{ $vl->name }}</td>
                        	<td>{{ $vl->description }}</td>
                        	<td>
                        		<a class="badge bg-orange edit-variable" data-varid="{{ $vl->id }}" data-varname="{{ $vl->name }}" data-vardesc = "{{ $vl->description }}" ><i class="	fa fa-pencil-square-o"></i> View</a>
														@if(in_array(3.4, $myPermit))
														<form action="{{ URL::action('Admin\VariableController@destroy', $vl->id) }}" method="POST">
																<input type="hidden" name="_method" value="POST">
																<input type="hidden" name="_token" value="{{ csrf_token() }}" />
																<a id="alert{{$vl->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
														</form>
														@endif
                        	</td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
					@endforeach
					@endif
                    </tbody>
                    </table>
                  </div>
                </div>
          

        <!-- /.box-body -->
          <div class="pagination"> {{ $variablelist->links() }} </div>
        </div>



      </div>
    
  </div>

</div>
</section>
<!-- /.content-wrapper -->
<div id="editVariableModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
          <div class="panel panel-primary panel-brdr-gold">
          	<form id="editVariableForm" action="" method="post" accept-charset="UTF-8">
	            <div class="panel-heading panel-gold"><h4 class="modal-title">Edit Variable</h4></div>
	            <div class="panel-body">
					<div class="row">
	                	<div class="col-md-12 col-12 col-xs-12">
	                		{!! csrf_field() !!}
                			<div class="form-group">
            					<label for="edit_variable_name">Name</label>
            					<input id="edit_variable_name" name="edit_variable_name" class="form-control" type="text"  value="">
				            </div>
				            <div class="form-group">
            					<label for="variable_name">Description</label>
            					<textarea id="edit_variable_description" name="edit_variable_description" class="form-control" rows="5"></textarea>
				            </div>
					    </div>
					</div>
	            </div>
	            <div class="panel-footer">
	              <div class="row">
	                
	                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
	                  <input id="edit_variable_id" name="edit_variable_id" class="form-control" type="hidden"  value="">
										@if(in_array(3.3, $myPermit))
	                  <button type="submit" class="btn btn-gold">Update</button>
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
</script>
@stop