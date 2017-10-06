@extends('layouts.master')


@section('style')
    <script src="{{ asset('zui/css/zui.css') }}"></script>
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <section class="sign-area panel p-40">
                    <h3 class="sign-title">注  册 <small>Or <a href="{{ url('login') }}" class="color-green">登  录</a></small></h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form id="register_form" class="p-40" action="{{ url('register') }}" method="post">

                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="sr-only">用户名</label>
                                    <input type="text" name="username" class="form-control input-lg" placeholder="用户名" >
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">邮箱</label>
                                    <input type="email" name="email" class="form-control input-lg" placeholder="邮箱" >
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">密码</label>
                                    <input type="password" name="password" class="form-control input-lg" placeholder="密码">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">确认密码</label>
                                    <input type="password" id="confirm_password" class="form-control input-lg" placeholder="确认密码">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">验证码</label>
                                    <input type="text" maxlength="4" class="form-inline input-lg" placeholder="验证码" name="validator_code">
                                    <img style="width: 120px; height: 50px;" src="{{ asset('assets/images/logo.png') }}" alt="">
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="agree_terms">
                                    <label class="color-mid" for="agree_terms">我同意这个使用 <a href="terms_conditions.html" class="color-green">协议</a>.</label>
                                </div>
                                <button type="submit"  class="btn btn-block btn-lg">注册</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>注册 Facebook</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>注册 Twitter</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>通过谷歌注册</button>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="remember_social" checked>
                                    <label class="color-mid" for="remember_social">保持登录状态</label>
                                </div>
                                <div class="text-center color-mid">
                                    已经有账号 ? <a href="{{ url('login') }}" class="color-green">登录</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection


@section('script')
    <script src="{{ asset('zui/js/zui.js') }}"></script>
    <script>
        $('input[name=username]').change(function(){

            var that = $(this);

            $.get('{{ url('api/v1/user') }}', {account:$(this).val()}, function(res){

                if (res.data.length != 0) {
                    tipFocus(that, '用户名已经存在');

                }
            });
        });

        $('input[name=email]').change(function(){

            var that = $(this);

            $.get('{{ url('api/v1/user') }}', {account:$(this).val()}, function(res){

                if (res.data.length != 0) {
                    tipFocus(that, '邮箱已经存在');
                }
            });
        });

        $('#confirm_password').change(function(){

            if ($(this).val() == '') {
                tipFocus($(this), '密码不能为空');
            }

            if ($(this).val() != $('input[name=password]').val()){
                alert('两次密码不一致');
            }
        });

        $('#register_form').submit(function(){

            var ele_code = $('input[name=validator_code]');

            if (ele_code.val() == '') {

                tipFocus(ele_code, '验证码不能为空')
                return false;
            }

            return true;
        });

        function tipFocus(ele, msg)
        {
            ele.tooltip('show', msg);
            ele.val('').focus();
        }
    </script>
@endsection
