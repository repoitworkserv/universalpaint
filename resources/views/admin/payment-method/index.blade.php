@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Payment Methods
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif

    <?php 
      $myPermit = explode(",",Auth::user()->permission);
   	?>  

  </section><br>

    <div class="col-md-8">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#tab_1" data-toggle="tab" aria-expanded="false">
              <i class="fa fa-money"></i> Cash On Delivery
            </a>
          </li>   
          <li class="">
            <a href="#tab_2" data-toggle="tab" aria-expanded="false">
              <i class="fa fa-money"></i> Dragonpay
            </a>
          </li>   
        </ul>

        <div class="tab-content">
          <!-- /.tab-pane -->


          <div class="tab-pane active" id="tab_1">

            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}

              <input type="hidden" id="method" name="method" value="cashondelivery">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['cashondelivery']['enable'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="enable" name="enable" value="1" data-size="mini" data-onstyle="primary">
              </div>
              @if(in_array(4.2, $myPermit))
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
              @endif
            </form>

          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="tab_2">

            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}

              <input type="hidden" id="method" name="method" value="dragonpay">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['dragonpay']['enable'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="enable" name="enable" value="1" data-size="mini" data-onstyle="primary">
              </div>
              
              <div class="form-group">
                  <label for="name">Sandbox</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['dragonpay']['sandbox'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="sandbox" name="sandbox" value="1" data-size="mini" data-onstyle="primary">
              </div>

              <div class="form-group">
                  <label for="merchant_id">Merchant Email</label>
                  <input id="email" name="email" class="form-control" placeholder="Email" type="text" required="" value="<?php echo  isset($paymentMethod['dragonpay']['email']) ? $paymentMethod['dragonpay']['email'] : '' ; ?>">
              </div>

            <div class="box box-gold"> 
             
              <h4 class="box-title text-blue">Sandbox</h4>
              

              <div class="form-group">
                  <label for="merchant_id">Merchant ID</label>
                  <input id="merchant_id" name="merchant_id_sandbox" class="form-control" placeholder="Merchant ID" type="text" required="" value="<?php echo  isset($paymentMethod['dragonpay']['merchant_id_sandbox']) ? $paymentMethod['dragonpay']['merchant_id_sandbox'] : '' ; ?>">
              </div>

              <div class="form-group">
                  <label for="stocks">Password/Key</label>
                  <input id="password" name="password_sandbox" class="form-control" placeholder="Password/Key" type="text" required="" value="<?php echo  isset($paymentMethod['dragonpay']['password_sandbox']) ? $paymentMethod['dragonpay']['password_sandbox'] : '' ; ?>">
              </div>
            </div>
            <div class="box box-gold"> 
              <h4 class="box-title text-blue">Live</h4>
              
              <div class="form-group">
                  <label for="merchant_id">Merchant ID</label>
                  <input id="merchant_id" name="merchant_id_live" class="form-control" placeholder="Merchant ID" type="text" required="" value="<?php echo  isset($paymentMethod['dragonpay']['merchant_id_live']) ? $paymentMethod['dragonpay']['merchant_id_live'] : '' ; ?>">
              </div>

              <div class="form-group">
                  <label for="stocks">Password/Key</label>
                  <input id="password" name="password_live" class="form-control" placeholder="Password/Key" type="text" required="" value="<?php echo  isset($paymentMethod['dragonpay']['password_live']) ? $paymentMethod['dragonpay']['password_live'] : '' ; ?>">
              </div>
            </div>

              @if(in_array(4.2, $myPermit))
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
              @endif

            </form>

          </div>


          <div class="tab-pane" id="tab_4">

            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}
              <input type="hidden" id="method" name="method" value="bank_deposit">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['bank_deposit']['enable'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="enable" name="enable" value="1" data-size="mini" data-onstyle="primary">
              </div>

              <div class="form-group">
              <label for="" >Bank Details</label>
                <textarea id="bank-editor" name="details" required class="form-control"><?php echo  isset($paymentMethod['bank_deposit']['details']) ? $paymentMethod['bank_deposit']['details'] : '' ; ?></textarea>
              </div>
                @if(in_array(4.2, $myPermit))
               <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
               @endif
            </form>
          </div>

          <!-- /.tab-pane -->

        </div>
        <!-- /.tab-content -->
      </div>
      <!-- nav-tabs-custom -->
    </div>

@stop

@section('scripts')
<script type="text/javascript">

CKEDITOR.replace("eghl-success-editor");
CKEDITOR.replace("eghl-fail-editor");
CKEDITOR.replace("dragon-success-editor");
CKEDITOR.replace("dragon-fail-editor");
CKEDITOR.replace("bank-editor");

</script>

<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
@stop