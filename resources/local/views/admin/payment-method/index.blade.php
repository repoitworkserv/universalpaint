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

  </section><br>

    <div class="col-md-8">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#tab_1" data-toggle="tab" aria-expanded="true">
              <i class="fa fa-credit-card-alt"></i> eGHL
            </a>
          </li>
          <li class="">
            <a href="#tab_2" data-toggle="tab" aria-expanded="false">
              <i class="fa fa-paypal"></i> Paypal
            </a>
          </li>
          <li class="">
            <a href="#tab_3" data-toggle="tab" aria-expanded="false">
              <i class="fa fa-money"></i> Dragonpay
            </a>
          </li>
          <li class="">
            <a href="#tab_4" data-toggle="tab" aria-expanded="false">
              <i class="fa fa-bank"></i> Bank Deposit
            </a>
          </li>        
        </ul>

        <div class="tab-content">

          <div class="tab-pane active" id="tab_1">
            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}

              <input type="hidden" id="method" name="method" value="eghl">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['eghl']['sandbox'])) {
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="enable" name="enable" value="1" data-size="mini" data-onstyle="primary">
              </div>

              <div class="form-group">
                  <label for="name">Sandbox</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['eghl']['sandbox'])) {
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="sandbox" name="sandbox" value="1" data-size="mini" data-onstyle="primary">
              </div>
              <div class="box box-gold"> 
                <h4 class="box-title text-blue">Sandbox</h4>
                <div class="form-group">
                    <label for="merchant_id">Merchant ID</label>
                    <input id="merchant_id" name="merchant_id_sandbox" class="form-control" placeholder="Merchant ID" type="text" required="" value="<?php echo  isset($paymentMethod['eghl']['merchant_id_sandbox']) ? $paymentMethod['eghl']['merchant_id_sandbox'] : '' ; ?>">
                </div>
                <div class="form-group">
                    <label for="stocks">Password/Key</label>
                    <input id="password" name="password_sandbox" class="form-control" placeholder="Password/Key" type="text" required="" value="<?php echo  isset($paymentMethod['eghl']['password_sandbox']) ? $paymentMethod['eghl']['password_sandbox'] : '' ; ?>">
                </div>
              </div>
              <div class="box box-gold"> 
                <h4 class="box-title text-blue">Live</h4>
                <div class="form-group">
                    <label for="merchant_id">Merchant ID</label>
                    <input id="merchant_id" name="merchant_id_live" class="form-control" placeholder="Merchant ID" type="text" required="" value="<?php echo  isset($paymentMethod['eghl']['merchant_id_live']) ? $paymentMethod['eghl']['merchant_id_live'] : '' ; ?>">
                </div>

                <div class="form-group">
                    <label for="stocks">Password/Key</label>
                    <input id="password" name="password_live" class="form-control" placeholder="Password/Key" type="text" required="" value="<?php echo  isset($paymentMethod['eghl']['password_live']) ? $paymentMethod['eghl']['password_live'] : '' ; ?>">
                </div>
              </div>
              <div class="box box-gold">
                <br>
                <div class="form-group">
                  <label for="" >Success Message</label>
                  <textarea id="eghl-success-editor" name="success_message" required class="form-control"><?php echo  isset($paymentMethod['eghl']['success_message']) ? $paymentMethod['eghl']['success_message'] : '' ; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="">Fail Message</label>
                  <textarea id="eghl-fail-editor" name="fail_message" required class="form-control"><?php echo  isset($paymentMethod['eghl']['fail_message']) ? $paymentMethod['eghl']['fail_message'] : '' ; ?></textarea>
                </div> 
              </div>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
            </form>
          </div>
          
          <!-- /.tab-pane -->


          <div class="tab-pane" id="tab_2">

            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}

              <input type="hidden" id="method" name="method" value="paypal">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['paypal']['enable'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="enable" name="enable" value="1" data-size="mini" data-onstyle="primary">
              </div>
              
              <div class="form-group">
                  <label for="name">Sandbox</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['paypal']['sandbox'])){
                        $myStatus = 'checked';
                    }
                  @endphp
                  <input {{ $myStatus }} data-toggle="toggle" type="checkbox" id="sandbox" name="sandbox" value="1" data-size="mini" data-onstyle="primary">
              </div>

              <div class="form-group">
                  <label for="email">Email </label>
                  <input id="email" name="email" class="form-control" placeholder="Paypal Email" type="email" required="" value="<?php echo  isset($paymentMethod['paypal']['email']) ? $paymentMethod['paypal']['email'] : '' ; ?>">
              </div>

              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>

            </form>

          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="tab_3">

            <form action="{{ URL::action('Admin\PaymentMethodController@store') }}" method="post" accept-charset="UTF-8">  

              {{ csrf_field() }}

              <input type="hidden" id="method" name="method" value="dragonpay">

              <div class="form-group">
                  <label for="name">Enable</label>
                  @php
                    $myStatus = '';
                    if(isset($paymentMethod['dragonpay']['sandbox'])){
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

            <div class="box box-gold">
              <br>
               <div class="form-group">
                <label for="" >Success Message</label>
                  <textarea id="dragon-success-editor" name="success_message" required class="form-control"><?php echo  isset($paymentMethod['dragonpay']['success_message']) ? $paymentMethod['dragonpay']['success_message'] : '' ; ?></textarea>
                </div>

                <div class="form-group">
                  <label for="">Fail Message</label>
                  <textarea id="dragon-fail-editor" name="fail_message" required class="form-control"><?php echo  isset($paymentMethod['dragonpay']['fail_message']) ? $paymentMethod['dragonpay']['fail_message'] : '' ; ?></textarea>
                </div> 
            </div>

              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>

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

               <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
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