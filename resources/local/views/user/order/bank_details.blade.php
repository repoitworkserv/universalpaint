@extends('layouts.user.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

          <div class="starter-template">
                <div class="page-header">
    		        <div class="page-title" style="width: 100%">Your order is confirmed!</div>
    		    </div>
            <p class="lead">
            
            @php

            print_r($bank_details)

            @endphp
            
            </p>

             <a href="/" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 60px;">Continue Shopping</a>

          </div>

    </div>
    <div class="col-md-3"></div>
</div>
</div>

@endsection
