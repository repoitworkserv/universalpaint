@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Supplier
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

    <?php 
        $myPermit = explode(",",Auth::user()->permission);
    ?>

  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Supplier </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\SupplierController@store') }}" method="post" accept-charset="UTF-8">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="supplier_name" id="supplier_name" value="{!! old('supplier_name') !!}" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Supplier Code</label>
                                    <input type="text" name="supplier_code" id="supplier_code" value="{!! old('supplier_code') !!}" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Contact No.</label>
                                    <input type="text" name="supplier_contact_no" value="{!! old('supplier_contact_no') !!}" id="supplier_contact_no" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="supplier_email" value="{!! old('supplier_email') !!}" id="supplier_email" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="supplier_address" value="{!! old('supplier_address') !!}" id="supplier_address" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    @if(in_array(3.2, $myPermit))
                                    <button type="submit" class="btn btn-gold pull-right">Add Supplier</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            @if($Supplier)       
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                            	</thead>
                                <tbody>
                                    
                                    @if(!empty($Supplier[0]))
                                        @foreach( $Supplier as $list )
                                            <tr>
                                                <td>{{ $list->name }}</td>
                                                <td>{{ $list->description }}</td>
                                                <td>
                                                    <a class="badge bg-orange edit-supplier" data-catid="{{$list->id}}" data-name="{{$list->name}}" data-code="{{$list->supplier_code}}" data-contactno="{{$list->contact_no}}" data-address="{{$list->address}}" data-email="{{$list->email}}">
                                                        <span class="fa fa-edit"></span> View
                                                    </a>
                                                    @if(in_array(3.4, $myPermit))
                                                    <form action="{{ URL::action('Admin\SupplierController@destroy', $list->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr><td colspan="3"></td></tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Nothing here!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>    
                            @endif
                            <div class="pagination"> {{ $Supplier->links() }} </div>
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="panel panel-primary">
                                    <form action="{{ URL::action('Admin\SupplierController@update') }}" method="post"accept-charset="UTF-8">
                                        <div class="panel-heading"><h4 class="modal-title">Edit Supplier</h4></div>
                                        <div class="panel-body">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="e_supplier_id" id="e_supplier_id">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="e_supplier_name" id="e_supplier_name" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Supplier Code</label>
                                                <input type="text" name="e_supplier_code" id="e_supplier_code" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <input type="text" name="e_supplier_contact_no" id="e_supplier_contact_no" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="e_supplier_email" id="e_supplier_email" class="form-control" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="e_supplier_address" id="e_supplier_address" class="form-control" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="panel-footer" style="text-align: right">
                                            <div class="button-group">
                                                @if(in_array(3.3, $myPermit))
                                                <button type="submit" class="btn btn-success">Update</button>
                                                @endif
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

$(document).ready(function() {

//Delete product
$("a[id*=alert]").on("click", function(){

    if(confirm("Do you want to delete this item?")){
        $(this).parent('form').submit();
    }
    
});

});
</script>
@stop