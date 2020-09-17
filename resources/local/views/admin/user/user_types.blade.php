@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      User Types
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif

  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create User Types </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\UserTypesController@store') }}" method="post"accept-charset="UTF-8">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="utypes_name" id="utypes_name" class="form-control" placeholder="Enter User Types.">
                                </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="submit" class="btn btn-gold pull-right">Add User Type</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            @if($usertypes)       
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                   </tr>	
                            	</thead>
                                <tbody>
                                	
                                    @if(!empty($usertypes[0]))
                                        @foreach( $usertypes as $ut )
                                            <tr>
                                                <td>{{ $ut->name }}</td>
                                                
                                                <td>
                                                    <a class="badge bg-orange edit-utype" data-utypeid="{{$ut->id}}" data-utypename="{{$ut->name}}">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr><td colspan="2"></td></tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">Nothing here!</td>
                                        </tr>
                                    @endif
                                   
                                </tbody>
                            </table>  
                            <div class="pagination"> {{ $usertypes->links() }} </div>  
                            @endif
                            
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="panel panel-primary">
                                    <form action="{{ URL::action('Admin\UserTypesController@update') }}" method="post"accept-charset="UTF-8">
                                        <div class="panel-heading"><h4 class="modal-title">Edit User Type</h4></div>
                                        <div class="panel-body">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="e_usertpes_id" id="e_usertpes_id">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="e_usertypes_name" id="e_usertypes_name" class="form-control" placeholder="Enter ...">
                                                </div>
                                               
                                        </div>
                                        <div class="panel-footer" style="text-align: right">
                                            <div class="button-group">
                                                <button type="button" class="btn btn-success">Update</button>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@stop

@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<script>
	$('.edit-utype').on('click',function(){
		utypeid = $(this).data('utypeid');
		utypename = $(this).data('utypename');
		$('#e_usertpes_id').val(utypeid);
		$('#e_usertypes_name').val(utypename);
		$('#editMdl').modal('show');
	});
</script>
@stop