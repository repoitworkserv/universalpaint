@extends('layouts.admin.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <?php 
    $myPermit = explode(",",Auth::user()->permission);
  ?>


  <section class="content-header">
    <h1>
      User Management
    </h1>

    @if (session('status'))
        <br>
        <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif
    

  </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-gold">
            <div class="box-header">
              <div class="col-xs-2">
                @if(in_array(22, $myPermit))
                  <a href="{!! URL::action('Admin\UserController@create') !!}" class="btn btn-block btn-gold">
                    <i class="fa fa-plus-circle"></i> Add User
                  </a>
                @endif

              </div>
            </div>

        @if($userlist)

        <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>

                <div class="row">
                  <div class="col-sm-12">

                    <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr role="row">
                      <th>ID</th>
                      <th>Customer Id</th>
                      <th>Name</th>
                      <th>Email Address</th>
                      <th>Type</th>
                      <th>Role</th>
                      <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                      @foreach( $userlist as $user )


                      <tr role="row" class="odd">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->customer_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                        	@foreach($utype_list as $key => $utype)
	                          @if($key == $user->users_type_id)
	                            {{ $utype }}
	                          @endif
	                        @endforeach
                        	
                        	
                        </td>
                        <td>
                        @foreach($role_list as $key => $role)
                          @if($key == $user->role_id)
                            {{ $role }}
                          @endif
                        @endforeach  
                        </td>                      
                        <td>
                          @if(in_array(23, $myPermit))
                          <a href="{!! URL::action('Admin\UserController@edit', $user->id) !!}" class="badge bg-orange">
                          <span class="fa fa-edit"></span> Edit
                          </a> &nbsp;
                          @endif

                          @if(in_array(24, $myPermit))
                          <form class="pull-left" style="margin-right:5px;" action="{{ URL::action('Admin\UserController@destroy', $user->id) }}" method="POST">
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                              <a id="alert{{$user->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                          </form>
                          @endif

                        </td>
                      </tr>
                      <tr>
	                      <td colspan="6"></td>
	                    </tr>

                      @endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
          

        <!-- /.box-body -->
          <div class="pagination"> {{ $userlist->links() }} </div>
        </div>

        @endif

      </div>
    
  </div>

</div>
</section>
<!-- /.content-wrapper -->

@stop

@section('scripts')
<script>
    $("a[id*=alert]").on("click", function(){

        if(confirm("Do you want to delete this item?")){
            $(this).parent('form').submit();
        }
        
    });
</script>
@stop