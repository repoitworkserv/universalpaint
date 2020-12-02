@extends('layouts.user.app')

@section('content')
    <div id="color-swatches-cart"> 
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <p style="font-size: 20px; font-weight: bold;">Mint Scent</p>
                    <div style="background-color: rgb(232, 245, 235); width: 200px; height: 200px;"></div>
                    <div style="margin-top: 10px; margin-bottom: 15px;"><i class="far fa-times-circle" style="color: red;"></i> Remove</div>

                </div>
                <div class="col-9">
                    <p>
                        Select Paint Options to proceed
                    </p>
                    <div style="display: flex;">
                        <h4>1</h4> &nbsp; CHOOSE YOUR UNIVERSAL PAINT PRODUCT
                    </div>

                    <div>
                        PAINTS HERE
                    </div>
                </div>
            </div> 
            <div class="row" style="background-color: #ecf0f1; margin-bottom: 15px;">
                <div class="col-12" style="margin: 10px 0;">
                    <div>
                        Add another paint
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="pull-right btn btn-primary">
                        Request a quote
                     </div>
                </div>
                
            </div>
        </div>
    </div>

@endsection