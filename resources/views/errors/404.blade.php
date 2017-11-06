<!doctype html>
<html lang="en">
<head>
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
        <link rel="apple-touch-icon" href="{{ asset('assets/shop/images/favicon/apple-touch-icon.png') }}">
        <link rel="icon" href="{{ asset('assets/shop/images/favicon/favicon.ico') }}'">

        <!-- ––––––––––––––––––––––––––––––––––––––––– -->
        <!-- GOOGLE FONTS                              -->
        <!-- ––––––––––––––––––––––––––––––––––––––––– -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">

        <!-- ––––––––––––––––––––––––––––––––––––––––– -->
        <!-- Include CSS Filess                        -->
        <!-- ––––––––––––––––––––––––––––––––––––––––– -->

        <!-- Bootstrap -->
        <link href="{{ asset('assets/shop/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="{{ asset('assets/shop/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

        <!-- Linearicons -->
        <link href="{{ asset('assets/shop/vendors/linearicons/css/linearicons.css') }}" rel="stylesheet">

        <!-- Owl Carousel -->
        <link href="{{ asset('assets/shop/vendors/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/shop/vendors/owl-carousel/owl.theme.min.css') }}" rel="stylesheet">

        <!-- Flex Slider -->
        <link href="{{ asset('assets/shop/vendors/flexslider/flexslider.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('assets/shop/css/base.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/shop/css/style.css') }}" rel="stylesheet">
</head>
<body>
<main id="mainContent" class="main-content">
    <div class="page-container pt-40 pb-60">
        <div class="container">
            <section class="error-page-area">
                <div class="container">
                    <div class="error-page-wrapper t-center">
                        <div class="error-page-header">
                            <span class="color-blue">4</span>
                            <span class="color-green">0</span>
                            <span class="color-blue">4</span>
                        </div>
                        <div class="error-page-footer">
                            <h5 class="color-mid mb-5">Oops !</h5>
                            <h2 class="t-uppercase m-10 color-green">
                                {{ $exception->getMessage()  ? $exception->getMessage() : '您访问的页面不存在~ '}}
                            </h2>
                            <p class="color-muted mb-30 font-15">
                                不好意思
                            </p>
                        </div>
                        <a  href="javascript:;" onclick="history.go(-1)" class="btn btn-rounded">返回上一页</a>

                        <!-- 判断当前路由是否是后台的 -->
                        <a href="{{ str_contains(url()->current(), 'admin') ? url('/admin/welcome') : url('/') }}" class="btn btn-rounded">去首页</a>
                    </div>
                </div>
            </section>
        </div>
    </div>


</main>
</body>
</html>

