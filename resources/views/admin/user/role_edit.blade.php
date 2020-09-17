@extends('layouts.admin.main')

@section('styles')
<link href="{!! asset('static/dropzone/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')

  <section class="content-header">
    <h1>
      Role Management
    </h1>
    
    @if (session('status'))
        <br>
        <div class="alert alert-danger">
        {!! nl2br(session('status')) !!}
        </div>
    @endif

  </section>

  <div class="col-md-8 content">
    <div class="box box-gold">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-plus-circle"></i> Edit Role
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      
      <form action="{{ URL::action('Admin\RoleController@update', [$RoleID->id]) }}" method="post" accept-charset="UTF-8">  

        <input type="hidden" value="PATCH" name="_method">
        {!! csrf_field() !!}

        <div class="box-body">
          
          <div class="row">
            
            <div class="col-lg-8 col-sm-8 col-xs-12">
              <div class="form-group">
                <label for="name">Role Name</label>
                <input id="role_name" name="role_name" value="{{$RoleID->role_name}}" class="form-control" placeholder="Enter Dis" type="text">
              </div>
            </div>
          </div>

          <?php
            $DivUser = "hide";
            $DivAdmin = "hide";
            $Permission = array();
            if(strpos($RoleID->role_name, 'Admin') !== false){
              $DivAdmin = "";
              $Permission = explode(",",$RoleID->permission);
            } else {
              $DivUser = "";
            }

            $myDiscount = array();
            if(isset($RoleID->discount)){
              $myDiscount = unserialize($RoleID->discount);
            }
          ?>

          
          
          <div class="row <?=$DivAdmin?> roletype" id="adminControl">
            <div class="form-group">

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Inventory</div>
                  <div class="panel-body">
                   
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="1" <?=(in_array(1,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="2" <?=(in_array(2,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="3" <?=(in_array(3,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="4" <?=(in_array(4,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Product Category</div>
                  <div class="panel-body">
                   
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="5" <?=(in_array(5,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="6" <?=(in_array(6,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="7" <?=(in_array(7,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="8" <?=(in_array(8,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Products</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="9" <?=(in_array(9,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="10" <?=(in_array(10,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="11" <?=(in_array(11,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="12" <?=(in_array(12,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Services</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="25" <?=(in_array(25,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="26" <?=(in_array(26,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="27" <?=(in_array(27,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="28" <?=(in_array(28,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Orders</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="13" <?=(in_array(13,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="14" <?=(in_array(14,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="15" <?=(in_array(15,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="16" <?=(in_array(16,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Payment Method</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="17" <?=(in_array(17,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="18" <?=(in_array(18,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="19" <?=(in_array(19,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="20" <?=(in_array(20,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Users</div>
                  <div class="panel-body">

                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="21" <?=(in_array(21,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="22" <?=(in_array(22,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="23" <?=(in_array(23,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="24" <?=(in_array(24,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                    </div>

                  </div>
                </div>
              </div>

              

             
            </div>
          </div> 

        
        </div>
        <!-- /.box-body -->

        <div class="box-footer text-right">
          <button type="submit" class="btn btn-gold"><i class="fa fa-save"></i> Save</button>
          <a href="{!! URL::action('Admin\RoleController@index') !!}"><button type="button" class="btn btn-default"><i class="fa fa-times-circle"></i> Cancel</button></a>
        </div>
      
      </form>

    </div>
  </div>

@stop

@section('scripts')

@stop