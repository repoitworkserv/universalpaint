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
            @elseif($Page->post_title == 'Contact Us')
             	@include('admin.content-management.page.contactus')
            @elseif($Page->post_title == 'Product Brochure')
             	@include('admin.content-management.page.productbrochure')
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
@stop
