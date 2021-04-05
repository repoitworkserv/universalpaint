<div class="row" id="cms-home">
	<div class="col-sm-12">
        <div class="box box-gold ">
            <div class="box-header">
                <h3 class="box-title pageid" data-pageid="{{$pageid}}">Links</h3>
               
            </div>
            <div class="box-body">
            	<div class="row">
            		<div class="col-md-4 col-sm-4 col-xs-12">
            			<form action="{{ URL::action('Admin\PageController@lnk_store') }}" method="post"  accept-charset="UTF-8">
                			{!! csrf_field() !!}
                			<div class="form-group">
            					<label for="lnk_name">Link Name</label>
            					<input id="lnk_name" name="lnk_name" class="form-control" type="text"  value="" required="required">
				            </div>
				            <div class="form-group">
            					<label for="attrb_description">Display Column</label>
            					<select class="form-control" id="display_colmn" name="display_colmn" required="required">
            						<option value="footer_left_col">Footer Left Column</option>
            						<option value="footer_right_col">Footer Right Column</option>
												<option value="footer_mid_col" >Footer Middle Column</option>
            					</select>
				            </div>
				            <div class="form-group">
            					<label for="paste_lnk">Paste Link (optional)</label>
            					<input id="paste_lnk" name="paste_lnk" class="form-control" type="text"  value="">
				            </div>
			                <div class="form-group text-right wrap-btn">
			                	<input type="hidden" id="link_id" name="link_id" value="" />
			            		<button class="btn btn-gold btn-md" id="btn_ftr_lnk" type="submit">Add Footer Links</button>    
			                </div>
				        </form>
            		</div>
            		<div class="col-md-8 col-sm-8 col-xs-12">
            			<table class="table table-striped">
		                	<thead>
		                		<tr>
		                            <th>Display Name</th>
		                            <th>Display Column</th>
		                            <th>Paste Link</th>
		                            <th>Post Included</th>
		                            <th>Action</th>
		                       </tr>	
		                	</thead>
		                    <tbody>
		                    	@if($PostMetaData->total() > 0)
		                    		@foreach($PostMetaData as $pmd)
									
		                    			<tr>
		                    				<td>{{$pmd->display_name}}</td>
											@if($pmd->meta_key == 'footer_left_col')
		                    				<td>Footer Left Column</td>
											@elseif($pmd->meta_key == 'footer_right_col')
											<td>Footer Right Column</td>
											@else
											<td>Footer Middle Column</td>
											@endif
		                    				<td>{{$pmd->paste_lnk}}</td>
		                    				<td>
		                    					@php
		                    						$postdata_str = '';
		                    					@endphp
		                    					@if($pmd->meta_value)
		                    						@php
		                    							
		                    							$metaval_expl = explode(',',$pmd->meta_value);
		                    							$count_metaval = count($metaval_expl);
		                    							if($count_metaval > 0){
		                    								
			                    							for($mve= 0; $mve<$count_metaval;$mve++){
			                    								
			                    								if($metaval_expl[$mve] > 0){
			                    								$postdata = \App\Post::find($metaval_expl[$mve]);
			                    								$postdata_str .= '<div class="badge bg-orange">'.$postdata->post_title.' <a href="#" class="remove_post" data-postmetadatid = "'.$pmd->id.'" data-postid="'.$metaval_expl[$mve].'">x</a></div>';
			                    								}
			                    							}
		                    							}
		                    						@endphp
		                    					@endif
		                    					
		                    					
		                    					@php print_r($postdata_str); @endphp
		                    				</td>
		                    				<td>
		                    					<div class="btn btn-sm btn-gold edit-link" data-metadata-id = "{{$pmd->id}}" >Edit</div>
		                    					<div class="btn btn-sm btn-gold add-post-to-link" data-metadata-id = "{{$pmd->id}}" data-toggle="modal" data-target="#addPostModal" data-backdrop="static">Add Post</div>
                                            	<form action="{{ URL::action('Admin\PageController@deletePostLink', $pmd->id) }}" method="POST">
													<input type="hidden" name="_method" value="DELETE">
													<input type="hidden" name="_token" value="{{ csrf_token() }}" />
													<a id="alert{{$pmd->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
												</form>
		                    				</td>
		                    			</tr>
		                    		@endforeach
		                    	@else
		                    		 <tr class="text-center">
			                            <td colspan="3"><h3><strong>No Links Available!</strong></h3></td>
			                        </tr>
		                    	@endif
		                       
		                    </tbody>
		                </table>
						<div class="pagination">{{ $PostMetaData->links() }}</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<script>
$(document).ready(function() {
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
							arr_opt = ['footer_left_col','footer_right_col', 'footer_mid_col'];
							arr_opt_txt = ['Left','Right', 'Middle'];
							opt_html =  '';
							console.log(arr_opt.length);
							for(x=0;x<arr_opt.length;x++){
								issel = (data.meta_key == arr_opt[x]) ? 'selected' : '';
								opt_html += '<option '+issel+' value="'+arr_opt[x]+'">Footer '+arr_opt_txt[x]+' Column</option>';
							}
							$('#display_colmn').html(opt_html);
							$('#btn_ftr_lnk').html('Update Footer Links');
							$('.wrap-btn a').remove();
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

	//Delete product
	$("a[id*=alert]").on("click", function(){

		if(confirm("Do you want to delete this item?")){
				$(this).parent('form').submit();
		}

	});

});
</script>
@stop
