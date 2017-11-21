<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>结算页面</title>

    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/admin.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/basic/css/demo.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/css/jsstyle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/css//sustyle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>


<!--顶部导航条 -->
@include('common.user.header')

<!--悬浮搜索框-->


<div class="take-delivery">
 <div class="status">
     @if ($payment)
        <h2><img src="{{ asset('images/success.jpg') }}">您已成功付款</h2>
        <div class="successInfo">
         <ul>
           <li>付款金额：<em> {{ $payment->price }}/{{ $payment->realprice }}</em></li>
           <div class="user-info">
             <p>商品名：{{ $payment->goodsname }}</p>
           </div>
         </ul>
        </div>
     @else
         <h2><img src="{{ asset('images/error.jpg') }}">支付失败</h2>
         <div class="successInfo">
             请稍后刷新再次尝试
         </div>
     @endif
  </div>
</div>

@include('common.user.footer')


</body>
</html>
