@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

<section class="content-header">
    <h1>
      Email Template
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
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
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create Post </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form action="{{ URL::action('Admin\EmailTemplateController@store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Title</label>
                                    <textarea name="post_title" id="post_title" class="form-control" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="post_type" id="post_type" class="form-control">
                                        <option value="" disable>(SELECT)</option>
                                        <option value="pending">Pending</option>
                                        <option value="on_process">On Process</option>
                                        <option value="for_shipping">For Shipping</option>
                                        <option value="completed"> Completed </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea name="post_content" id="post_content" class="form-control content_txt" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image_template">Image</label>
                                    <input type="file" class="form-control" name="image_template" id="image_template" />
                                </div>
                                <div class="form-group">
                                    @if(in_array(5.2, $myPermit))
                                    <button type="submit" class="btn btn-gold pull-right">Add Post</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            @if($template)       
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                            	</thead>
                                <tbody>
                                    @if(!empty($template[0]))
                                        @foreach( $template as $list )
                                            <tr>
                                                <td>{{ $list->post_title }}</td>
                                                <td>
                                                    {{ $list->post_content }}
                                                </td>
                                                <td>
                                                    {{ $list->type }}
                                                </td>
                                                <td>
                                                    @if(in_array(5.3, $myPermit))
                                                    <a class="badge bg-orange edit-post" data-postid="{{$list->id}}" data-posttitle="{{$list->post_title}}" data-type="{{$list->post_type}}" data-postname="{{$list->post_name}}" data-postcontent="{{$list->post_content}}" data-image="{{$list->image_template}}">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
                                                    @endif
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
                        </div>
                        <div id="editMdl" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                            <div class="panel panel-primary">
                                <form action="{{ URL::action('Admin\EmailTemplateController@update') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                                    <div class="panel-heading"><h4 class="modal-title">Edit Post</h4></div>
                                    <div class="panel-body">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
                                        		<input type="hidden" name="e_post_id" id="e_post_id">
		                                        <input type="hidden" name="e_post_name" id="e_post_name">
		                                        <input type="hidden" name="e_featured_image_value" id="e_featured_image_value">
		                                        <div class="form-group">
		                                            <label>Title</label>
		                                            <textarea name="e_post_title" id="e_post_title" class="form-control" placeholder="Enter ..."></textarea>
		                                        </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="e_post_type" id="e_post_type" class="form-control">
                                                        <option value="" disable>(SELECT)</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="on_process">On Process</option>
                                                        <option value="for_shipping">For Shipping</option>
                                                        <option value="completed"> Completed </option>
                                                    </select>
                                                </div>
		                                        <div class="form-group">
		                                            <label>Content</label>
		                                            <textarea name="e_post_content" id="e_post_content" class="form-control content_txt_edit" rows="10" placeholder="Enter ..."></textarea>
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
@stop