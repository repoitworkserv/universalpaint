@extends('layouts.user.app')

@section('content')

<div id="how-to-paint" class="container">
    <div class="row">
        <div class="title">HOW TO PAINT</div>
        <p>
            
        </p>
    </div>
    @if(!empty($HowToPaint[0]))
    @foreach($HowToPaint as $howtopaint)
    @if($howtopaint->parent_id == 0)
    <div id="preparation">
        <div class="title-category">{{$howtopaint->title}}</div>
        <div class="accordion">
            @foreach($howtopaint->SubTitles as $subtitle)
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-container" href="#accordion-content-{{$subtitle->id}}">
                       {{$subtitle->title }}
                    </a>
                </div>
                @if(!empty($subtitle->SubTitles[0]))
                <div id="accordion-content-{{$subtitle->id}}" class="accordion-content accordion-body collapse">
                @foreach($subtitle->SubTitles as $subsub)
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-container" href="#accordion-content-{{$subsub->id}}">
                        {{$subsub->title }}
                        </a>
                    </div>
                    <div id="accordion-content-{{$subsub->id}}" class="accordion-content accordion-body collapse">
                    @php
                    $howtopaint_content = \App\HowToPaintContent::where('how_to_paint_id',$subsub->id)->where('status',1)->get();
                    @endphp

                    @if(!empty($howtopaint_content[0]))
                    @foreach($howtopaint_content as $cont)
                    @if(!empty($cont->image))
                    <div class="accordion-inner">
                        <div class="contents">
                            <div class="row">
                                <div class="left col-lg-5 col-md-5 col-sm-5">
                                    <img src="/img/how-to-paint/{{$cont->image}}"/>
                                </div>
                                <div class="right col-lg-7 col-md-7 col-sm-7">
                                    {!! $cont->content !!}
                                </div>   
                            </div>
                        </div>
                    </div>
                    @else 
                    <div class="accordion-inner">
                        {!! $cont->content !!}
                    </div>
                    @endif
                    @endforeach
                    @endif
                    </div>
                @endforeach
                </div>
                @else
                <div id="accordion-content-{{$subtitle->id}}" class="accordion-content accordion-body collapse">
                    @php
                    $howtopaint_content = \App\HowToPaintContent::where('how_to_paint_id',$subtitle->id)->where('status',1)->get();
                    @endphp

                    @if(!empty($howtopaint_content[0]))
                    @foreach($howtopaint_content as $cont)
                    @if(!empty($cont->image))
                    <div class="accordion-inner">
                        <div class="contents">
                            <div class="row">
                                <div class="left col-lg-5 col-md-5 col-sm-5">
                                    <img src="/img/how-to-paint/{{$cont->image}}"/>
                                </div>
                                <div class="right col-lg-7 col-md-7 col-sm-7">
                                    {!! $cont->content !!}
                                </div>   
                            </div>
                        </div>
                    </div>
                    @else 
                    <div class="accordion-inner">
                        {!! $cont->content !!}
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach
    @endif
</div>

@endsection