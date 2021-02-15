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
    .align-text-center {
        text-align: center;
    }
</style>

<h2 class="align-text-center"></h2>
<div class="align-text-center">
<img src=""/>
</div>
<div class="order-details" style="margin: auto;border: 0px gray;border-style: ridge;width: 80%;border-radius: 3px;text-align: justify;padding: 30px;color: gray;font-family: \'Asap\';font-size: x-large;">
    <div class="center"  style="background-color: #FF5A00; color: white;font-size: x-large;text-align: center;"><h1>Thank you for your order</h1></div>  
    <table border="0" cellpadding="20" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Product Name</th>
            <th>Color</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        @for ($i=0; $i < count($cart); $i++) 
            @foreach($cart[$i]['product_details'] as $key=>$index)
            @php 
            $ctr = 0;
            @endphp
            <tr>
                <td align="center" valign="top" >{{++$ctr}}</td>
                <td align="center" valign="top" >{{ $index['name'] }}</td>
                <td align="center" valign="top" style="background-color: {{$cart[$i]['css_color']}}">{{ $cart[$i]['color_name'] }}</td>
                @php
                $totalprice = $index['is_sale'] ? $index['sale_price'] * $index['qty'] : $index['price'] * $index['qty'];
                @endphp
                <td align="center" valign="top" >{{$index['qty']}}</td>
                <td align="center" valign="top" >{{ $totalprice }} </td>
            </tr>
            @endforeach
        @endfor
        @if($cart)
        <tr>
            <td colspan="3"></td>
            <td align="right" valign="top" >Subtotal</td>
            <td align="center" valign="top" >{{$subtotal}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right" valign="top">Discount</td>
            <td align="center" valign="top">{{$discount}}</td>
            </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right" valign="top">Estimated Shipping</td>
            <td align="center" valign="top">{{$shipping}}</td>
        </tr>
            <td colspan="3"></td>
            <td align="right" valign="top" >Total</td>
            <td align="center" valign="top">{{$total}}</td>
        </tr>
        @endif
        </tbody>

    </table>
<p class="center" style="margin: auto;border-style: none;padding: 10px;text-align: center;color: gray;font-family: \'Asap\';font-size: small;">Powered by iTWorks Global Solutions</p>
</div>
    