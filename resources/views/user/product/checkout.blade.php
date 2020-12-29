@extends('layouts.user.app')

@section('content')
<div id="checkout-page" class="container container-main">
    <div class="row" style="margin:20px 0;">
        <a href="/cart"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Cart</a>
    </div> 
    {!! csrf_field() !!}
    <div class="row checkout-quote">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <br><br><br><br><br><br>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row con-dtls">
                                        <form action="/" style="width: 100%;">
                                            <div class="contact-form">
                                                <div class="heading">Checkout Details</div>
                                                <div class="c-form">
                                                    <div class="widget-box">
                                                        <div class="label-top">Your Name<span>*</span></div>
                                                        <input type="text" id="fname" name="firstname" placeholder="Your Name Here..">
                                                    </div>
                                                    <div class="widget-box">
                                                        <div class="label-top">Contact Number<span>*</span></div>
                                                        <input type="text" id="cnum" name="contactnum" placeholder="Contact Number Here..">
                                                    </div>
                                                    <div class="widget-box">
                                                        <div class="label-top">Email Address<span>*</span></div>
                                                        <input type="text" id="eadd" name="em" placeholder="Email Address Here">
                                                    </div>
                                                    <div class="widget-box">
                                                        <div class="label-top">Address<span>*</span></div>
                                                        <input type="text" id="add" name="em" placeholder="Complete Address Here">
                                                    </div>
                                                    <div class="widget-box">
                                                        <div class="label-top">Product<span>*</span></div>
                                                        <!-- /.box-header -->
                                                        <div class="box-body">
                                                        <table class="table table-bordered" id="productTable">
                                                            <tbody>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Product Name</th>
                                                                <th>Color</th>
                                                                <th>Volume</th>
                                                                <th>Price</th>
                                                            </tr>
                                                            @if(Session::get('cart'))
                                                                @php 
                                                                    $list = Session::get('cart');
                                                                @endphp
                                                                @foreach($list[0] as $key=>$index)
                                                                @php
                                                                $r = \App\Attribute::where('id', $index['colorvar'])->first()['r_attr'];
                                                                $g = \App\Attribute::where('id', $index['colorvar'])->first()['g_attr'];
                                                                $b = \App\Attribute::where('id', $index['colorvar'])->first()['b_attr'];
                                                                $totalprice = (int)$index['volumeprice'] + \App\Product::where('id', $index['productid'])->first()['price'] ;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{ $index['productname'] }}</td>
                                                                    <td style="background-color: rgb({{$r}}, {{$g}}, {{$b}})">{{ \App\Attribute::where('id', $index['colorvar'])->first()['name'] }}</td>
                                                                    <td>{{ $index['productsize'] }}</td>
                                                                    <td>{{ $totalprice }} </td>
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody></table>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>                                                    
                                                </div>                                                
                                            </div>
                                        </form>                                            
                                    </div>
                                </div>
                                <div class="col-lg-12">

                                    <div class="btn btn-primary send-request" id="btn-checkoutdetails">Checkout</div>
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">

$(document).ready(function (){
	$('.send-request').on('click', function(){
		var _token = $('input[name="_token"]').val(),
		name = $('#fname').val(),cnum = $('#cnum').val(),eadd = $('#eadd').val();
		$.ajax({
		url:"{{ route('sendmail.order') }}",
		method:"POST",
		data:{ name:name,cnum:cnum,eadd:eadd, _token: "{{ csrf_token() }}"},
		success:function(data){

			}
		});
	});
})
</script>
@endsection