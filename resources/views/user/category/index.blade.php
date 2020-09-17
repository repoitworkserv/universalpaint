@extends('layouts.user.app')

@section('content')
<div id="category-pg">
    <div class="pg-hdr">
        <div class="page-header">
            <div class="page-title"><a href="{{ URL::to('/') }}">Home </a><span>Category</span></div>
            <form action="{{ URL::action('User\CategoryController@index') }}" method="get" accept-charset="UTF-8" class="col-lg-4 col-xs-12">
                <div class="input-group input-group-sm col-sm-12">
                    <input type="text" class="form-control" name="search" placeholder="Search a Category">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div id="category-content">
        <div class="container">
            <div class="row list col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @foreach($category as $list)
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 item">
                        <div class="list-content">
                            <a href="#">
                                <div class="list-banner" style="background: url({!! asset('img/category/') !!}/{{$list->featured_img_bg}});">
                                    <div class="hov-img">
                                        <div class="list img cat-select" data-gettype="ps" data-filter-type="category" data-value="{{ $list->slug_name }}" style="background: url({!! asset('img/category/') !!}/{{$list->featured_img}});">    
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="list-name cat-select" data-gettype="ps" data-filter-type="category" data-value="{{ $list->slug_name }}" >{{$list->name}}</div>
                                    </div>                                    
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection