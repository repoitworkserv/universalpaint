@extends('layouts.user.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

      <div class="starter-template">
          @if($refno)
        <div class="page-header">
        <div class="page-title" style="width: 100%"><h4>Thank you for using Dragonpay!</h4></div>
		    </div>
        <p class="lead">
        @if($message)
          @php

          print_r($message)

          @endphp
        @endif
        </p>
      
      	<p> Transaction ID: {{$order_code}}</p>
      	<p> Reference No: {{$refno}}</p>
      
      	<br>
      	<br>

        @else 
        <div class="page-header">
          <div class="page-title" style="width: 100%"><h4>Thank you for placing order with us!</h4></div>
        </div>
        <p class="lead">
        @if($message)
          @php

          print_r($message)

          @endphp
        @endif
        </p>
        <p> Transaction ID: {{$order_code}}</p>
        @endif

         <a href="/" class="btn btn-primary btn-lg btn-block continue-shopping">Continue Shopping</a>

      </div>

    </div>
    <div class="col-md-3"></div>
</div>
</div>


@endsection