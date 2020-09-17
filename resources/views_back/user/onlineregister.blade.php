<style>
    p, h3 {
        color: gray;
        font-family: 'Open Sans', Arial, sans-serif;
        font-weight: bold;
    }
    #order {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #order td, #order th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #post-content {
        color: gray;
        font-size: x-large;
        text-align: center;
    
    }
    
    #post-title {
        color: #92bc38;
        font-size: x-large;
        text-align: center;
    }
    
    #order tr:nth-child(even){background-color: #f2f2f2;}
    
    #order tr:hover {background-color: #ddd;}
    
    #order th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: ;
      color: white;
      display: block;
        background: #F76003;
        text-align: center;
        border-radius: 19px;
        height: 16%;
        width: 21%;
        color: white;
        margin: auto;
        font-weight: bold;
        font-size: 44px;
        margin-top: 30px;
    }
    </style>
    
    <div class="center" style="margin: auto;border: 1px gray;border-style: ridge;width: 75%;">
        <div class="logo" style=" width: 100%;height: 200px;display: block;">
            <img style="width:100%;hieght: 120px;" src="{{ $message->embed(public_path() . '/img/banner-email.png') }}" alt="">
        </div>    
    
    
        <div class="center"  style="color: black;text-align: center;"><h1>Welcome to easy online shopping!</h1></div>
    
    
        <div class="order-details" style="margin: auto;border: 1px gray;font-weight: 800;font-size: 14px;border-style: ridge;width: 80%;border-radius: 25px;text-align: justify;padding: 30px;color: gray;font-family: 'Asap';">
            <div style="margin:30px">
                <p>Hello <b> {!! ucwords($datas[0]['fullname']) !!}</b></p>
                <p>Thank you for creating a shopping account in EZ DEAL, the easiest e-commerce shopping site.</p>
                <p>You don't need to worry about spending hours looking through and comparing products among merchant stores anymore. EZ DEAL will be your one stop online shopping center for Beauty, Fashion, Home, Storage, Toys and Electronics.</p>
                <p>We look forward to your first easy shopping experience!</p>
                <br />
                <p>Sincerely,</p>
                <p>EZ DEAL Team</p>
            </div>
        </div>
        <h3 class="center" style="margin: auto;border-style: none;padding: 10px;text-align: center;color: gray;font-family: 'Asap';">
            This is a system-generated email. Please do not reply.
        </h3>
        </div>
        <div class="center"  style="margin: auto;color: gray;font-size: x-large;text-align: center;"><a href="{!! URL::to('/') !!}"><button style=" width: 350px;
    height: 100px;
    border-radius: 31px;
    font-size: xx-large;
    color: white;
    background-color: #F76003;
    margin-top: 30px;">Shop Now</button></a></div>
    </div>
    