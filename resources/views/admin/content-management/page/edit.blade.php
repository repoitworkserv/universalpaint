@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

<section class="content-header">
    <h1>
      {{ $Page->post_title }}
    </h1>
    @include('flash-message')
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            @if($Page->post_title == 'Home')
                @include('admin.content-management.page.home')
             @elseif($Page->post_title == 'Footer')
             	@include('admin.content-management.page.footerlinks')
            @endif
        </div>
    </div>
</section>
<div class="modal fade" id="addPostModal" role="dialog" >
    <div class="modal-dialog" role="document">
    	<form action="{{ URL::action('Admin\PageController@link_manage_post') }}" method="post"  accept-charset="UTF-8">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBannerLabel">Add Post to Link</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select multiple="multiple" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" name="post_ist[]" aria-hidden="true" id="post-list">
                        <option value="0">---Select Post---</option>
                        @foreach($Post as $list)
                            <option value="{{$list->id}}" >{{$list->post_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="tag_lnk" name="tag_lnk" value="add" />
            	<input type="hidden" id="lnk_id_to_add" name="post_id_metaval" value="" />
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
@if($Page->post_title == 'Footer')
<script>
	var Token = $('input[name="_token"]').val();
	page_id = $('.pageid').data('pageid');
	$('.edit-link').on('click',function(){
		metadata_id = $(this).data('metadata-id');
		if(metadata_id){
			$.ajax({
                url: base_url + '/admin/page/lnk-info',
                method: 'post',
                dataType: "json",
                data: {_token : Token,lnk_id:metadata_id},
                success: function (data) {    
                	$('#link_id').val(metadata_id);   
                    $('#lnk_name').val(data.display_name);
                    $('#paste_lnk').val(data.paste_lnk);
                    arr_opt = ['footer_left_col','footer_right_col', 'footer_icon'];
                    arr_opt_txt = ['Left','Right', 'Icon'];
                    opt_html =  '';
                    console.log(arr_opt.length);
                    for(x=0;x<arr_opt.length;x++){
                    	issel = (data.meta_key == arr_opt[x]) ? 'selected' : '';
                    	opt_html += '<option '+issel+' value="'+arr_opt[x]+'">Footer '+arr_opt_txt[x]+' Column</option>';
                    }
                    $('#display_colmn').html(opt_html);
                    $('#btn_ftr_lnk').html('Update Footer Links');
                    $('.wrap-btn').append('<a href="'+base_url+'/admin/page/edit/'+page_id+'" class="btn btn-gold btn-md">Cancel</a>');
               		
                }
            });
			
		}
    });

	$('.add-post-to-link').on('click',function(){
		metadata_id = $(this).data('metadata-id');
		$('#lnk_id_to_add').val(metadata_id);
	})
	
	$('.remove_post').on('click',function(){
		if(confirm("Do you want to delete this item?")){
            post_id = $(this).data('postid');
            postmetadatid = $(this).data('postmetadatid');
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
</script> 
@endif
@stop
