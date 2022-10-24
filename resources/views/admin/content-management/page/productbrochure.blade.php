@extends('layouts.admin.main')
@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('content')
<section class="content-header">
   <h1>
      Product Brochure
   </h1>
   @include('flash-message')
</section>
<section class="content">
   <div class="row">
   <div class="col-sm-12">
      <div class="box box-gold">
         <div class="box-header">
            <h3 class="box-title"><i class="fa fa-plus-circle"></i> Edit Product Brochure </h3>
         </div>
        @if (session('status'))
            <br>
            <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('msg') }}
            </div>
        @endif
         <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                  @php
                    $content = \App\ProductBrochuresContent::where('component','subheading')->first();
                  @endphp
                    <form action="{{ URL::action('Admin\ProductBrochuresController@update_content') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <div class="form-group">
                          <label>Subheading</label>
                          <textarea name="content" id="content" class="form-control content_txt" rows="3" placeholder="Enter ..." >@if(isset($content->content))  {{$content->content}} @endif</textarea>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-gold pull-right" style="margin-bottom: 20px">Update</button>
                      </div>
                     </form>
                </div>
                <div class="col-lg-12">
                    <form action="{{ URL::action('Admin\ProductBrochuresController@store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="operation" id="operation" value="ADD" />
                    <input type="hidden" name="brochure_id" id="brochure_id" value="" />
                    <div class="form-group">
                          <label>Brochure Title</label>
                          <input type="text" name="brochure_title" id="brochure_title" class="form-control" placeholder="Enter Brochure Title" />
                      </div>
                      <div class="form-group">
                          <label>Brochure Image</label>
                          <div id="displayBrochureImageDiv" style="display:none">
                            <img id="brochureImageforUpdate" src="" width="300" height="350" />
                          </div>
                          <input type="file" name="brochure_image" id="brochure_image" class="form-control" accept="image/*" />
                      </div>
                      <div class="form-group">
                          <label>Brochure File</label>
                          <div id="displayBrochureFileDiv" style="display:none">
                            <a href="#" id="brochureFileForUpdate" target="_blank" /></a>
                          </div>
                          <input type="file" name="brochure_file" id="brochure_file" class="form-control" />
                      </div>
                      <div class="form-group">
                          <label>Status</label>
                          <input type="checkbox" name="brochure_status" id="brochure_status" class="checkbox" checked >
                      </div>
                      <div class="form-group">
                          <a id="brochureCancelBtn" href="#" class="btn btn-gold pull-right" style="margin-left:10px; margin-bottom: 20px; display:none">Cancel</a>
                          <button id="brochureActionBtn" type="submit" class="btn btn-gold pull-right" style="margin-bottom: 20px">Save</button>
                      </div>
                    </form>
                    @php
                        $brochures = \App\ProductBrochure::paginate(1);
                     @endphp
                     <div class="form-group">
                        <table class="table table-striped" style="table-layout: fixed;">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Brochure Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($brochures as $item)
                                <tr>
                                    <td>{{ $item->brochure_title }}</td>
                                    <td style="display: block; white-space: nowrap; overflow: hidden">
                                       <img src="{{asset('/images/brochures/'.$item->brochure_image)}}" width="300" height="350">
                                    </td>
                                    <td>
                                    @if($item->status) Active @else Deactive @endif
                                    </td>
                                    <td>
                                    <a class="badge bg-orange editBrochureBtn" data-brochure_id="{{$item->id}}" data-brochure_title="{{$item->brochure_title}}" data-brochure_image="{{$item->brochure_image}}" data-brochure_file="{{$item->brochure_file}}" data-brochure_status="{{$item->status}}">
                                        <span class="fa fa-edit"></span> Edit
                                    </a>
                                        <form action="{{ URL::action('Admin\ProductBrochuresController@destroy', $item->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {!! csrf_field() !!}
                                            <a id="alert9" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">NO DATA FOUND!</td>
                                </tr>

                                @endforelse
                            </tbody>
                        </table>
                        <div style="display:flex; justify-content: center">
                        {{ $brochures->links() }}
                        </div>
                     </div>
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

    $('.editBrochureBtn').click(function() {
        var brochure_id     = $(this).data('brochure_id');
        var brochure_title  = $(this).data('brochure_title');
        var brochure_image  = $(this).data('brochure_image');
        var brochure_file   = $(this).data('brochure_file');
        var brochure_status = $(this).data('brochure_status');

        $('#brochure_id').val(brochure_id);
        $('#brochure_title').val(brochure_title);
        $('#brochureImageforUpdate').attr('src','/images/brochures/'+brochure_image);
        $('#brochureFileForUpdate').attr('href','/images/brochures/files/'+brochure_file);
        $('#brochureFileForUpdate').text(brochure_file);
        $('#displayBrochureImageDiv').show();
        $('#displayBrochureFileDiv').show();
        if(brochure_status == "1") {
            $('#brochure_status').attr('checked','checked');
        } else  {
            $('#brochure_status').removeAttr('checked');
        }
        $('#brochureActionBtn').text('Update');
        $('#operation').val('UPDATE');
        $('#brochureCancelBtn').show();
    });

    $('#brochureCancelBtn').click(function() {
        $('#brochure_id').val('');
        $('#brochure_title').val('');
        $('#displayBrochureImageDiv').hide();
        $('#displayBrochureFileDiv').hide();
        $('#brochureImageforUpdate').attr('src','');
        $('#brochureFileForUpdate').attr('href','#');
        $('#brochureFileForUpdate').text('');
        $('#brochure_image').val('');
        $('#brochure_file').val('');
        $('#hide').show();
        $('#brochure_status').removeAttr('checked');
        $('#brochureActionBtn').text('Save');
        $('#operation').val('ADD');
        $('#brochureCancelBtn').hide();        
    });
   
   });
</script>
@stop