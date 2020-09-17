@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Brand
    </h1>
    @include('flash-message')
  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Brand </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\BrandController@store') }}" method="post"accept-charset="UTF-8" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="brand_name" id="brand_name"  value="{!! old('brand_name') !!}" class="form-control" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="brand_description" id="brand_description" value="{!! old('brand_description') !!}" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                	<div class="row">
                                		<div class="col-md-6 col-sm-6 col-xs-12">
                                			<label for="featured_image">Featured Image</label>
                                   			<input type="file" class="form-control" name="featured_img" id="featured_img">
                                		</div>
                                		<div class="col-md-6 col-sm-6 col-xs-12">
                                			<label for="featured_image">Banner Image</label>
                                   			<input type="file" class="form-control" name="featured_image_banner" id="featured_image_banner">
                                		</div>
                                	</div>
                                    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="submit" class="btn btn-gold pull-right">Add Brand</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                        	<div class="row ">
                        		<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
				                  	<form  action="{{ URL::action('Admin\BrandController@index') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data">
				                  		{!! csrf_field() !!}
					                  	<div class="input-group">
					                  		<input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : '' }}">
						                    <span class="input-group-btn">
						                      <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Brand</button>
						                    </span>
							              </div>
						            </form>
				                  </div>
                        	</div>
                            @if($Brand)       
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                   </tr>	
                            	</thead>
                                <tbody>
                                    @if(!empty($Brand[0]))
                                        @foreach( $Brand as $list )
                                            <tr>
                                                <td>{{ $list->name }}</td>
                                                <td>{{ $list->description }}</td>
                                                <td>
                                                    <a class="badge bg-orange edit-brand" data-catid="{{$list->id}}"  data-hide="{{$list->hide_brand}}" data-name="{{$list->name}}" data-slug="{{$list->slug_name}}" data-description="{{$list->description}}" data-featuredimg="{{$list->featured_img}}" data-featuredimgbanner="{{$list->featured_img_banner}}">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
                                                    <form action="{{ URL::action('Admin\BrandController@destroy', $list->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                </form>
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
                            <div class="pagination"> {{ $Brand->links() }} </div>
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="panel panel-primary">
                                    <form action="{{ URL::action('Admin\BrandController@update') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                                        <div class="panel-heading"><h4 class="modal-title">Edit Brand</h4></div>
                                        <div class="panel-body">
                                                {!! csrf_field() !!}
                                                <div class="row">
                                                	<div class="col-md-12 col-sm-12 col-xs-12">
                                                		<input type="hidden" name="e_brand_id" id="e_brand_id"> 
		                                                <div class="form-group">
		                                                    <label>Name</label>
		                                                    <input type="text" name="e_brand_name" value="{!! old('e_brand_name') !!}" id="e_brand_name" class="form-control" placeholder="Enter ...">
		                                                </div>
		                                                <div class="form-group">
		                                                    <label>Description</label>
		                                                    <textarea name="e_brand_description" value="{!! old('e_brand_description') !!}" id="e_brand_description" class="form-control" rows="10" placeholder="Enter ..."></textarea>
		                                                  </div>
                                                        <div class="form-group">
		                                                    <label>Hide</label>
		                                                    <input type="checkbox" name="e_hide_brand" id="e_hide_brand" value="0">
                                                    	</div>
                                                	</div>
                                                	<div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2 col-sm-offset-2">
                                                		<div class="form-group edit_img">
                                                	
                                                		</div>
                                                	</div>
                                                	<div class="col-md-4 col-sm-4 col-xs-12">
                                                		<div class="form-group edit_banner_img">
                                                	
                                                		</div>
                                                	</div>
                                                </div>
                                                <input type="hidden" id="e_featured_image_value" name="e_featured_image_value" value="">
                                                <input type="hidden" id="e_featured_image_banner_value" name="e_featured_image_banner_value" value="">
                                          
                                                
                                                <!--div class="form-group">
				                                    <label for="featured_image">Banner Image</label>
				                                    <input type="file" class="form-control" name="e_featured_image" id="featured_image">
				                                </div-->
                                        </div>
                                        <div class="panel-footer" style="text-align: right">
                                            <div class="button-group">
                                                <button type="submit" class="btn btn-success">Update</button>
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