@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

<section class="content-header">
    <h1>
      Reviews and Rating
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif

</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-gold">
                <div class="box-header">
                	<div class="col-md-10 col-sm-10 col-xs-12 col-md-off-set-1 col-sm-offset-1">
                		@if ($status)
					    
					    <div class="alert alert-{{ $alertclass }}">
					      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ $status }}
					    </div>
					  @endif
                	</div>
                    <!-- <h3 class="box-title"><i class="fa fa-file-text"></i> Page </h3> -->
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Product Name</th>
                                        <th>Reviewed By</th>
                                        <th>Rate</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th> Is Anonymous ?</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr> 
                            	</thead>
                                <tbody>
                                      @if($prr_count > 0 )
                                      	@foreach($prr as $record)
                                      		<tr>
		                                      	<td>{{$record->ProductData['name']}}</td>
		                                        <td>{{$record->UserData['name']}}</td>
		                                        <td>{{$record->rate}} star</td>
		                                        <td>{{$record->title}}</td>
		                                        <td width="500">{{$record->reviews}}</td>
		                                        <td> {{($record->is_anonymous  == 0 ? 'No' : 'Yes')}}</td>
		                                        <td>{{($record->is_approved  == 0 ? 'Pending' : 'Approved')}}</td>
		                                        <td>
		                                        	@if($record->is_approved  == 0)
		                                        	<span class="cpointer revaction" data-action="1" data-revid="{{$record->id}}"><i class="fa fa-check icon-msg-success"></i> Approved</span><br />
		                                        	@endif
		                                        	<span class="cpointer revaction"  data-action="0"  data-revid="{{$record->id}}"><i class="fa fa-trash icon-msg-error"></i> Delete</span>
		                                        </td>
	                                        </tr>
                                        @endforeach
                                      @else()
                                      @endif                                 
                                   
                                </tbody>
                            </table>
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