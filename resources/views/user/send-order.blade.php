<div>
<style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;text-align: left;padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
        .body-message{
            width: 35%;
        }
    </style>
    <div class="body-message">
        <h2>Hello {{$name}},</h2>

        <p>Your transaction has been noted. <br><br>

            Below are the details of your request for quote.
            
        </p>

        <table sytle="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
            <tr>
                <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Product Availed:</th>
                <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Quantity:</th>
                <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Color:</th>
                <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Size:</th>
                <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">price:</th>
            </tr>
            @foreach($requestqoute[0] as $item)
            @php
            $r = \App\Attribute::where('id', $item['colorvar'])->first()['r_attr'];
            $g = \App\Attribute::where('id', $item['colorvar'])->first()['g_attr'];
            $b = \App\Attribute::where('id', $item['colorvar'])->first()['b_attr'];
            $totalprice = (int)$item['volumeprice'] + \App\Product::where('id', $item['productid'])->first()['price'] ;
            @endphp
            <tr>
                <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item['productname']}}</td>
                <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">1</td>
                <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;background-color: rgb({{$r}}, {{$g}}, {{$b}})">{{ \App\Attribute::where('id', $item['colorvar'])->first()['name'] }}</td>
                <td>{{$item['productsize']}}</td>
                <td>{{ $totalprice }}</td>
            </tr>
            @endforeach
        </table>
        <p>
            A sales agent will get in touch with you shortly. <br><br>

            Please feel free to contact (632) 8997-8777 or email <br>
           <a href="mailto:sales@universalpaint.net">sales@universalpaint.net</a>  for any concerns.
        </p>
    </div>

</div>