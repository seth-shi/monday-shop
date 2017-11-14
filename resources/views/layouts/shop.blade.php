<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>商品页面</title>


    <!-- Bootstrap -->
    <link href="{{ asset('assets/shop/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/shop/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/shop/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/shop/css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/admin.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/basic/css/demo.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/css/optstyle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/user/css/style.css') }}" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="{{ asset('assets/user/basic/js/jquery-1.7.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/user/basic/js/quick_links.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/user/AmazeUI-2.4.2/assets/js/amazeui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/user/js/jquery.imagezoom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/user/js/jquery.flexslider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/user/js/list.js') }}"></script>
</head>

<body>

@include('common.home.header')
@include('common.home.search')


@yield('main')

@yield('script')
</body>

</html>