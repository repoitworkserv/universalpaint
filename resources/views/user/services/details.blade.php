@extends('layouts.user.app')

@section('content')

<div id="product">
    <div class="page-header">
        <div class="page-title">SERVICE</div>        
    </div>
    <div class="row">

        <div class="col-lg-10">
            <div class="item-title">{{$servspec[0]->name}}</div>
            <div class="row">
                 {!! $servspec[0]->description !!}
            </div>
        </div>

    </div>
</div>
@endsection
