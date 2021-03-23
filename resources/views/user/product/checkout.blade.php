@extends('layouts.user.app')
@section('content')
<div id="checkout-page" class="container container-main">
    <div class="row">
        <a href="/cart"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Cart</a>
    </div> 
    <form id="CheckoutForm" action="/order-cod" method="post">
        {!! csrf_field() !!}
        <div class="row checkout-quote">
            <div class="checkout-form col-lg-8 ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row con-dtls">
                                            <form action="/" style="width: 100%;">
                                                <div class="contact-form">
                                                    <div class="heading">Checkout Details</div>
                                                    <div class="c-form">
                                                        <div class="widget-box">
                                                            <div class="label-top">First Name<span>*</span></div>
                                                            <input type="text" id="first_name" name="first_name" placeholder="First Name Here.." required>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Last Name<span>*</span></div>
                                                            <input type="text" id="last_name" name="last_name" placeholder="Last Name Here.." required>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Contact Number<span>*</span></div>
                                                            <input type="text" id="contact_num" name="contact_num" placeholder="Contact Number Here.." required>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Email Address<span>*</span></div>
                                                            <input type="text" id="email_add" name="email_add" placeholder="Email Address Here" required>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Address<span>*</span></div>
                                                            <input type="text" id="complete_add" name="complete_add" placeholder="Complete Address Here" required>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Shipping Area/Region<span>*</span></div>
                                                            <select name="shipping_location" id="shipping_location" value="" required>
                                                            <option value=""> -- Please Select Location ---</option>
                                                            @foreach($shipping_location as $ship) 
                                                            <option value="{{$ship->id}}">{{$ship->location}}</option>
                                                            @endforeach
                                                            </select>
                                                            @foreach($shipping_location as $ship) 
                                                            @if($ship->status)
                                                            <input type="hidden" name="active_shipping[]" class="active-shipping" value="{{$ship->id}}" />
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Shipping Note</div>
                                                            <textarea id="shipping_note" name="shipping_note" placeholder="Shipping notes here..."></textarea>
                                                        </div>
                                                        <div class="widget-box">
                                                            <div class="label-top">Cart Item/s<span>*</span></div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                            <table class="table table-bordered" id="productTable">
                                                            <input type="hidden" name="total_weight" id="total_weight" value="{{$shipping_weight}}" />
                                                                <tbody>
                                                                <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Product Name</th>
                                                                    <th>Color</th>
                                                                    <th>Liter</th>
                                                                    <th>Qty</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                                @for ($i=0; $i < count($cart); $i++) 
                                                                    @foreach($cart[$i]['product_details'] as $key=>$index)
                                                                    @php 
                                                                    $ctr = 0;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{++$ctr}}</td>
                                                                        <td>{{ $index['name'] }}</td>
                                                                        <td style="background-color: {{$cart[$i]['css_color']}}">{{ $cart[$i]['color_name'] }}</td>
                                                                        @php
                                                                        $totalprice = $index['is_sale'] ? $index['sale_price'] * $index['qty'] : $index['price'] * $index['qty'];
                                                                        @endphp
                                                                        <td>{{ $index['liter'] }}</td>
                                                                        <td>{{$index['qty']}}</td>
                                                                        <td>{{ $totalprice }} </td>
                                                                    </tr>
                                                                    @endforeach
                                                                @endfor
                                                            </tbody></table>
                                                            </div>
                                                            <!-- /.box-body -->
                                                        </div>                                                    
                                                    </div>                                                
                                                </div>
                                            </form>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row order-summary">
                    <h6>ORDER SUMMARY</h6>
                    <hr width="100%" size="50" color="gray" noshade> 
                    <div class="row col-lg-12">
                        <div class="col-lg-9">
                            <Label>Subtotal</Label>
                        </div>
                        <div class="col-lg-3">
                            <span id="subtotal"> P{{$sub_total}} </span>
                            <input type="hidden" name="subtotal" value="{{$sub_total}}" />
                        </div>
                    </div>
                    <hr width="100%" size="50" color="gray" noshade> 
                    <div class="row col-lg-12">
                        <div class="col-lg-9">
                            <Label>Discount</Label>
                        </div>
                        <div class="col-lg-3">
                            <span id="discount"> P{{$discount}} </span>
                            <input type="hidden" name="discount" value="{{$discount}}" />
                        </div>
                    </div>
                    <hr width="100%" size="50" color="gray" noshade> 
                    <div class="row col-lg-12">
                        <div class="col-lg-9">
                            <Label>Estimated Shipping</Label>
                        </div>
                        <div class="col-lg-3">
                            <span id="shipping"> TBA </span>
                            <input type="hidden" name="shipping" value="" />
                        </div>
                    </div>
                    <hr width="100%" size="50" color="gray" noshade> 
                    <div class="row col-lg-12">
                        <div class="col-lg-9">
                            <Label>Estimated Total</Label>
                        </div>
                        <div class="col-lg-3">
                            <span id="total"> P{{$total}} </span>
                            <input type="hidden" name="total" value="{{$total}}" />
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 checkout-buttons">
                    <div class="form-error" style="display:none"></div>
                    <button type="submit" class="btn btn-primary send-request" id="btn-checkoutdetails">Cash on Delivery</button>
                    <div id="dragonpay-button"></div>
                    <button class="btn btn-secondary request-quote" id="btn-request-quote">Request a Quote</button>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection
@section('scripts')
<script type="text/javascript">

