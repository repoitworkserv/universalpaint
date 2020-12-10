<style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
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

        <table>
            <tr>
                <th>Product Availed:</th>
                <th>Quantity:</th>
                <th>Color:</th>
                <th>Size:</th>
            </tr>
            @foreach($requestqoute as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>{{$item['qty']}}</td>
                <td style="background-color: {{ $item['css_color'] }}">{{$item['color_name']}}</td>
                <td></td>
            </tr>
            @endforeach
        </table>
        <p>
            A sales agent will get in touch with you shortly. <br><br>

            Please feel free to contact (632) 8997-8777 or email <br>
           <a href="mailto:sales@universalpaint.net">sales@universalpaint.net</a>  for any concerns.
        </p>
        @php dd($requestqoute); @endphp
    </div>