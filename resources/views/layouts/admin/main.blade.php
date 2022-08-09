<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow" />
  <title>@yield('title', 'Universal Paint | Admin')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{!! asset('static/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link href="{!! asset('static/font-awesome/css/font-awesome.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="{!! asset('static/Ionicons/css/ionicons.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="{!! asset('static/adminlte/css/AdminLTE.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/jQueryUI/jquery-ui.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/select2/select2.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/slickslider/slick/slick-theme.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link href="{!! asset('static/adminlte/css/skins/skin-blue.min.css') !!}" media="all" rel="stylesheet" type="text/css" />

  <link href="{!! asset('css/admin-style.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/bootstrap-tags-input/bootstrap-tagsinput.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/datepicker/datepicker3.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ URL::asset('img/favicon.jpg') }}" title="Favicon">  
	<script>
		var base_url ="{{URL::to('/')}}";
	</script>
  @yield('styles')

  @php
    $masterRecord = array('category', 'brand', 'variable', 'attribute', 'supplier', 'product', 'shipping'); 
    $contentManagement = array('post', 'page'); 
  @endphp

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{!! asset('static/plugins/summernote/summernote.css') !!}">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/admin/dashboard" class="logo" target="_blank">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Universal Paint</b></span>
      <!-- logo for regular state and mobile devices -->      
      <img src="{!! asset('img/logo.png') !!}" />
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">

            <div class="box-body box-profile">
                @if(!empty($uimage))
									@foreach($uimage as $uimg)
										<img src="{!! asset('img/customer/profile').'/'.$uimg->ImageData['file_name'] !!}" style="display:block; margin: 0 auto;width: 100%;border-radius: 50%;" alt="avatar"/>
									@endforeach
								@else
                <img class="profile-user-img img-responsive img-circle" src="{!! asset('img/users/default.jpg') !!}" alt="User profile picture">
								@endif

              <h4 class="text-muted text-center" style="margin-bottom: 5px;">
              @if (Auth::check())
                {{ Auth::user()->name }}
              @endif
              </h4>
			  <a href="{!! URL::action('Admin\UserController@profile') !!}" class=" btn btn-block text-center"><i class="fa fa-info-circle" style="color:#FFF"></i>  Edit Profile</a>
              <a href="/logout" class="btn btn-block"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
            </div>
            <!-- /.box-body -->
          </div>


      <!-- search form (Optional) -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <li><a href="#"><i class="fa fa-sign-out"></i> <span>LOGOUT</span></a></li>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->      

      <?php 
        $myPermit = explode(",",Auth::user()->permission);
      ?>
      <ul class="sidebar-menu" data-widget="tree">
        @if(in_array(1, $myPermit))
          <li @php echo (Request::segment(2) == 'dashboard') ? "class='active'" : ""; @endphp>
            <a href="{!! URL::action('Admin\DashboardController@index') !!}"><i class="fa fa-credit-card"></i> <span>Dashboard</span></a>
          </li>
        @endif
        @if(in_array(2.1, $myPermit))
        <li @php echo (Request::segment(2) == 'orders') ? "class='active'" : ""; @endphp>
          <a href="{!! URL::action('Admin\OrderController@index') !!}"><i class="fa fa-shopping-cart"></i> <span>Orders</span></a>
        </li>
        @endif
        @if(in_array(3.1, $myPermit))
        <li class="treeview @php echo in_array(Request::segment(2), $masterRecord) ? 'active' : ''; @endphp dropdown">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Master Record</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @php echo (Request::segment(2) == 'category') ? "class='active'" : ""; @endphp><a href="{!! URL::action('Admin\CategoryController@index') !!}"><i class="fa fa-circle-o"></i> Category</a></li>
            <li @php echo (Request::segment(2) == 'brand') ? "class='active'" : ""; @endphp><a href="{!! URL::action('Admin\BrandController@index') !!}"><i class="fa fa-circle-o"></i> Brand</a></li>
            <li  class="treeview dropdown">
            	<a href="#">
            		<i class="fa fa-circle-o"></i> 
            		<span>Variance</span>
            		<span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
            	</a>
            	<ul class="treeview-menu" @php echo (Request::segment(2) == 'variable' || Request::segment(2) == 'attribute') ? 'style="display:block"' : ''; @endphp>
            		<li><a href="{!! URL::action('Admin\VariableController@index') !!}"><i class="fa fa-circle-o"></i> Variable</a></li>
            		<li><a href="{!! URL::action('Admin\AttributeController@index') !!}"><i class="fa fa-circle-o"></i> Attribute</a></li>
            	</ul>
            </li>
            <li @php echo (Request::segment(2) == 'supplier') ? "class='active'" : ""; @endphp><a href="{!! URL::action('Admin\SupplierController@index') !!}"><i class="fa fa-circle-o"></i> Supplier</a></li>
            <li><a href="{!! URL::action('Admin\ProductController@index') !!}"><i class="fa fa-circle-o"></i> Product</a></li>
            <li @php echo (Request::segment(2) == 'shipping') ? "class='active'" : ""; @endphp><a href="{!! URL::action('Admin\ShippingController@index') !!}"><i class="fa fa-circle-o"></i> Shipping</a></li>
          </ul>
        </li>
        @endif

        @if(in_array(4.1, $myPermit))
        <li @php echo (Request::segment(2) == 'payment-method') ? "class='active'" : ""; @endphp>
          <a href="{!! URL::action('Admin\PaymentMethodController@index') !!}"><i class="fa fa-credit-card"></i> <span>Payment Methods</span></a>
        </li>
        @endif
        @if(in_array(5.1, $myPermit))
        <li class="treeview @php echo in_array(Request::segment(2), $contentManagement) ? 'active' : ''; @endphp dropdown">
          <a href="#">
            <i class="fa fa-file-text"></i>
            <span>Content Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @php echo (Request::segment(2) == 'page') ? "class='active'" : ""; @endphp>
              <a href="{!! URL::action('Admin\PageController@index') !!}"><i class="fa fa-circle-o"></i> Page</a>
            </li>
            <li @php echo (Request::segment(2) == 'post') ? "class='active'" : ""; @endphp>
              <a href="{!! URL::action('Admin\PostController@index') !!}"><i class="fa fa-circle-o"></i> Post</a>
            </li>
            <li @php echo (Request::segment(2) == 'post') ? "class='active'" : ""; @endphp>
              <a href="{!! URL::action('Admin\ReviewsandRatingController@index') !!}"><i class="fa fa-circle-o"></i> Reviews and Rating</a>
            </li>
            <li @php echo (Request::segment(2) == 'how-to-paint') ? "class='active'" : ""; @endphp>
              <a href="{!! URL::to('/admin/how-to-paint') !!}"><i class="fa fa-circle-o"></i>How to Paint</a>
            </li>
            <li @php echo (Request::segment(2) == 'email_template') ? "class='active'" : ""; @endphp>
              <a href="{!! URL::action('Admin\EmailTemplateController@index') !!}"><i class="fa fa-circle-o"></i>Email Template</a>
            </li>
          </ul>
        </li>
        @endif
        @if(in_array(6.1, $myPermit))
        <li class="treeview @php echo (Request::segment(2) == 'users') ? 'active' : ''; @endphp dropdown">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{!! URL::action('Admin\UserController@index') !!}"><i class="fa fa-circle-o"></i> Accounts</a></li>
            <li><a href="{!! URL::action('Admin\RoleController@index') !!}"><i class="fa fa-circle-o"></i> Role</a></li>
            <li><a href="{!! URL::action('Admin\UserTypesController@index') !!}"><i class="fa fa-circle-o"></i> Types</a></li>
          </ul>
        </li>
        @endif
        
        @if(in_array(7.1, $myPermit))
        <li @php echo (Request::segment(2) == 'settings') ? "class='active'" : ""; @endphp>
          <a href="{!! URL::action('Admin\SettingsController@index') !!}"><i class="fa fa-cog"></i> <span>Settings</span></a>
        </li>
        @endif
        @if(in_array(8.1, $myPermit))
        <li @php echo (Request::segment(2) == 'subscriber') ? "class='active'" : ""; @endphp>
          <a href="{!! URL::action('Admin\SubscriberController@index') !!}"><i class="fa fa-newspaper-o"></i> <span>Subscriber</span></a>
        </li>
        @endif
        
        


      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">Universal Paint</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>


<div id="rating_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static"> <!-- modal container -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background:#c1c1c1;">
           
            <div class="modal-body">
            	<form action="{{ URL::action('Admin\ReviewsandRatingController@review_ratings') }}" method="post"accept-charset="UTF-8" id="revrating_form" >
            		{!! csrf_field() !!}
	        		<div class="row text-center">
	            		<div class="col-md-12 col-sm-12 col-xs-12">
	            			<div class="form-group">
	            				Are you sure you want to proceed this action?
	            			</div>
	            		</div> 
	            		
	            	</div>
	            	<div class="row text-center">
	            		<div class="col-md-12 col-sm-12 col-xs-12">
	            			<input type="hidden" class="temp_revaction" name="revaction" value="" />
	            			<input type="hidden" class="temp_revid" name="revid" value="" />
	            			<button type="submit" class="btn btn-success">
	            				Yes
	            				
	            			</button>
	            			<div class="btn btn-warning" data-dismiss="modal">
	            				No
	            			</div>
	            		</div> 
	            		
	            	</div>
            	</form>
        	</div>
        </div>
    </div>
</div> <!-- close modal container -->
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script type="text/javascript" src="{{URL::asset('static/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="{{URL::asset('static/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{URL::asset('static/adminlte/js/adminlte.min.js')}}"></script>
<!-- App Admin -->
<script type="text/javascript" src="{{URL::asset('js/app_admin.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('static/plugins/bootstrap-tags-input/bootstrap-tagsinput.js')}}"></script>

<script type="text/javascript" defer="">

window.setTimeout(function() {
  $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
  });
}, 3000);
</script>
<script src="{{URL::asset('static/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<script src="{{URL::asset('static/highchart/highstock.js')}}"></script>
<script src="{{URL::asset('static/highchart/exporting.js')}}"></script>
<script src="{{URL::asset('static/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('static/plugins/slickslider/slick/slick.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('static/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('static/plugins/summernote/summernote.js') }}"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

<script>
	$('#bdate_accnt').datepicker({
		
		 autoclose:true,
	}).on('change',function(e){
		e.stopImmediatePropagation();
		birthday = new Date($(this).val());
		
		var ageDifMs = Date.now() - birthday.getTime();
	    var ageDate = new Date(ageDifMs); // miliseconds from epoch
	    computed_age = Math.abs(ageDate.getUTCFullYear() - 1970);
	    $('#age').val(computed_age);
	});
	
	//Summer note WYSIWYG
	function summernote_txtarea(){
		$('.proddesc, .htu_desc,.delopt_desc,.ovrview_desc, .content_txt,.content_txt_edit').summernote({
      height: 300,
			toolbar: [
                ['headline', ['style']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['textsize', ['fontsize']],
                ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ],
        });
	}
	window.load = summernote_txtarea();
        
  
</script>
@ckeditor('CKBodyText')

@yield('scripts')

</body>
</html>