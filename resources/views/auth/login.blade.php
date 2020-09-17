@extends('layouts.user.app')
@section('css')
    <style>
        #footer {
            display: none;
        }
    </style>
@endsection
@section('content')
<div id="login-container" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <div class="panel panel-default">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/register')}}">Register</a>
                    </li>
                </ul>
                <div id="login" class="panel-body">
                    @if (session('msg'))
                        @php
                            $class = (session('status') == 'success' ? 'success' : 'danger' );
                            $fa_class = (session('status') == 'success' ? 'check' : 'ban' );
                            $start_txt = (session('status') == 'success' ? 'Success!' : 'Notice!' );
                        @endphp
                        {{session('error')}}
                        <div class="col-md-8 col-md-offset-2 alert alert-{{$class}} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-{{$fa_class}}"></i> {{$start_txt}}</h4>
                        {{session('msg')}}
                        @if (session('modalshow'))
                            @if(session('status') && session()->has('pagecode'))
                                <script>setTimeout(function(){$("#message_account").modal("hide");},3000);</script>
                            @endif
                            @if(session('status') == 'danger')
                            @else 
                                Welcome, {{ Session::get('display_name')}}!
                                @if(session('status') && session()->has('pagecode'))
                                    <script>setTimeout(function(){$("#message_account").modal("hide");},5000);</script>
                                @endif
                            @endif
                        @endif
                        </div>
                    @endif
                    <form id="login_user" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="customerid" type="email" class="form-control" name="customerid" value="{{ old('customerid') }}">
                                @if ($errors->has('customerid'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('customerid') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="customerpaswd" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="customerpaswd" type="password" class="form-control" name="customerpaswd">
                                @if ($errors->has('customerpaswd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('customerpaswd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4 col-xs-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="rememberme"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 col-xs-6">
                                <button type="submit" class="btn btn-gold btn-primary login-button">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="login-button">
    <button id="login_btn" type="button" class="btn">LOGIN</button>
</div>
@endsection
@section('scripts')
<script>
    $('#login_btn').click(function(){
        $('form#login_user').submit();
    });
</script>
@endsection