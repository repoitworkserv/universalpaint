@extends('layouts.user.app')

@section('content')

    

<div id="products">
    
    <section class="content-header">
    @if (session('returndata') == 'success')
        <br>
        <div class="alert alert-success">
        {!! nl2br(session('msg')) !!}
        </div>
    @endif

    @if (session('returndata') == 'error')
        <br>
        <div class="alert alert-danger">
        {!! nl2br(session('msg')) !!}
        </div>
    @endif
  </section>
    
        <ul id="myTab" class="nav nav-tabs"> 
            <li class="active"> 
                <a href="#profile" data-toggle="tab"> Profile </a> 
            </li> 
            <li>
                <a href="#orders" data-toggle="tab"> My Order </a>
            </li> 
        </ul>
    
    <div class="row">
        <div class="col-md-12">

        <div id="myTabContent" class="tab-content"> 
            <div class="tab-pane fade in active" id="profile">
                <form action="{{ URL::action('User\UserPageController@SaveProfile') }}" method="post" accept-charset="UTF-8">

                    {!! csrf_field() !!}

                <div class="row">
                  <div class="col-md-12 error-holder" id="errorHolder">&nbsp;</div>  
                  <div class="col-md-2"></div>
                  <div class="col-md-4 mb-3">

                    <div class="form-group">
                        <label for="prof_company">Company Name</label>
                        <input id="prof_company" name="prof_company" class="form-control" placeholder="Enter company name" type="text" required="" value="{{Auth::user()->companyname}}">
                    </div>

                    <div class="form-group">
                        <label for="prof_name">Full name</label>
                        <input id="prof_name" name="prof_name" class="form-control" placeholder="Enter full name" type="text" required="" value="{{Auth::user()->name}}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="Enter email" required="" readonly value="{{Auth::user()->email}}">
                    </div>

                    <div class="form-group">
                        <label for="prof_mobile">Phone Number</label>
                        <input id="prof_mobile" name="prof_mobile" class="form-control" placeholder="Enter phone number" type="text" required="" value="{{Auth::user()->phonenum}}">
                    </div>

                  </div>
                  <div class="col-md-4 mb-3">

                    <div class="form-group">
                        <label for="prof_address">Address</label>
                        <input id="prof_address" name="prof_address" class="form-control" placeholder="Enter House Number, Building and Street Name" type="text" required="" value="{{Auth::user()->address}}">
                    </div>

                    <div class="form-group">
                        <label for="prof_province">Province</label>
                        <input id="prof_province" name="prof_province" class="form-control" placeholder="Enter province" type="text" required="" value="{{Auth::user()->province}}">
                    </div>
                    
                    <div class="form-group">
                        <label for="prof_city">City/Municipality</label>
                        <input id="prof_city" name="prof_city" class="form-control" placeholder="Enter city" type="text" required="" value="{{Auth::user()->city}}">
                    </div>

                    <div class="form-group">
                        <label for="prof_postalcode">Postal Code</label>
                        <input id="prof_postalcode" name="prof_postalcode" class="form-control" placeholder="Enter Postal Code" type="text" required="" value="{{Auth::user()->postalcode}}">
                    </div>

                  </div>

                </div>

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <div class="input-group">
                          <div class="input-group-append">                            
                            <button class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-arrow-right"></i> Update Info</button>                            
                          </div>
                        </div>
                    </div>
                </div>
                </form>

            </div> 
            <div class="tab-pane fade" id="orders">

                <div id="ordersDetailsModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                      <div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="modal-title">Order Details</h4></div>
                        <div class="panel-body">

                          <table class="table table-responsive table-striped table-bordered" id="keySearchTBL">
                            <thead>
                              <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody id="tblSearchTr">
                               <tr>
                                <td colspan="4"><p class="text-success">Please wait while getting the details...</p></td>
                               </tr>                               
                            </tbody>
                          </table>                          

                        </div>
                        <div class="panel-footer">
                              <button type="button" class="btn btn-primary" id="CloseViewOrder" data-dismiss="modal">Close</button>
                        </div>
                    </div>       
                </div>
                </div>
                
                <table class="table table-hover dataTable" role="grid">
                    <thead>
                        <tr>
                            <th>Date Order</th>
                            <th>Transaction Id</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Quantity</th>
                            <th>Total price</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(!empty($OrderData))
                        @foreach($OrderData as $Orders)
                        <tr>
                            <td>{{$Orders->order_date}}</td>
                            <td>{{$Orders->txn_id}}</td>
                            <td>{{strtoupper($Orders->status)}}</td>
                            <td>{{$Orders->payment_method}}</td>
                            <td>{{$Orders->total_quantity}}</td>
                            <td>{{number_format($Orders->total_price,2)}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-id="{{$Orders->id}}" id="vieworder" data-toggle="modal" data-target="#ordersDetailsModal"><i class="fa fa-shopping-cart"></i>View Details</button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td><p class="text-danger">No Data</p></td>                            
                        </tr>
                        @endif

                        
                    </tbody>
                </table>

            </div>              
        </div>
        </div>
        
    </div>
</div>
@endsection


@section('scripts')

@stop
