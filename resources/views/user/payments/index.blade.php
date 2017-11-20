<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title>结算页面</title>

	<link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('assets/user/basic/css/demo.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/user/css/cartstyle.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('assets/user/css/jsstyle.css') }}" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="{{ asset('js/payment.js') }}"></script>
</head>

<body>

<!--顶部导航条 -->
@include('common.user.header')


<div class="clear"></div>
<div class="concent">
	<!--地址 -->
	<div class="paycont">

		<div class="clear"></div>

		<!--支付方式-->
		<div class="logistics">
			<h3>选择支付方式</h3>
			<ul class="pay-list" id="pay-list">
				<li data-id="2" class="pay qq"><img src="{{ asset('images/weizhifu.jpg') }}" />微信<span></span></li>
				<li data-id="1" class="pay taobao"><img src="{{ asset('images/zhifubao.jpg') }}" />支付宝<span></span></li>
			</ul>
		</div>
		<div class="clear"></div>

		<!--订单 -->
		<div class="clear"></div>


		<!--信息 -->
		<div class="order-go clearfix">
			<div class="pay-confirm ">
				<div class="box">

					<div id="holyshit268" class="pay-address">

						<p class="buy-footer-address">
							<span class="buy-line-title buy-line-title-type">寄送至：</span>
							<span class="buy--address-detail">
								   <span class="province">{{ $address->province }}</span>省
												<span class="city">{{ $address->city }}</span>市
												<span class="dist">{{ $address->region }}</span>区
												<span class="street">{{ $address->detail_address }}/span>
												</span>
							</span>
						</p>
						<p class="buy-footer-address">
							<span class="buy-line-title">收货人：</span>
							<span class="buy-address-detail">
                                         <span class="buy-user">{{ $address->name }} </span>
												<span class="buy-phone">{{ $address->phone }}</span>
												</span>
						</p>
					</div>
				</div>

				<form action="{{ url('/user/pay/store') }}" id="pay_form" method="post">

					{{ csrf_field() }}

					<input type="hidden" name="price" value="0.01">
					<input type="hidden" name="istype" value="1">
					<input type="hidden" name="orderuid" value="{{ Auth::user()->id }}">
					<input type="hidden" name="goodsname" value="{{ $product->name }}">

					<div id="holyshit269" class="submitOrder">
						<div class="go-btn-wrap">
							<button	 id="J_Go" type="submit" class="btn-go" tabindex="0" title="点击此按钮，提交订单">提交订单</button>
						</div>
					</div>
				</form>

				<div class="clear"></div>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
</div>
<div class="footer">
	<div class="footer-hd">
		<p>
			<a href="#">恒望科技</a>
			<b>|</b>
			<a href="#">商城首页</a>
			<b>|</b>
			<a href="#">支付宝</a>
			<b>|</b>
			<a href="#">物流</a>
		</p>
	</div>
	<div class="footer-bd">
		<p>
			<a href="#">关于恒望</a>
			<a href="#">合作伙伴</a>
			<a href="#">联系我们</a>
			<a href="#">网站地图</a>
			<em>© 2015-2025 Hengwang.com 版权所有</em>
		</p>
	</div>
</div>
</div>


<div class="clear"></div>

<script>
	$('#pay-list li').click(function () {
		var id = $(this).data('id');
		$('input[name=istype]').val(id);
    });
</script>
</body>

</html>