$(document).ready(function (){
	// $('.send-request').on('click', function(){
	// 	var _token = $('input[name="_token"]').val(),
	// 	name = $('#fname').val(),cnum = $('#cnum').val(),eadd = $('#eadd').val();
	// 	$.ajax({
	// 	url:"{{ route('sendmail.order') }}",
	// 	method:"POST",
	// 	data:{ name:name,cnum:cnum,eadd:eadd, _token: "{{ csrf_token() }}"},
	// 	success:function(data){
    //         location.reload();
	// 		}
	// 	});
	// });

    $('#dragonpay-button').on('click', function() {
        var billing_address = document.getElementById('complete_add').value, 
        shipping_region = document.getElementById('shipping_location').value,
        shipping_location = $('#shipping_location option:selected').text(),
        shipping_fee =  $('input[name=shipping]').val(),
        shipping_msg = "",
        token = $('input[name="_token"]').val(),
        is_active_shipping = 0;

        $('.active-shipping').each(function() {
            if(shipping_region == $(this).val()) {
                is_active_shipping = 1;
            }
        });
        if(billing_address  == ''){
            $('.form-error').show();
            $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+'The Shipping address field is required.'+'</div>');
            setTimeout(function(){$('.form-error').fadeOut();  }, 2000);
        } else if (shipping_region == '') { 
            $('.form-error').show();
            $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+'The Shipping region field is required.'+'</div>');
            setTimeout(function(){$('.form-error').fadeOut();  }, 2000);
        } else if (parseFloat(shipping_fee) <= 0 && shipping_location !== "Metro Manila") {
            $('.form-error').show();
            $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+'Please contact customer service for assistance regarding your shipping fee.'+'</div>');
            setTimeout(function(){$('.form-error').fadeOut(); }, 2000);
        } else if(is_active_shipping == 0) {
            alert('Shipping is not available on your region.');
        } else {
            data = {
                    first_name: $('input#first_name').val(),
                    last_name: $('input#last_name').val(),
                    complete_add: $('input#complete_add').val(),
                    email_add: $('input#email_add').val(),
                    contact_num: $('input#contact_num').val(),
                    shipping_location: $('select#shipping_location').val(),
                    shipping_note: $('#shipping_note').val(),
                    total_weight: $('#total_weight').val(),
                    subtotal: $('input[name=subtotal]').val(),
                    discount: $('input[name=discount]').val(),
                    shipping: shipping_fee,
                    total: $('input[name=total]').val(),
                    _token: token
                };
            //console.log(data);
            $.ajax({
                url: '/checkout-dragonpay',
                method: "post",
                dataType: "json",
                data: data,
                success: function (data) {     
                        console.log(data);           
                    if(data.status == false) {
                        $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>');
                        $('.form-error').fadeIn();
                        setTimeout(function(){$('.form-error').fadeOut() }, 2000);
                    } else {
                        window.location = data.message;
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });

    $('#shipping_location').on('change', function() {
        var shipping_location = $(this).val();
        var total_weight = $('#total_weight').val();
        var  _token = $('input[name=_token').val();
        var is_active_shipping = 0;

        $('.active-shipping').each(function() {
            if(shipping_location == $(this).val()) {
                is_active_shipping = 1;
            }
        });

        if(is_active_shipping == 0) {
            $('#btn-checkoutdetails').hide();
            $('#dragonpay-button').hide();
        } else {
            $('#btn-checkoutdetails').show();
            $('#dragonpay-button').show();
        }
        data = {
            shipping_location,
            total_weight,
            _token,
        }
        if(shipping_location) {
            $.ajax({
                url: '/fetch-shipping-rate',
                method: "post",
                dataType: "json",
                data: data,
                success: function (data) {     
                          console.log(data);           
                    if(data.status == false) {
                        $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Error fetching shipping fee. Please contact customer service for assistance</div>');
                        $('.form-error').fadeIn();
                        setTimeout(function(){$('.form-error').fadeOut() }, 2000);
                    } else {
                        var shipping_fee = parseFloat(data.estimated_shipping).toFixed(2);
                        var subtotal = parseFloat($('#subtotal').text().replace('P','')).toFixed(2);
                        var discount = parseFloat($('#discount').text().replace('P','')).toFixed(2);
                        var total = parseFloat(subtotal) + parseFloat(shipping_fee) - discount;
                        $('#shipping').text(shipping_fee);
                        $('#total').html('P'+total.toFixed(2));
                        $('input[name=shipping]').val(shipping_fee);
                        $('input[name=subtotal]').val(subtotal);
                        $('input[name=total]').val(total.toFixed(2));
                    }
                }
            });
        } 
    });

    $('#btn-checkoutdetails').click(function(e) {
        e.preventDefault();
        var shipping_region = document.getElementById('shipping_location').value,
        is_active_shipping = 0;

        $('.active-shipping').each(function() {
            if(shipping_region == $(this).val()) {
                is_active_shipping = 1;
            }
        });

        if(is_active_shipping) {
            if(confirm('Are you sure you want to place order?')) {
                $('#CheckoutForm').submit();
            }
        } else {
            alert('Shipping is not available on your region.');
        }
    });
    
    $('#btn-request-quote').on('click', function(e){
        e.preventDefault();
		var _token = $('input[name="_token"]').val(),
		name = $('#first_name').val() +' '+ $('#last_name').val(),cnum = $('#contact_num').val(),eadd = $('#email_add').val();

        if(name !== "" && cnum !== "" && eadd !== "") {
            $.ajax({
            url:"{{ route('sendmail.quote') }}",
            method:"POST",
            data:{ name:name,cnum:cnum,eadd:eadd, _token},
            beforeSend: function() {
                alert('Please wait....');
            },
            success:function(data){
                alert(data);
                setTimeout(function(){ window.location = '/'; }, 2000);
            },error: function(xhr, status, error) {
            console.log(xhr.responseText);
                console.log(error);
            }
            });
        } else {
            alert("Please complete required fields!");
        }
	});

})
</script>
@endsection