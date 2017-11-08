@extends('common.home.auth')

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('status') }}
                    </div>
                @endif

                <section class="sign-area panel p-40">
                    <h3 class="sign-title">登  录 <small>Or <a href="{{ route('register') }}" class="color-green">注  册</a></small></h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40 form-horizontal" method="POST" action="{{ route('login') }}">

                                {{ csrf_field() }}

                                <!-- 把回传页也提交 -->
                                <input type="hidden" name="redirect_url" value="{{ request()->input('redirect_url') ?? '/' }}">

                                <div class="form-group {{ $errors->has('account') ? ' has-error' : '' }}">
                                    <label class="sr-only">用户名/邮箱</label>
                                    <input type="text" class="form-control input-lg" name="account" value="{{ old('account') }}" placeholder="用户名 / 邮箱" required autofocus>
                                    @if ($errors->has('account'))
                                        <span class="help-block">
                                            <strong>{!! $errors->first('account') !!}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only">Password</label>
                                    <input type="password" class="form-control input-lg" name="password" placeholder="密码" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <a href="{{ route('password.request') }}" class="forgot-pass-link color-green">忘记密码 ?</a>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" name="remember" id="remember" checked>
                                    <label class="color-mid" for="remember">保持登录状态</label>
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">登  录</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <a href="{{ url('/auth/github') }}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa  fa-github"></i>登录 Github</a>
                                </div>
                                <div class="mb-20">
                                    <a href="{{ url('/auth/qq') }}" class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-qq"></i>登录  QQ</a>
                                </div>
                                <div class="mb-20">
                                    <a href="{{ url('/auth/weibo') }}" class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-weibo"></i>登录  微博</a>
                                </div>

                                <div class="text-center color-mid">
                                    需要一个账户 ? <a href="{{ route('register') }}" class="color-green">创建账户</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
