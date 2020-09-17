<style>
    * {
        margin: auto;
    }
    img{
        max-width: 100%;
        max-height: 100%;
        display: block; /* remove extra space below image */
    }
    .product-image { width: 200px; }
    .center {
        margin: auto;
        width: 100%;
        margin: auto;
        border-style: none;
        text-align: center;
        color: gray;
        font-family: 'Asap';

    }
    .order-details table {
        text-align: center; 
        margin: auto; 
        width: 100%;
    }
    @media (max-width: 576px) {
        html { font-size: .10px; }
        .product-image { width: 100px; }
    }
    @media (max-width: 768px) {
        html { font-size: 12px; }
    }
    @media (max-width: 992px) {
        html { font-size: 14px; }
    }
    @media (max-width: 1200px) {
        html { font-size: 16px; }

    }
</style>
    
<div class="container col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row">
        <div class="logo col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <img style="width: 1920px;" src="banner-email.png" alt="">
        </div>    
    </div>
    <br>
    <div class="row">
        <div class="logo col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
            <div class="image">
                @if($data['status'] == 'on_process')
                    <div class="center"  style="color: gray;font-size: large;text-align: center;">Awesome! Your order has been <span style="color: #92bc38">confirmed.</span></div>
                    <div style="text-align: center">
                        <img src="{{ $message->embed(public_path() . '/img/on_process.png') }}" alt="">
                    </div>
                @elseif($data['status'] == 'for_shipping')
                    <div class="center" style="color: gray;font-size: large;text-align: center;">Get ready! Your order has been <span style="color: #92bc38">shipped.</span></div>
                    <div style="text-align: center">
                        <img src="{{ $message->embed(public_path() . '/img/for_shipping.png') }}" alt="">
                    </div>
                @else
                    <div class="center"  style="color: gray;font-size: large;text-align: center;">Thank you! Your order has been <span style="color: #92bc38">delivered.</span></div>
                    <div style="text-align: center">
                        <img src="{{ $message->embed(public_path() . '/img/completed.png') }}" alt="">
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="logo col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
            <div class="letter-body">
                <h3>Hello {!! $data['fullname'] !!}</h3>
                <p>Thank you for shopping with EZ Deal!</p>
                <p>Your Order <b>{!! $data['order_code'] !!}</b> has been placed on  {!! $order_details[0]['OrderCheckoutDetailsData'][0]['updated_at']->toDateString() !!} and {!! $order_details[0]['OrderCheckoutDetailsData'][0]['created_at']->toTimeString() !!} via Payment option. We are getting ready to complete your order. Just wait for a notification when it has been shipped and on its way to delivery!</p>
                <p>Deliver To: {!! $data['fullname'] !!}</p>
                <p>Address: {!! $order_details[0]['OrderCheckoutDetailsData'][0]['lot_house_no'] !!} {!! $order_details[0]['OrderCheckoutDetailsData'][0]['city'] !!}{!! $order_details[0]['OrderCheckoutDetailsData'][0]['province'] !!} {!! $order_details[0]['OrderCheckoutDetailsData'][0]['region'] !!}</p>
                <p>Method: {!! $data['payment_type'] !!}</p>
            </div>
        </div>    
    </div>
    <br>
    <div class="row">
        <div class="logo col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
            <div class="image">

            </div>
            @if($data['status'] == 'on_process')
            <div class="order-details">
                <div class="" style="border-top: 1px ridge gray;">
                    <h3>Order Details</h3>
                    <table>
                        <tr>
                            <td>ORDER</td>
                            <td>{!! $data['order_code'] !!}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            @foreach($user_content as $content)
                                @if($data['status'] == $content->type)
                                    <td>{!! $content->post_content !!}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td>Shipping Amount</td>
                            <td>{!! $data['amount_shipping'] !!}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>{!! $data['amount'] !!}</td>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td>{!! $data['amount_total'] !!}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <div class="description">
                                <table>
                                    @foreach($order_details[0]['OrderItemData'] as $order)
                                	<tr>
                                	    <td>
                                			<div class="product-image">
                                    			<img src="{!! $message->embed(public_path() . '/img/products/'.\App\Product::where(['name' => $order->product_name])->value('featured_image')) !!}" alt="">
                                			</div>
                            			</td>
                                	</tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Name</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_name !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Description</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_details !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Quantity</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->quantity !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Discount</div>
                                        </td>
                                        @if($order->discount_type == "fix")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->discount, 2) }} OFF</div></td>
                                        @elseif($order->discount_type =="percentage")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->total_amount, 2) }}</div></td>
                                        @else
                                        <td><div class="product-name"><span>&#8369;</span> {!! number_format($order->total_amount, 2) !!}</div></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Price</div>
                                        </td>
                                        <td>
                                            <div class="product-name"><span>&#8369;</span>{!! number_format($order->price, 2) !!}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="center" style="margin: auto;border: 1px gray;border-style: ridge;width: 45%;"></div>
            @elseif($data['status'] == 'for_shipping')
            <div class="order-details">
                <h3>Hello {!! $data['fullname'] !!}</h3>

                <p>Your Order <b>{!! $data['order_code'] !!} <span>has been shipped.</span></p>
    
                <p>An EZ Deal package from you <b>{!! $data['order_code'] !!}</b> is being shipped to our logistic partner's hub nearest you. <br />(The tracking number and estimated delivery time of your package are listed below.)</p>
                <p>Tracking Number: {!! join('',explode(':',$order_details[0]['OrderCheckoutDetailsData'][0]['created_at']->toTimeString())) !!}-{!! join('',explode('-',$order_details[0]['OrderCheckoutDetailsData'][0]['created_at']->toDateString())) !!}</p>
                <p>Estimated Delivery Time:</p>
                <br>
                <p>You will receive another notification when the delivery has been received</p>
                <div class="image">
                    <div style="text-align: right">
                        <img src="{{ $message->embed(public_path() . '/img/logo-grey.png') }}" alt="">
                    </div>
                </div>
                <div class="" style="border-top: 1px ridge gray;">
                    <table>
                        <tr>
                            <td>ORDER</td>
                            <td>{!! $data['order_code'] !!}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            @foreach($user_content as $content)
                                @if($data['status'] == $content->type)
                                    <td>{!! $content->post_title !!}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td>Shipping Amount</td>
                            <td>{!! $data['amount_shipping'] !!}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>{!! $data['amount'] !!}</td>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td>{!! $data['amount_total'] !!}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="product-image">
                                    <img src="Koala.jpg" alt="">
                                </div>
                            </td>
                            <td>
                            <div class="description">
                                <table>
                                    @foreach($order_details[0]['OrderItemData'] as $order)
                                    <tr>
                                        <td>
                                            <div class="product-name">Name</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_name !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Description</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_details !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Quantity</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->quantity !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Discount</div>
                                        </td>
                                        @if($order->discount_type == "fix")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->discount, 2) }} OFF</div></td>
                                        @elseif($order->discount_type =="percentage")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->total_amount, 2) }}</div></td>
                                        @else
                                        <td><div class="product-name"><span>&#8369;</span> {!! number_format($order->total_amount, 2) !!}</div></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Price</div>
                                        </td>
                                        <td>
                                            <div class="product-name"><span>&#8369;</span>{!! number_format($order->price, 2) !!}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @else
            <div class="order-details">
                <h3>Hello {!! $data['fullname'] !!}</h3>
    
                <p>We Happy to inform you that your <b>{!! $data['order_code'] !!}</b> has been successfully delivered!</p>

                <p>Thank you for chossing EZ Deal for your easy online shopping!</p>
                <br>
                <p>Thank you for choosing EZ Deal for your easy online shopping! We hope that you enjoy your purchase on <a href="{!! URL::to('/') !!}">{!! URL::to('/') !!}</a> and continue to shop with us as a loyal customer.</p>
                <br>
                <p>Are you happy with our products? Write a product review by clicking the button below</p>
                <div class="image">
                    <div style="text-align: right">
                        <img src="{{ $message->embed(public_path() . '/img/logo-grey.png') }}" alt="">
                    </div>
                </div>
                <div class="" style="border-top: 1px ridge gray;">
                    <h3>Order Details</h3>
                    <table>
                        <tr>
                            <td>ORDER</td>
                            <td>{!! $data['order_code'] !!}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            @foreach($user_content as $content)
                                @if($data['status'] == $content->type)
                                    <td>{!! $content->post_title !!}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td>Shipping Amount</td>
                            <td>{!! $data['amount_shipping'] !!}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>{!! $data['amount'] !!}</td>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td>{!! $data['amount_total'] !!}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="product-image">
                                    <img src="Koala.jpg" alt="">
                                </div>
                            </td>
                            <td>
                            <div class="description">
                                <table>
                                    @foreach($order_details[0]['OrderItemData'] as $order)
                                    <tr>
                                        <td>
                                            <div class="product-name">Name</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_name !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Description</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->product_details !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Quantity</div>
                                        </td>
                                        <td>
                                            <div class="product-name">{!! $order->quantity !!}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Discount</div>
                                        </td>
                                        @if($order->discount_type == "fix")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->discount, 2) }} OFF</div></td>
                                        @elseif($order->discount_type =="percentage")
                                        <td><div class="product-name"><span>&#8369;</span> {{ number_format($order->total_amount, 2) }}</div></td>
                                        @else
                                        <td><div class="product-name"><span>&#8369;</span> {!! number_format($order->total_amount, 2) !!}</div></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product-name">Price</div>
                                        </td>
                                        <td>
                                            <div class="product-name"><span>&#8369;</span>{!! number_format($order->price, 2) !!}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
            <p class="center">
                This is a system-generated email. Please do not reply.
            </p>
        </div>
    
    <div class="center">
        @if($data['status'] == 'on_process')
        <p><b>Note:</b><br/>
            In the event that the information you provided is incomplete, a validation may be sent through phone call or SMS as part of EZ Deal's order verification requirement. Please be kind enough to respond if you receive either a call from (02)________ or an SMS from sender ___________. If you do not receive any communication from us your order will automatically be processed for delivery.
            Order validations will be conducted between 8am and 6pm, from Monday to Saturday. Failure to respond to either the call or the SMS will result in order cancellation/s.
            After your order is validated, we will send you another email confirming the shipping of your order.
            </p>
        @else
        
        @endif
    </div>
</div>
    