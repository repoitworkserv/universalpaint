@extends('layouts.user.app')

@section('content')

@if($postmetadata->count() > 0)
	@foreach($postmetadata as $pmd)
<div class="container">

    <div class="page-header">
        <div class="page-title"><h2 class="text-center">{{$pmd->display_name}}</h2></div>       
    </div>
    
    
    <!-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
        	{{$pmd->meta_key}}
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">   
        	picture here
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
        	content here
        </div>
    </div> -->
    <div class="page-content mb20">
	@if($pmd->meta_value)
		@php
			
			$metaval_expl = explode(',',$pmd->meta_value);
			$count_metaval = count($metaval_expl);
		@endphp	
			@if($count_metaval > 0)
				
				@for($mve= 0; $mve<$count_metaval;$mve++)
					
					@if($metaval_expl[$mve] > 0)
						@php 
							$postdata = \App\Post::find($metaval_expl[$mve]); 
						@endphp
						
						<div class="row">
					        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
					        	<h3 class="text-center mb20"><strong>{{$postdata->post_title}}</strong></h3>
					        </div>
					        @if($postdata->featured_image)
					        <div class="col-md-4 col-sm-4 col-xs-12">
					        	<img style="width:100%;" src="{{URL::to('/img/post/'.$postdata->featured_image)}}" />
					        </div>
					        @endif
					        <div class="{{($postdata->featured_image) ? 'col-md-8 col-sm-8 col-xs-12' : 'col-md-12 col-sm-12 col-xs-12'}}">  
					        	{!!$postdata->post_content!!}
					        </div>
					       
					    </div>
					@endif
				@endfor
			@endif
		
	@endif
	</div>
</div>
	@endforeach
@endif
@endsection


@section('scripts')

@stop
