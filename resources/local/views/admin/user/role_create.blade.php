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
          <i class="fa fa-plus-circle"></i> Create New Role
        </h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      
      <form action="{{ URL::action('Admin\RoleController@store') }}" method="post" accept-charset="UTF-8">  

        {!! csrf_field() !!}

        <div class="box-body">
          
          <div class="row">
            
            <div class="col-lg-8">
              <div class="form-group">
                <label for="name">Role Name</label>
                <input id="role_name" name="role_name" value="{{old('role_name')}}" class="form-control" placeholder="Enter Dis" type="text" required>
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