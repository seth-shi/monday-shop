<!DOCTYPE html>
<!--[if lt IE 9 ]> <html lang="en" dir="ltr" class="no-js ie-old"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" dir="ltr" class="no-js ie9"> <![endif]-->
<!--[if IE 10 ]> <html lang="en" dir="ltr" class="no-js ie10"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="en" dir="ltr" class="no-js">
<!--<![endif]-->
<head>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- META TAGS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile specific meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE TITLE                                -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <title>@yield('title', '星期一 | 一个星期美好的开始')</title>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- SEO METAS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="description" content="星期一网上商城,专业的综合网上购物商城,销售家电、数码通讯、电脑、家居百货、服装服饰、母婴、图书、食品等品牌优质商品.便捷、诚信的服务，为您提供愉悦的网上购物体验!">
    <meta name="black friday, coupon, coupon codes, coupon theme, coupons, deal news, deals, discounts, ecommerce, friday deals, groupon, promo codes, responsive, shop, store coupons">
    <meta name="Keywords" content="网上购物,网上商城,网上买,购物网站,团购,安全购物,电子商务,打折" />

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE FAVICON                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}'">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- GOOGLE FONTS                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Include CSS Filess                        -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->

    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Linearicons -->
    <link href="{{ asset('assets/vendors/linearicons/css/linearicons.css') }}" rel="stylesheet">

    <!-- Owl Carousel -->
    <link href="{{ asset('assets/vendors/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/owl-carousel/owl.theme.min.css') }}" rel="stylesheet">

    <!-- Flex Slider -->
    <link href="{{ asset('assets/vendors/flexslider/flexslider.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('zui/css/zui.css') }}"></script>
    <style>
        .ptb-60 {
            padding-top: 0 !important;
        }
    </style>
</head>

<body id="body" class="wide-layout preloader-active">
<!--[if lt IE 9]>
<p class="browserupgrade alert-error">
    你用<strong>过时</strong>浏览器。请<a href="http://browsehappy.com/">升级您的浏览器</a>来提高你的经验。
</p>
<![endif]-->

<noscript>
    <div class="noscript alert-error">
        对于本网站有必要启用JavaScript的全部功能。这是
        <a href="http://www.enable-javascript.com/" target="_blank">
            说明如何启用JavaScript在Web浏览器中</a>.
    </div>
</noscript>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- 加载动画                                 -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Preloader -->
<div id="preloader" class="preloader">
    <div class="loader-cube">
        <div class="loader-cube__item1 loader-cube__item"></div>
        <div class="loader-cube__item2 loader-cube__item"></div>
        <div class="loader-cube__item4 loader-cube__item"></div>
        <div class="loader-cube__item3 loader-cube__item"></div>
    </div>
</div>
<!-- End Preloader -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- WRAPPER                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<div id="pageWrapper" class="page-wrapper">
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->
<!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

    <!-- –––––––––––––––[ PAGE CONTENT ]––––––––––––––– -->
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <section class="sign-area panel p-40">
                    <h3 class="sign-title">注  册 <small>Or <a href="{{ url('login') }}" class="color-green">登  录</a></small></h3>

                    @if ($errors->all())
                        <div class="alert alert-info with-icon">
                            <i class="icon-ok-sign"></i>
                            <div class="content">{{ $errors->first() }}</div>
                        </div>
                    @endif


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
                                    <input type="text" maxlength="4" class="form-inline input-lg" placeholder="验证码" name="captcha">

                                    <img src="{{captcha_src()}}" onclick="this.src='captcha/default?'+Math.random()" id="captchaCode" alt="" class="captcha">

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
<!-- –––––––––––––––[ END PAGE CONTENT ]––––––––––––––– -->

@include('layouts.area')
<!-- –––––––––––––––[ FOOTER ]––––––––––––––– -->
@include('layouts.footer')
<!-- –––––––––––––––[ END FOOTER ]––––––––––––––– -->

</div>
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- END WRAPPER                               -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->


<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- 回到顶部                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<div id="backTop" class="back-top is-hidden-sm-down">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</div>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- SCRIPTS                                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->

<!-- (!) Placed at the end of the document so the pages load faster -->

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Initialize jQuery library                 -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<script src="{{ asset('assets/js/jquery-1.12.3.min.js') }}"></script>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Latest compiled and minified Bootstrap    -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- JavaScript Plugins                        -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- (!) Include all compiled plugins (below), or include individual files as needed -->

<!-- Modernizer JS -->
<script src="{{ asset('assets/vendors/modernizr/modernizr-2.6.2.min.js') }}"></script>

<!-- Owl Carousel -->
<script type="text/javascript" src="{{ asset('assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>

<!-- FlexSlider -->
<script type="text/javascript" src="{{ asset('assets/vendors/flexslider/jquery.flexslider-min.js') }}"></script>

<!-- Coutdown -->
<script type="text/javascript" src="{{ asset('assets/vendors/countdown/jquery.countdown.js') }}"></script>

<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<!-- Custom Template JavaScript                   -->
<!-- ––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
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
</body>

</html>
