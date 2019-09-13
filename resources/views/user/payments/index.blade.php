<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title>结算页面</title>

	<link href="/assets/user/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css" />

	<link href="/assets/user/basic/css/demo.css" rel="stylesheet" type="text/css" />
	<link href="/assets/user/css/cartstyle.css" rel="stylesheet" type="text/css" />

	<link href="/assets/user/css/jsstyle.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="/js/payment.js"></script>
	<script src="/assets/user/layer/2.4/layer.js"></script>
	<style>
		input{
			margin: 20px auto;
			padding: 0 10px;
			width: 536px;
			height: 34px;
			border: 1px solid rgba(0,0,0,.8);
			border-radius: 2px;
			font-family: "helvetica neue",arial,sans-serif;
		}
		.submitOrder {
			text-align: center;
		}
		#J_Go {
			display: inline-block;
			padding: 0 26px;
			height: 36px;
			font: 400 18px/36px arial;
			font-size: 18px;
			background-color: #f50;
			color: #fff;
			text-align: center;
			cursor: pointer;
			outline: 0;
			z-index: 999;
		}
	</style>
</head>

<body>

<!--顶部导航条 -->
@include('modules.user.header')


<div class="clear"></div>
<div class="concent">

	@include('hint.validate_errors')
	<!--地址 -->
	<div class="paycont">
		<div class="clear"></div>

		<!--支付方式-->
		<div class="logistics">
			<h3>选择支付方式</h3>
			<ul class="pay-list" id="pay-list">
				<li data-id="1" class="pay taobao selected"><img src="/images/zhifubao.jpg" />支付宝<span></span></li>
				<li disabled="disabled" data-id="2" class="pay qq"><img src="/images/weizhifu.jpg" />微信(暂不支持)<span></span></li>
			</ul>
		</div>


		<!--信息 -->
		<div class="order-go">
			<div class="pay-confirm" style="padding: 20px">
				<div class="box" style="float: none">

					@if ($address)
						<div id="holyshit268" >

							<p class="buy-footer-address">
								<span class="buy-line-title buy-line-title-type">寄送至：</span>
								<span class="buy--address-detail">
														<span class="street">{{ $address->format() }}</span>
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
					@else
						<a href="/user/addresses">添加收获地址</a>
					@endif


				</div>

				<form action="/user/pay/store" method="post">

					{{ csrf_field() }}

					总计：
					<input type="text" class="am-input-sm" value="{{ $product->price * $number }}" disabled="disabled">
					<input type="hidden" name="pay_type" value="1">
					<input type="hidden" name="product_id" value="{{ $product->uuid }}">
					<input type="hidden" name="number" value="{{ $number }}">
					<input type="hidden" name="address_id" value="{{ $address->id }}">

					<div id="holyshit269" class="submitOrder">
						<div class="go-btn-wrap">
							<button name="pay_method" value="web"  id="J_Go" type="submit" class="btn-go" tabindex="0" title="点击此按钮，提交订单">电脑支付</button>
							<button name="pay_method" value="wap"  id="J_Go" type="submit" class="btn-go" tabindex="0" title="点击此按钮，提交订单">手机支付</button>
						</div>
					</div>
				</form>
				<div class="clear"></div>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>


@include('modules.user.footer')

<div class="clear"></div>

<script>
	// $('#pay-list li').click(function () {
	// 	let id = $(this).data('id');
	// 	$('input[name=pay_type]').val(id);
    // });
</script>
</body>

</html>
