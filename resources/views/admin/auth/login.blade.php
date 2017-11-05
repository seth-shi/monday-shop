@extends('layouts.admin')

@section('style')
    <link href="{{ asset('assets/admin/static/h-ui.admin/css/H-ui.login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main')
    <input type="hidden" id="TenantId" name="TenantId" value="" />
    <div class="header"></div>
    <div class="loginWraper">
        <div id="loginform" class="loginBox">

            @if (session()->has('status'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('status') }}
                </div>
            @endif

            <form class="form form-horizontal" action="{{ url('admin/login') }}" method="post">
                {{ csrf_field() }}

                <div class="row cl {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="" name="name" type="text" placeholder="账号" class="input-text size-L" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{!! $errors->first('name') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row cl {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row cl {{ $errors->has('captcha') ? ' has-error' : '' }}">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe725;</i></label>
                    <div class="formControls col-xs-8">
                        <div style="position: relative;">
                            <input name="captcha" type="text" placeholder="验证码" class="input-text size-L">
                            <img style="position: absolute;top: 0; right: 42px; cursor: pointer;height: 41px;" src="{{captcha_src()}}" onclick="this.src='{{ url("captcha/default") }}?'+Math.random()" alt="验证码"  id="captcha">

                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                <strong>{!! $errors->first('captcha') !!}</strong>
                            </span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input type="submit" class="btn btn-success radius size-L" style="width: 100%" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/static/h-ui/js/H-ui.min.js') }}"></script>
@endsection