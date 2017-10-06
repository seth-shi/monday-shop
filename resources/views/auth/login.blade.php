@extends('layouts.master')

@section('style')
    <style>
        .has-error {
            color: red;
        }
    </style>
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <section class="sign-area panel p-40">
                    <h3 class="sign-title">登  录 <small>Or <a href="#" class="color-green">注  册</a></small></h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40" action="{{ url('login') }}" method="post">

                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="sr-only">用户名/邮箱</label>
                                    <input type="text" class="form-control input-lg" name="account" value="{{ old('account') }}" placeholder="用户名 / 邮箱">
                                    <span class="has-error">
                                        {{ $errors->first('account') }}
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">Password</label>
                                    <input type="password" class="form-control input-lg" name="password" placeholder="密码">
                                    <span class="has-error">
                                        {{ $errors->first('password') }}
                                        {{ session()->has('msg')  ? session('msg') : '' }}
                                    </span>

                                </div>
                                <div class="form-group">
                                    <a href="#" class="forgot-pass-link color-green">忘记密码 ?</a>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="remember_account" checked>
                                    <label class="color-mid" for="remember_account">保持登录状态</label>
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">登  录</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>登录 Facebook</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>登录  Twitter</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>登录  Google</button>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="remember_social" checked>
                                    <label class="color-mid" for="remember_social">保持登录状态</label>
                                </div>
                                <div class="text-center color-mid">
                                    需要一个账户 ? <a href="signup.html" class="color-green">创建账户</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection