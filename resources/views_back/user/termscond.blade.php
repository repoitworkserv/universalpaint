@extends('layouts.user.app')

@section('content')

<div id="products">
    <div class="page-header">
        <div class="page-title">TERMS AND CONDITION</div>       
    </div>
    <div class="row">
        
        <div class="col-lg-12">            
           
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    {!! $TermsCond[0]->description !!}
                </div>
                
            </div>


        </div>
    </div>
</div>
@endsection


@section('scripts')

@stop
