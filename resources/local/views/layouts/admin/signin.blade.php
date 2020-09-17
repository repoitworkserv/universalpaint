<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow" />
  <title>@yield('title', 'G&G | Admin Dashboard')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  

  <link href="{!! asset('static/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="{!! asset('static/adminlte/css/AdminLTE.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/adminlte/css/skins/skin-blue.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('static/plugins/iCheck/square/blue.css') !!}" media="all" rel="stylesheet" type="text/css" />
 <link rel="shortcut icon" href="{{ URL::asset('img/favicon.jpg') }}" title="Favicon">
  @yield('styles')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">

@yield('content')

<!-- jQuery 3 -->
<script type="text/javascript" src="{{URL::asset('static/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="{{URL::asset('static/bootstrap/js/bootstrap.min.js')}}"></script>

@yield('scripts')

</body>
</html>
