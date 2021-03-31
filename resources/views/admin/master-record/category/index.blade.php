@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Category
    </h1>
    @include('flash-message')
  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Category </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\CategoryController@store') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="category_name" id="category_name" value="{!! old('category_name') !!}" class="form-control {{($errors->first('name') ? form-error : '')}}" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="category_description" id="category_description" value="{!! old('category_description') !!}" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select class="form-control" name="category_parent" id="category_parent">
                                        <option>--- Category ---</option>
                                        @if(!empty($AllCategory[0]))
                                            @foreach( $AllCategory as $list )
                                                @if($list->id != 1)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                    @foreach($list->SubCategory as $subcat)
                                                        <option value="{{ $subcat->id }}">&nbsp;&nbsp;&nbsp;{{ $subcat->name }}</option>
                                                        @foreach($subcat->SubCategory as $subsub)
                                                            <option value="{{ $subsub->id }}" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsub->name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                	<div class="row">
                                		<div class="col-md-12 col-sm-12 col-xs-12">
                                			<label for="featured_image">Featured Image</label>
                                    		<input type="file" class="form-control" name="featured_image" value="{!! old('featured_image') !!}" id="featured_image">
                                		</div>
                                		<div class="col-md-12 col-sm-12 col-xs-12">
                                			<label for="featured_image_banner">Banner Image</label>
                                    		<input type="file" class="form-control" name="featured_image_banner" value="{!! old('featured_image_banner') !!}" id="featured_image_banner">
                                		</div>
                                		<div class="col-md-12 col-sm-12 col-xs-12">
                                			<label for="featured_image_background">Featured Image Background</label>
                                    		<input type="file" class="form-control" name="featured_image_background" value="{!! old('featured_image_background') !!}" id="featured_image_background">
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                    <label>Enable Name</label>
                                                    <input type="checkbox" name="displayed_name" id="displayed_name" class="checkbox" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Enable Description</label>
                                                    <input type="checkbox" name="displayed_description" id="displayed_description" class="checkbox"/>
                                                </div>
                                        </div>
                                	</div>
                                    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="submit" class="btn btn-gold pull-right">Add Category</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                        	<div class="row ">
                        		<div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
				                  	<form  action="{{ URL::action('Admin\CategoryController@index') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data">
				                  		{!! csrf_field() !!}
					                  	<div class="input-group">
					                  		<input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : ''}}">
						                    <span class="input-group-btn">
						                      <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Category</button>
						                    </span>
							              </div>
						            </form>
				                  </div>
                        	</div>
                            @if($Category)       
                            <table class="table table-striped table-accordion">
                            	<thead>
                            		<tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                            	</thead>
                                <tbody>
                                    
                                    @if(!empty($Category[0]))
                                        @php
                                            $x = 1;
                                        @endphp
                                        @foreach( $Category as $list )
                                            <tr data-toggle='collapse' data-target='#cat{{$x}}' class='accordion-toggle @php echo ($list->id != 1) ? "table-row-toogle" : ""; @endphp' aria-expanded='false'>
                                                <td>{{ $list->name }}</td>
                                                <td>{{ $list->description }}</td>
                                                <td>
                                                    <a class="badge bg-green edit-category" data-catid="{{$list->id}}" data-name="{{$list->name}}" data-displayeddescription="{{$list->displayed_discription}}" data-displayedname="{{$list->displayed_name}}" data-description="{{$list->description}}" data-parentid="{{$list->parent_id}}" data-featuredimg="{{$list->featured_img}}" data-featuredimgbackground="{{$list->featured_img_bg}}" data-featuredimgbanner="{{$list->featured_img_banner}}">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
                                                    <form action="{{ URL::action('Admin\CategoryController@destroy', $list->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr><td colspan="3"></td></tr>
                                             @if($list->id != 1)
                                            <tr>
                                                <td colspan="6" class="hiddenRow"><div class="accordian-body collapse" id="cat{{$x}}">
                                                    <table class="table table-striped table-bordered">
                                                        <tbody>
                                                        @foreach($list->SubCategory as $subcat)
                                                            <tr>
                                                                <td>&nbsp;&nbsp;&nbsp;{{ $subcat->name }}</td>
                                                                <td>{{ $subcat->description }}</td>
                                                                <td>
                                                                    <a class="badge bg-green edit-category" data-catid="{{$subcat->id}}" data-name="{{$subcat->name}}" data-displayeddescription="{{$subcat->displayed_discription}}" data-displayedname="{{$subcat->displayed_name}}" data-description="{{$subcat->description}}" data-parentid="{{$subcat->parent_id}}"  data-featuredimg="{{$subcat->featured_img}}" data-featuredimgbackground="{{$subcat->featured_img_bg}}" data-featuredimgbanner="{{$subcat->featured_img_banner}}">
                                                                        <span class="fa fa-edit"></span> Edit
                                                                    </a>
                                                                    <form action="{{ URL::action('Admin\CategoryController@destroy', $subcat->id) }}" method="POST">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                        <a id="alert{{$subcat->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @foreach($subcat->SubCategory as $subsubcat)
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsubcat->name }}</td>
                                                                    <td>{{ $subsubcat->description }}</td>
                                                                    <td>
                                                                        <a class="badge bg-green edit-category" data-catid="{{$subsubcat->id}}" data-name="{{$subsubcat->name}}" data-displayeddescription="{{$subcat->displayed_discription}}" data-displayedname="{{$subcat->displayed_name}}" data-description="{{$subsubcat->description}}" data-parentid="{{$subsubcat->parent_id}}" data-featuredimg="{{$subsubcat->featured_img}}" data-featuredimgbackground="{{$subsubcat->featured_img_bg}}" data-featuredimgbanner="{{$subsubcat->featured_img_banner}}">
                                                                            <span class="fa fa-edit"></span> Edit
                                                                        </a>
                                                                        <form action="{{ URL::action('Admin\CategoryController@destroy', $subsubcat->id) }}" method="POST">
                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                            <a id="alert{{$subsubcat->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="hiddenRow"></td>
                                            </tr>
                                            @endif
                                            @php
                                                $x++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Nothing here!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>    
                            @endif
                            <div class="pagination"> {{ $Category->links() }} </div>
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="panel panel-primary">
                                    <form action="{{ URL::action('Admin\CategoryController@update') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                                        <div class="panel-heading"><h4 class="modal-title">Edit Category</h4></div>
                                        <div class="panel-body">                 
                                            <div class="row">

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    
                                                    <input type="hidden" name="e_displayed_name_value" id="e_displayed_name_value" />
                                                    <input type="hidden" name="e_displayed_description_value" id="e_displayed_description_value" />
                                            		<input type="hidden" name="e_category_id" id="e_category_id">
		                                            <div class="form-group">
		                                                <label>Name</label>
		                                                <input type="text" name="e_category_name" id="e_category_name" value="{!! old('e_category_name') !!}" class="form-control" placeholder="Enter ...">
		                                            </div>
		                                            <div class="form-group">
		                                                <label>Description</label>
		                                                <textarea name="e_category_description" id="e_category_description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                    <label>Enable Name</label>
                                                    <input type="checkbox" name="e_displayed_name" id="e_displayed_name"  class="checkbox" value="1"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enable Description</label>
                                                    <input type="checkbox" name="e_displayed_description" id="e_displayed_description"  class="checkbox" value="1"/>
                                                </div>
		                                            <div class="form-group">
		                                                <label>Parent Category</label>
		                                                <select class="form-control" name="e_category_parent" id="e_category_parent">
		                                                    <option>--- Category ---</option>
		                                                    @if(!empty($AllCategory[0]))
		                                                        @foreach( $AllCategory as $list )
		                                                            @if($list->id != 1)
		                                                                <option value="{{ $list->id }}">{{ $list->name }}</option>
		                                                                @foreach($list->SubCategory as $subcat)
		                                                                    <option value="{{ $subcat->id }}">&nbsp;&nbsp;&nbsp;{{ $subcat->name }}</option>
		                                                                    @foreach($subcat->SubCategory as $subsub)
		                                                                        <option value="{{ $subsub->id }}" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsub->name }}</option>
		                                                                    @endforeach
		                                                                @endforeach
		                                                            @endif
		                                                        @endforeach
		                                                    @endif
		                                                </select>
		                                            </div>
                                            	</div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                            		<div class="form-group edit_img">
                                                	
                                                	</div>
                                            	</div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    
                                            		<div class="form-group edit_img_background">
                                                	
                                                	</div>
                                            	</div>
                                            	<div class="col-md-4 col-sm-4 col-xs-12">
                                            		<div class="form-group edit_img_banner">
                                                	
                                                	</div>
                                            	</div>
                                            </div>
                                        </div>
 
                                        <div class="panel-footer" style="text-align: right">
                                            <div class="button-group">
                                                {!! csrf_field() !!}   
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