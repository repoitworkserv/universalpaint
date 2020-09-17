@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Post
    </h1>
    @include('flash-message')

  </section>
  <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Post </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\PostController@store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Title</label>
                                    <textarea name="post_title" id="post_title" class="form-control" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea name="post_content" id="post_content" class="form-control content_txt" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Button Name</label>
                                    <input type="text" name="button_name" id="button_name" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" name="button_link" id="button_link" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Enable Content</label>
                                    <input type="checkbox" name="displayed_post_content" id="displayed_post_content" class="checkbox"/>
                                </div>
                                <div class="form-group">
                                    <label>Enable Title</label>
                                    <input type="checkbox" name="displayed_title" id="displayed_title" class="checkbox"/>
                                </div>
                                <div class="form-group">
                                    <label>Enable</label>
                                    <input type="checkbox" name="displayed_button" id="displayed_button" class="checkbox"/>
                                </div>
                                <div class="form-group">
                                    <label for="featured_image">Image</label>
                                    <input type="file" class="form-control" name="featured_image" id="featured_image" />
                                </div>
                                <div class="form-group">
                                    <label for="featured_banner">Banner</label>
                                    <input type="file" class="form-control" name="featured_banner" id="featured_banner" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-gold pull-right">Add Post</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            @if($Post)    
                            <table class="table table-striped" style="table-layout: fixed;">
                            	<thead>
                            		<tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Action</th>
                                    </tr>
                            	</thead>
                                <tbody>
                                    @if(!empty($Post[0]))
                                        @foreach( $Post as $list )
                                            <tr>
                                                <td>{{ $list->post_title }}</td>
                                                <td style="display: block; white-space: nowrap; width: 200px; height: 20px; overflow: hidden">
                                                    {{ $list->post_content }}
                                                </td>
                                                <td>
                                                    <a class="badge bg-orange edit-post" data-postid="{{$list->id}}" data-displayedtitle="{{ $list->displayed_title }}" data-displayedpostcontent="{{ $list->displayed_post_content }}" data-displayedbutton="{{ $list->displayed_button }}" data-buttonname="{{$list->button_name}}" data-buttonlink="{{ $list->button_link }}" data-posttitle="{{$list->post_title}}" data-postname="{{$list->post_name}}" data-postcontent="{{$list->post_content}}" data-image="{{$list->featured_image}}"  data-bannerimage="{{$list->featured_banner}}">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
														<form action="{{ URL::action('Admin\PostController@destroy', $list->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
	                                            <td colspan="3"></td>
	                                        </tr>   
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Nothing here!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            
                            @endif
                            <div class="pagination"> {{ $Post->links() }} </div>
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                            <div class="panel panel-primary">
                                <form action="{{ URL::action('Admin\PostController@update') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                                    <div class="panel-heading"><h4 class="modal-title">Edit Post</h4></div>
                                    <div class="panel-body">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
                                        		<input type="hidden" name="e_post_id" id="e_post_id">
		                                        <input type="hidden" name="e_post_name" id="e_post_name">
		                                        <input type="hidden" name="e_featured_image_value" id="e_featured_image_value">
                                                <input type="hidden" name="e_featured_banner_value" id="e_featured_banner_value" />
                                                <input type="hidden" name="e_displayed_post_content_value" id="e_displayed_post_content_value">
                                                <input type="hidden" name="e_displayed_title_value" id="e_displayed_title_value" />
                                                <input type="hidden" name="e_displayed_button_value" id="e_displayed_button_value" />
		                                        <div class="form-group">
		                                            <label>Title</label>
		                                            <textarea name="e_post_title" id="e_post_title" class="form-control" placeholder="Enter ..."></textarea>
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Content</label>
		                                            <textarea name="e_post_content" id="e_post_content" class="form-control content_txt_edit" rows="10" placeholder="Enter ..."></textarea>
		                                        </div>
                                                <div class="form-group">
                                                    <label>Button Name</label>
                                                    <input type="text" name="e_button_name" id="e_button_name" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Link</label>
                                                    <input type="text" name="e_button_link" id="e_button_link" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Enable Content</label>
                                                    <input type="checkbox" name="e_displayed_post_content" id="e_displayed_post_content" class="checkbox"  />
                                                </div>
                                                <div class="form-group">
                                                    <label>Enable Title</label>
                                                    <input type="checkbox" name="e_displayed_title" id="e_displayed_title" class="checkbox"  />
                                                </div>
                                                <div class="form-group">
                                                    <label>Enable</label>
                                                    <input type="checkbox" name="e_displayed_button" id="e_displayed_button" class="checkbox" />
                                                </div>
                                        	</div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="banner">
                                                
                                                </div>
                                        	</div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                        		<div class="xtra">
                                                
                                        		</div>
                                        	</div> 
                                        </div>
                                        
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