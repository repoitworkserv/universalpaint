@extends('layouts.user.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

      <div class="starter-template">
        <div class="page-header">
        <div class="page-title" style="width: 100%"><h4>Thank you for using Dragonpay!</h4></div>
		    </div>
        <p class="lead">
        
        @php

        print_r($message)

        @endphp
        
        </p>
      
      	<p> Transaction ID: {{$txnid}}</p>
      	<p> Reference No: {{$refno}}</p>
      
      	<br>
      	<br>

         <a href="/" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 60px;background: #FF7900;font-size: x-large;">Continue Shopping</a>

      </div>

    </div>
    <div class="col-md-3"></div>
</div>
</div>


@endsection