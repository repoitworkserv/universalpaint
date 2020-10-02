@extends('layouts.user.app')

@section('content')
<div id="checkout-page" class="container container-main">
    <div class="row" style="margin:20px 0;">
        <a href="/cart"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to Cart</a>
    </div> 
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <br><br><br><br><br><br>
                            <h4>Shipping Details</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="b_first_name" id="b_first_name" class="form-control f_valid" placeholder="First Name" value="" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="b_last_name" id="b_last_name" class="form-control f_valid" placeholder="Last Name" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="b_address" id="b_address" class="form-control f_valid" placeholder="Please enter Address" value="" required>
                                                </div>
                                            </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" name="b_email" id="b_email" class="form-control f_valid" placeholder="Please enter Email" value="" required>
                                                    </div>
                                                </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Mobile No.</label>
                                                    <input type="text" name="b_mobile_no" id="b_mobile_no" class="form-control f_valid" placeholder="Please enter your mobile number" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Shipping Area/Region</label>
                                                    <select class="form-control f_valid ship-loc" id="b_city" name="b_city" required>
                                                        <option value="" data-amount="0"></option>
                                                        @foreach($shipping as $list)
                                                             <option value="{{$list->id}}">{{$list->location}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Order Notes</label>
                                                    <textarea class="form-control f_valid" name="b_notes" id="b_notes" rows="3" placeholder="Notes about your order, e.g special note for delivery." required></textarea>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <!-- <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="diff-shipping"> Ship to a different address?
                                        </label>
                                    </div> -->
                                    <div class="btn btn-primary" id="btn-checkoutdetails">Checkout</div>
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-4">
            <div class="row">                    
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Payment Method</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody><tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>&#8369; <span class="shppng-sb-ttl">{{number_format($sub_total, 2)}}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Shipping:</th>
                                        <td class="shppng">&#8369;  </td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td class="shppng-ttl">&#8369; {{number_format($sub_total, 2)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-error"></div>
                            <ul class="list-unstyled">
                                <li><div id="dragonpay-button"></div></li>
                                <li><div id="paypal-button"></div></li>
                            </ul>                  
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

@endsection
@section('scripts')
    <!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
    <script>
        // $('#dragonpay-button').on('click', function() {
        //    var BillingAddress = document.getElementById('b_city').value, ShippingAddress = document.getElementById('s_city').value;
        //     if(BillingAddress  == ''){
        //         $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+'The billing city field is required.'+'</div>');
        //         setTimeout(function(){$('.form-error').fadeOut(); location.reload(); }, 2000);
        //     } else {
        //     	var Token = $('input[name="_token"]').val();
        //         $.ajax({
        //             url: '/checkout-dragonpay',
        //             method: "post",
        //             dataType: "json",
        //             data :{
        //                 billing_first_name: $('input#b_first_name').val(),
        //                 billing_last_name: $('input#b_last_name').val(),
        //                 billing_address: $('input#b_address').val(),
        //                 billing_email: $('input#b_email').val(),
        //                 billing_mobile: $('input#b_mobile_no').val(),
        //                 billing_city: $('select#b_city').val(),
        //                 billing_note: $('#b_notes').val(),
        //                 shipping_first_name: $('input#s_first_name').val(),
        //                 shipping_last_name: $('input#s_last_name').val(),
        //                 shipping_address: $('input#s_address').val(),
        //                 shipping_email: $('input#s_email').val(),
        //                 shipping_mobile: $('input#s_mobile_no').val(),
        //                 shipping_city: $('select#s_city').val(),
        //                 shipping_note: $('#s_notes').val(),
        //                 is_shipping: $('.diff-shipping').prop('checked'),
        //                 _token: Token
        //             },
        //             success: function (data) {                    
        //                 if(data.status == false) {
        //                     $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>');
        //                     setTimeout(function(){$('.form-error').fadeOut() }, 2000);
        //                 } else {
        //                     window.location = data.message;
        //                 }
        //             }
        //         });
        //     }
        // });
        // paypal.Button.render({
        //     env: 'sandbox',
        //     payment: function(data, actions) {
        //         return actions.request.post('/checkout-paypal-create', {
        //             billing_first_name: $('input#b_first_name').val(),
        //             billing_last_name: $('input#b_last_name').val(),
        //             billing_address: $('input#b_address').val(),
        //             billing_email: $('input#b_email').val(),
        //             billing_mobile: $('input#b_mobile_no').val(),
        //             billing_city: $('select#b_city').val(),
        //             billing_note: $('#b_notes').val(),
        //             shipping_first_name: $('input#s_first_name').val(),
        //             shipping_last_name: $('input#s_last_name').val(),
        //             shipping_address: $('input#s_address').val(),
        //             shipping_email: $('input#s_email').val(),
        //             shipping_mobile: $('input#s_mobile_no').val(),
        //             shipping_city: $('select#s_city').val(),
        //             shipping_note: $('#s_notes').val(),
        //             is_shipping: $('.diff-shipping').prop('checked'),
        //         })
        //         .then(function(res) {
        //             // console.log(JSON.parse(res.message));
        //             // res = JSON.parse(res);
        //             // return res.id;
        //             if(res.status == 'failed') {
        //                 // console.log('error');
        //                 $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+res.message+'</div>');
        //              	setTimeout(function(){$('.form-error').fadeOut() }, 2000);
        //             } else {
        //                 res = JSON.parse(res.message);
        //                 return res.id;
        //             }
        //         });
        //     },
        //     onAuthorize: function(data, actions) {
        //         return actions.request.post('/checkout-paypal-execute', {
        //             paymentID: data.paymentID,
        //             payerID:   data.payerID,
        //             billing_first_name: $('input#b_first_name').val(),
        //             billing_last_name: $('input#b_last_name').val(),
        //             billing_address: $('input#b_address').val(),
        //             billing_email: $('input#b_email').val(),
        //             billing_mobile: $('input#b_mobile_no').val(),
        //             billing_city: $('select#b_city').val(),
        //             billing_note: $('#b_notes').val(),
        //             shipping_first_name: $('input#s_first_name').val(),
        //             shipping_last_name: $('input#s_last_name').val(),
        //             shipping_address: $('input#s_address').val(),
        //             shipping_email: $('input#s_email').val(),
        //             shipping_mobile: $('input#s_mobile_no').val(),
        //             shipping_city: $('select#s_city').val(),
        //             shipping_note: $('#b_notes').val(),
        //             is_shipping: $('.diff-shipping').prop('checked'),
        //         })
        //         .then(function(res) {
        //             // console.log(res);
        //             window.location = 'customer/profile';
        //         });
        //     },
        //     style: {
        //     color: 'gold',
        //     shape: 'rect',
        //     size: 'responsive'
        //     },
        // }, '#paypal-button');
        //     $('#shipping-location').on('change', function () {
        //     // console.log($(this).val());
        //     // console.log($(this).find(':selected').data('amount'));
        //     var Token = $('input[name="_token"]').val();
        //     // $('input#shipping-amount').val($(this).find(':selected').data('amount'));
        //     $.ajax({
        //         url: "/get-shipping-rate",
        //         type: "GET",   
        //         dataType: "json",
        //         data: {
        //             location: $(this).val(),
        //             _token: Token
        //         },   
        //         success: function(data){
        //             $('input#shipping-amount').val(data);
        //             $('.total-amount').html('&#8369; ' + addCommas((parseFloat(data) + parseFloat($('input.sub-total').val())).toFixed(2)));
        //         }
        //     });
        // })

        $('#btn-checkoutdetails').on('click', function(){
            // var BillingAddress = document.getElementById('b_city').value;
            // if(BillingAddress  == ''){
            //     $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+'The billing city field is required.'+'</div>');
            //     setTimeout(function(){$('.form-error').fadeOut(); location.reload(); }, 2000);
            // } else {

            // }
            var Token = $('input[name="_token"]').val();
            $.ajax({
            url: '/checkout-details',
            method: "post",
            dataType: "json",
            data :{
                billing_first_name: $('input#b_first_name').val(),
                billing_last_name: $('input#b_last_name').val(),
                billing_address: $('input#b_address').val(),
                billing_email: $('input#b_email').val(),
                billing_mobile: $('input#b_mobile_no').val(),
                billing_city: $('select#b_city').val(),
                billing_note: $('#b_notes').val(),
                _token: Token
            },
            success: function (data) {                    
                if(data.status == false) {
                    $('.form-error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>');
                    setTimeout(function(){$('.form-error').fadeOut() }, 2000);
                } else {
                    window.location = data.message;
                }
            }
        });
        });
    </script>
@endsection