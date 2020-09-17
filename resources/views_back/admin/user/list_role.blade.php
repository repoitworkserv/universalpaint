@extends('layouts.admin.main')

@section('content')

  <!-- Content Wrapper. Contains page content -->  

  <?php 
    $myPermit = explode(",",Auth::user()->permission);
  ?>

  <section class="content-header">
    <h1>
      Role Management
    </h1>

    @if (session('status'))
        <br>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif
    

  </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="col-xs-2">
                @if(in_array(22, $myPermit))
                <a href="{!! URL::action('Admin\RoleController@create') !!}" class="btn btn-block btn-gold">
                  <i class="fa fa-plus-circle"></i> Add New Role
                </a>
                @endif
              </div>
            </div>

        @if($role_list)

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
                      <th>Role Name</th>
                      <th>Date Created</th>                      
                      <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                      @foreach( $role_list as $role )


                      <tr role="row" class="odd">
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->role_name }}</td>
                        <td>{{ $role->created_at }}</td>                        
                        <td>

                          @if(in_array(23, $myPermit))
                            <a href="{!! URL::action('Admin\RoleController@edit', $role->id) !!}" class="badge bg-orange">
                            <span class="fa fa-edit"></span> Edit
                            </a> &nbsp;
                          @endif

                          @if(in_array(24, $myPermit))
                            <form class="pull-left" style="margin-right:5px;" action="{{ URL::action('Admin\RoleController@destroy', $role->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <a id="alert{{$role->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                            </form>
                          @endif

                        </td>
                      </tr>
						<tr>
	                      <td colspan="4"></td>
	                    </tr>
                      @endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
          

        <!-- /.box-body -->
          <div class="pagination"> {{ $role_list->links() }} </div>
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