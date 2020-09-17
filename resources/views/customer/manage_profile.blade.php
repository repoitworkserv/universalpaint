@extends('layouts.user.app')
@section('css')
<style>
    #footer {
        display: none !important;
	} 
	#loading-container {
       background: #F7F7F7;
    }
    .hrcolor{
    	    border-top: 1px solid #daa521;
    }
</style>
@endsection
@section('content')
<div id="wrapper-customer" style="margin:2% auto;">
	<div class="container">
		<div class="row mb20">
			<div class="col-md-12 col-sm-12 col-xs-12" align="right">
				<a href="{{URL::to('/customer/profile')}}">
				<button class="button button--aylen" tabindex="0" style="margin: 0;">Back to Profile</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form id="mngprofilefrm" action="{{ URL::action('Customer\ProfileController@update_profile') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
	             {!! csrf_field() !!}
	             @foreach($uprofile as $uprof)
				<div class="col-md-4 col-sm-4 col-xs-12 " >
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="form-group">
								<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
								@if($uimage)
									@foreach($uimage as $uimg)
										<img src="{!! asset('img/customer/profile').'/'.$uimg->ImageData['file_name'] !!}" style="display:block; margin: 0 auto;width: 100%;" />
									@endforeach
								@else
								<img src="{!! asset('img/users/default.jpg') !!}" style="display:block; margin: 0 auto;width: 100%;" />
								@endif
								</div>
							</div>
							<h4 class="col-md-12 col-sm-12 col-xs-12 text-center">
								<span  data-toggle="modal" data-target="#upl_modal">
									<i class="fa fa-upload"></i>  Upload Photo
								</span>
							</h4>
						</div>
						
					</div>
					
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12"  >
					<div class="col-md-12 col-sm-12 col-xs-12" >
						<div class="box">
				            <div class="box-header">
				              <h3 class="box-title">Manage Profile</h3>
				            </div>
				            <!-- /.box-header -->
				            <div class="box-body no-padding">
				            	
				            	<div class="form-group">
					            	<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>First Name :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											<input type="text" class="form-control" name="fname" placeholder="Type your First Name" value="{{ (!empty($uprof->first_name)) ? $uprof->first_name : '' }}" />
										</div>
									</div>
								</div>
								<div class="form-group">
						            <div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Last Name :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											<input type="text" class="form-control" name="lname" placeholder="Type your Last Name" value="{{ (!empty($uprof->last_name)) ? $uprof->last_name : '' }}" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Birth Date :</label>
										</div>
										<div class="col-md-4 col-8 col-xs-12">
											<input type="text" class="form-control bday" name="bdate"  placeholder="Type your Birth Date" value="{{ (!empty($uprof->birthdate)) ? $uprof->birthdate : '' }}"  />
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<label>Age :</label>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<input type="text" class="form-control" id="age" readonly="" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Gender :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											
											<select class="form-control" name="gender_name"  >
												<option value="0">-- Select Gender ---</option>
												@if(!empty($gender))    
												                  
									         		@foreach($gender as $g => $gval )
									         			<option {{ (!empty($uprof->gender)) ? (($uprof->gender == $g) ?  'selected' : '') : '' }} value="{{ $g }}">{{ $gval }}</option>
									         		@endforeach
									         	@endif
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Email Addres :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											 <input type="email" class="form-control" name="email"  placeholder="Type your Email Address" value="{{ (!empty($upro[0]['email'])) ? $upro[0]['email'] : '' }}"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Mob Number :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											<input type="text" class="form-control" name="mob_num"  placeholder="Type your Mobile Number" value="{{ (!empty($uprof->mobile_num)) ? $uprof->mobile_num : '' }}" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-4 col-xs-12">
											<label>Tel Number :</label>
										</div>
										<div class="col-md-8 col-8 col-xs-12">
											<input type="text" class="form-control" name="tel_num" placeholder="Type your Telephone Number" value="{{ (!empty($uprof->tel_num)) ? $uprof->tel_num : '' }}" />
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-md-12 col-12 col-xs-12 text-center">
											<!-- <input type="submit" class="btn btn-success" placeholder="Update"/> -->
											<div class="btn btn-success savebtn">
												Save
											</div>
										</div>
									</div>
								</div>
				            </div>
				            <!-- /.box-body -->
				          </div>
					</div>
				</div>
				@endforeach
			</form>
		</div>
	</div>
</div>


<div id="upl_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background:#c1c1c1;">
            <button type="button" class="close custom-close-modal" data-dismiss="modal">&times;</button>
            
            <div class="modal-body">
            	<form action="{{ URL::action('Customer\ProfileController@image_upl') }}" method="post"  accept-charset="UTF-8" enctype="multipart/form-data" >
            		{!! csrf_field() !!}
        		<div class="row">
					<div class="form-group upl_img">
						
						<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1 preview_image mb10">
							<!-- <img src="{!! asset('img/users/default.jpg') !!}" style="display:block; margin: 0 auto;" /> -->
						</div>
						<h4 class="text-center cpointer">
							<div class="btn btn-orange btn-app btnupload">
	    						<input name="profpic" class="form-control upload_image" type="file" value="">
	    						<i class="fa fa-upload"></i>  Choose Photo
	    					</div>
    					</h4>
						
					</div>
				</form>
				</div>
				<!-- <div class="row">
            		<div class="col-md-12 col-sm-12 col-xs-12">
            			<div class="btn btn-success">
            				Upload Now!
            			</div>
            		</div>
            	</div> -->
        	</div>
        	
        </div>
    </div>
</div> <!-- close modal container -->
@stop
@section('scripts')
<script>
function onchange_img(e,umg){
	html_appender = $(umg).parents('.upl_img').find('.preview_image');
	var files = e.target.files,
    filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader(umg);
        fileReader.onload = (function(e,umg) {
          var file = e.target;
          prev_img = "<span class=\"img_prev_wrap\">" +
            				"<span class=\"remove btn btn-danger\" style=''><i class='fa fa-trash'></i> Remove</span>" +
            				"<button class=\"uploadnow btn btn-success\" type=\"submit\" style='position:absolute;'><i class='fa fa-check-circle'></i> Upload</button>" +
				            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" style='width:100%;'/>" +
				            "</span>";
          html_appender.html(prev_img);
          
          $(".remove").click(function(){
            $(this).parent(".img_prev_wrap").remove();
          });
        });
        fileReader.readAsDataURL(f);
      }
}

 $(".upload_image").on("change", function(e) {
 	umg = this;
 	onchange_img(e,umg);
});


</script>
@endsection

