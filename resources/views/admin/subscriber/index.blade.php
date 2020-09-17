@extends('layouts.admin.main')

@section('content')
	 <!-- Content Wrapper. Contains page content -->
	
	
	
	  <section class="content-header">
	    <h1>
	      Subscriber
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
	    
	
	  </section>
	  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-gold">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-plus-circle"></i> Subscriber List </h3>
            </div>



        <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">

                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>

                <div class="row">
                	<div class="col-md-12 col-sm-12 col-xs-12 subcriber_msg">
                		
                	</div>
                	
                  <div class="col-md-12 col-sm-12 col-xs-12">
					{!! csrf_field() !!}
                    <table id="example1" class="table table-striped" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr role="row">
                      <th>Email Address</th>
                      <th>Status</th>
					  <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                      @foreach( $subscriberlist as $sl )
						<tr role="row" class="odd">
                        	<td>{{ $sl->email_address }}</td>
                        	<td><strong>{{ ($sl->is_subscribe == 1 ) ? 'subscriber' : '-' }}</strong></td>
                        	<td>
                        		<a class="badge bg-orange edit-subscribe" data-subsid="{{ $sl->id }}" data-tostatus="{{ ($sl->is_subscribe == 1 ) ? '0' : '1' }}" > {{ ($sl->is_subscribe == 1 ) ? 'unsubscribe' : 'subscribe' }}</a>
                        	</td>
                        </tr>
                        <tr role="row">
	                      <td colspan="3"></td>
	                    </tr>
					@endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
          

        <!-- /.box-body -->
          <div class="pagination"> {{ $subscriberlist->links() }} </div>
        </div>



      </div>
    
  </div>

</div>
</section>

@stop

@section('scripts')
<script>
	$('.edit-subscribe').on('click',function(){
		subs_id = $(this).data('subsid'); 
		status = $(this).data('tostatus'); console.log(subs_id+"  "+status);
		var Token = $('input[name="_token"]').val(); 
		if(subs_id && status){
			$.ajax({
		        url: '/admin/subscriber/status',
		        method: "post",
		        dataType: "json",
		        data: {
		        	subs_id : subs_id,
		        	status : status,
		        	_token : Token,
		        },
		        success: function (data) {
		            if(data == 'success'){
		            	subscriber_html = '<div class="alert alert-success alert-dismissible">'+
							                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
							                '<h4><i class="icon fa fa-check"></i> Success!</h4>'+
							               'Successfully Updated.'+
							              '</div>';
		            	$('.subcriber_msg').html(subscriber_html);
		            	setTimeout(function(){
		            		location.reload();
		            	},3000);
		            }
		            
		        }
		    });
		}
	});
</script>
@stop
