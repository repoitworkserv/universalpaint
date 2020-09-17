@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

<section class="content-header">
    <h1>
      Pages
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
                    <!-- <h3 class="box-title"><i class="fa fa-file-text"></i> Page </h3> -->
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped">
                            	<thead>
                            		<tr>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr> 
                            	</thead>
                                <tbody>
                                                                       
                                    @if(!empty($Pages[0]))
                                        @foreach( $Pages as $list )
                                            <tr>
                                                <td>{{ $list->post_title }}</td>
                                                <td>
                                                    <a href="
                                                    {!! URL::action('Admin\PageController@edit',$list->id) !!}" class="badge bg-orange">
                                                        <span class="fa fa-edit"></span> Edit
                                                    </a>
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