@extends('layouts.admin.main')
@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('content')
<section class="content-header">
   <h1>
      Contact Us
   </h1>
   @include('flash-message')
</section>
<section class="content">
   <div class="row">
   <div class="col-sm-12">
      <div class="box box-gold">
         <div class="box-header">
            <h3 class="box-title"><i class="fa fa-plus-circle"></i> Edit Contact Us </h3>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-lg-12">
                  @php
                    $contact_us_post = \App\Post::where('post_name','contact_us')->orWhere('post_title','Contact Us')->first();
                  @endphp
                  <form action="{{ URL::action('Admin\PageController@store_contactus') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                     {!! csrf_field() !!}
                     <div class="form-group">
                        <label>Content</label>
                        <textarea name="post_content" id="post_content" class="form-control content_txt" rows="3" placeholder="Enter ..." >@if(isset($contact_us_post->post_content))  {{$contact_us_post->post_content}} @endif</textarea>
                     </div>
                     <div class="form-group">
                        <label>Widget Boxes</label>

                        @php
                        $postmeta_values = "";
                        $postmetadata = \App\PostMetaData::where('source_id',$contact_us_post->id)->where('meta_key','contact_us_post')->first();
                        @endphp
                        @if(!empty($postmetadata))
                        @php  
                        $postmeta_values = $postmetadata->meta_value;
                        $posts = explode(',',$postmetadata->meta_value);
                        @endphp
                        @foreach($posts as $post)
                        @php 
                        $post_data = \App\Post::find($post);
                        @endphp 
                        @if(!empty($post_data))
                        <div class="badge bg-orange">{{$post_data->post_title}} <a href="#" class="remove_post" data-postmetadatid="{{$postmetadata->id}}" data-postid="{{$post_data->id}}">x</a></div>
                        <!-- <div class="badge bg-orange">Site Address <a href="#" class="remove_post" data-postmetadatid="23" data-postid="26">x</a></div> -->
                        @endif
                        @endforeach
                        @endif
                        <div class="btn btn-sm btn-gold add-contactus-post" data-source_id="@if(!empty($contact_us_post)){{$contact_us_post->id}}@endif" data-metadata-id="@if(!empty($postmetadata)){{$postmetadata->id}}@endif" data-metavalues="{{$postmeta_values}}" data-toggle="modal" data-target="#addContactUsPost" data-backdrop="static">Add Post</div>
                     </div>
                     <div class="form-group">
                        <label>Map Link</label>
                        <textarea name="button_link" id="button_link" class="form-control" rows="3" placeholder="Enter ..." >@if(isset($contact_us_post->button_link))  {{trim($contact_us_post->button_link)}} @endif</textarea>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-gold pull-right">Save</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal fade" id="addContactUsPost" role="dialog" >
    <div class="modal-dialog" role="document">
    	<form action="{{ URL::action('Admin\PageController@add_contact_us_post') }}" method="post"  accept-charset="UTF-8">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBannerLabel">Add Post to Link</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select multiple="multiple" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" name="post_list[]" aria-hidden="true" id="post_list">
                        <option value="0">---Select Post---</option>
                        @foreach($Post as $list)
                            <option value="{{$list->id}}" >{{$list->post_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="source_id" name="source_id" value="" />
            	<input type="hidden" id="post_meta_id" name="post_meta_id" value="" />
            	<input type="hidden" id="metavalues" name="metavalues" value="" />
            	<button type="submit" class="btn btn-primary">ADD</button>
                <button type="button" class="btn btn-warning"  data-dismiss="modal">Close</button>
                
            </div>
        </div>
        </form>
    </div>
</div>
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

   $('.add-contactus-post').on('click', function() {
      var post_meta_id = $(this).data('metadata-id');
      var metavalues   = $(this).data('metavalues');
      var source_id    = $(this).data('source_id');
      $('#source_id').val(source_id);
      $('#metavalues').val(metavalues);
      $('#post_meta_id').val(post_meta_id);
      // $.ajax({
      //   url: base_url + '/admin/page/add-contactus-post',
      //   method: 'post',
      //   dataType: "json",
      //   data: {_token,post_meta_id},
      //   success: function (data) {    
      //     if(data == 'success'){
      //       location.reload();
      //     }
      //   }
			// });	

   });

   $('.remove_post').on('click',function(){
		if(confirm("Do you want to delete this item?")){
			post_id = $(this).data('postid');
			postmetadatid = $(this).data('postmetadatid');
      Token = $('input[name="_token"]').val();
			if(post_id){
				$.ajax({
						url: base_url + '/admin/page/lnk-add_post',
						method: 'post',
						dataType: "json",
						data: {_token : Token,tag_lnk:'remove',post_id_metaval:postmetadatid,post_ist:post_id},
						success: function (data) {    
							if(data == 'success'){
								location.reload();
							}
						}
				});	
			}
    }
		
	});
   
   });
</script>
@stop