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
	<script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
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
	</style>
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
				<li data-id="1" class="pay taobao selected"><img src="{{ asset('images/zhifubao.jpg') }}" />支付宝<span></span></li>
				<li data-id="2" class="pay qq"><img src="{{ asset('images/weizhifu.jpg') }}" />微信<span></span></li>
			</ul>
		</div>
		<div class="clear"></div>

		<!--订单 -->
		<div class="clear"></div>


		<!--信息 -->
		<div class="order-go clearfix">
			<div class="pay-confirm ">
				<div class="box" style="float: none">

					@if ($address)
						<div id="holyshit268" class="pay-address">

							<p class="buy-footer-address">
								<span class="buy-line-title buy-line-title-type">寄送至：</span>
								<span class="buy--address-detail">
													   <span class="province">{{ $address->province }}</span>省
														<span class="city">{{ $address->city }}</span>市
														<span class="dist">{{ $address->region }}</span>区
														<span class="street">{{ $address->detail_address }}</span>
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
						<a href="{{ url('/user/addresses') }}">添加收获地址</a>
					@endif


				</div>

				<form id="post_form">

					{{ csrf_field() }}

					价钱：<input type="text" name="price" autofocus onfocus="this.value=((Math.random()*5+1)/100).toFixed(2)">
					<input type="hidden" name="istype" value="1">
					<input type="hidden" name="orderuid" value="{{ Auth::user()->id }}">
					<input type="hidden" name="goodsname" value="{{ $product->name }}">

					<div id="holyshit269" class="submitOrder">
						<div class="go-btn-wrap">
							<button  id="J_Go" type="button" id="pay_btn" class="btn-go" tabindex="0" title="点击此按钮，提交订单">提交订单</button>
						</div>
					</div>
				</form>

				<form style='display:none;' id='pay_form' method='post' action='https://pay.paysapi.com'>

				</form>

				<div class="clear"></div>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
</div>

@include('common.user.footer')

<div class="clear"></div>

<script>
	$('#pay-list li').click(function () {
		var id = $(this).data('id');
		$('input[name=istype]').val(id);
    });

	$('#J_Go').click(function(){
	    var url = "{{ url('/user/pay/store') }}";
        var data = $('form').serialize();
        var that = $(this);

        that.attr('disabled', true);

        $.post(url, data, function(res){
            that.attr('disabled', false);

            if (res.code != 200) {

                layer.msg(res.msg, {icon:2});
                return false;
			}

			console.log(res.data);
			/*生成表单提交*/
			res = res.data;
            var hidden_input = '';
			for (var i in res) {
			    hidden_input += '<input name="'+ i +'" value="'+ res[i] +'" >';
			}
console.log(res);


			$('#pay_form').html(hidden_input).submit();

		});
	});
</script>
</body>

</html>