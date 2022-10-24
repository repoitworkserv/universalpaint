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

    <?php 
      $myPermit = explode(",",Auth::user()->permission);
    ?>

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
            $DivUser = "";
            $DivAdmin = "";
            $Permission = explode(",",$RoleID->permission);
            if(strpos($RoleID->role_name, 'Customer') !== false){
              $DivAdmin = "hide";
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
                  <div class="panel-heading">Dashboard</div>
                  <div class="panel-body">
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="1" <?=(in_array(1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Orders</div>
                  <div class="panel-body">
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="2.1" <?=(in_array(2.1,$Permission)) ? "checked" : "" ?>> <span>View List</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="2.2" <?=(in_array(2.2,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Master Record</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="3.1" <?=(in_array(3.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="3.2" <?=(in_array(3.2,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="3.3" <?=(in_array(3.3,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="3.4" <?=(in_array(3.4,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Payment Methods</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="4.1" <?=(in_array(4.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="4.2" <?=(in_array(4.2,$Permission)) ? "checked" : "" ?>> <span>Save</span>
                      </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Content Management</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="5.1" <?=(in_array(5.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="5.2" <?=(in_array(5.2,$Permission)) ? "checked" : "" ?>> <span>Add</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="5.3" <?=(in_array(5.3,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="5.4" <?=(in_array(5.4,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Users</div>
                  <div class="panel-body">
                    
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="6.1" <?=(in_array(6.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="6.2" <?=(in_array(6.2,$Permission)) ? "checked" : "" ?>> <span>Create</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="6.3" <?=(in_array(6.3,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                      </div>
                      <div class="col-md-3">
                        <input type="checkbox" name="roleUser[]" value="6.4" <?=(in_array(6.4,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                      </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Settings</div>
                  <div class="panel-body">

                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="7.1" <?=(in_array(7.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="7.2" <?=(in_array(7.2,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="7.3" <?=(in_array(7.3,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">Subscriber</div>
                  <div class="panel-body">

                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="8.1" <?=(in_array(8.1,$Permission)) ? "checked" : "" ?>> <span>View</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="8.2" <?=(in_array(8.2,$Permission)) ? "checked" : "" ?>> <span>Edit</span>
                    </div>
                    <div class="col-md-3">
                      <input type="checkbox" name="roleUser[]" value="8.3" <?=(in_array(8.3,$Permission)) ? "checked" : "" ?>> <span>Delete</span>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div> 

        
        </div>
        <!-- /.box-body -->

        <div class="box-footer text-right">
          @if(in_array(6.3, $myPermit))
          <button type="submit" class="btn btn-gold"><i class="fa fa-save"></i> Save</button>
          @endif
          <a href="{!! URL::action('Admin\RoleController@index') !!}"><button type="button" class="btn btn-default"><i class="fa fa-times-circle"></i> Cancel</button></a>
        </div>
      
      </form>

    </div>
  </div>

@stop

@section('scripts')

@stop