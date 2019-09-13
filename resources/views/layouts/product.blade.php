<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>商品页面</title>


    <!-- Bootstrap -->
    <link href="/assets/shop/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/assets/shop/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="/assets/shop/css/base.css" rel="stylesheet">
    <link href="/assets/shop/css/style.css" rel="stylesheet">

    <link href="/assets/user/AmazeUI-2.4.2/assets/css/admin.css" rel="stylesheet" type="text/css">
    <link href="/assets/user/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css">
    <link href="/assets/user/basic/css/demo.css" rel="stylesheet" type="text/css">
    <link href="/assets/user/css/optstyle.css" rel="stylesheet" type="text/css">
    <link href="/assets/user/css/style.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="/assets/user/basic/js/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="/assets/user/basic/js/quick_links.js"></script>

    <script type="text/javascript" src="/assets/user/AmazeUI-2.4.2/assets/js/amazeui.js"></script>
    <script type="text/javascript" src="/assets/user/js/jquery.imagezoom.min.js"></script>
    <script type="text/javascript" src="/assets/user/js/jquery.flexslider.js"></script>

    @yield('style')
</head>

<body>


@include('modules.coupon_code')
@include('modules.notifications')


@include('modules.home.header')
@include('modules.home.search')


@yield('main')

@yield('script')
</body>

</html>
