@extends('layouts.user.app')

@section('content')
<div id="brand">
    <div class="pg-hdr">
        <div class="page-header">
            <div class="page-title"><a href="{{ URL::to('/') }}">Home </a><span><a href="{{ URL::to('/brands') }}">All Brands</a></span></div>
            <form action="{{ URL::action('User\BrandController@index') }}" method="get" accept-charset="UTF-8" class="col-lg-4">
            </form>
        </div>
    </div>
    <div id="my-section-navigation">
        <ul  id="menu" class="tabs">
            <li class="tab-link current" data-tab="tab-ALL"><a href="/brands">All</a></li>
            @foreach($brandGroup as $key => $list)
                @if(empty($uid))
                        <li class="tab-link " data-tab="tab-{{$key}}">{{$key}}</li>
                @elseif(\App\User::where('id', $uid)->first()['users_type_id'] == 3)
                        <li class="tab-link " data-tab="tab-{{$key}}">{{$key}}</li>
                @else
                    @foreach($list as $item)
                    @if(in_array($item->id, $userBrands))
                    <li class="tab-link " data-tab="tab-{{$key}}">{{$key}}</li>
                    @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>      
    <div class="section-list row col-sm-12">
    @foreach($brandGroup as $key => $list)
    <div class="col-sm-12">  
        <div id="clear">
            <div id="tab-{{$key}}" class="item tab-content current">
                @if(empty($uid))
                @foreach($list as $item)
                        <div id="{{$key}}" class="row col-sm-2">
                            <a href="/brand/{{$item->slug_name}}">
                            <div class="brnd">
                                <div class="brnd-ttl">{{$item->name}}</div>
                            </div>
                            </a>
                        </div>
                @endforeach
                @elseif(\App\User::where('id', $uid)->first()['users_type_id'] == 3)
                @foreach($list as $item)
                    <div id="{{$key}}" class="row col-sm-2">
                        <a href="/brand/{{$item->slug_name}}">
                        <div class="brnd">
                            <div class="brnd-ttl">{{$item->name}}</div>
                        </div>
                        </a>
                    </div>
                @endforeach
                @else
                @foreach($list as $item)
                    @if(in_array($item->id, $userBrands))
                        <div id="{{$key}}" class="row col-sm-2">
                            <a href="/brand/{{$item->slug_name}}">
                            <div class="brnd">
                                <div class="brnd-ttl">{{$item->name}}</div>
                            </div>
                            </a>
                        </div>
                    @endif
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @endforeach
    </div>   
</div>
<style>
    #clear {
        display: contents;
    }
    .brnd .brnd-ttl {
        margin-right: 10px;
        margin-top: 22px;
        margin-bottom: 22px;
        font-size: 20px;
       

    }
    .container{
        width: 800px;
        margin: 0 auto;
    }

    ul.tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
            display: inline-block;
		}
    ul.tabs li{
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }
    
    ul.tabs li:hover{
        border: 2px solid #FF7900;
        border-radius: 10px;
    }

    ul.tabs li.current{
        border-radius: 10px;
        background: #FF7900;
        border: 2px solid #FF7900;
        color: #fff !important;
    }

    .tab-content{
        display: none;
        padding: 15px;
    }

    .tab-content.current{
        display: inherit;
    }
    </style>
@section('scripts')
<script>
$(document).ready(function(){
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})
})
</script>
@stop
@endsection