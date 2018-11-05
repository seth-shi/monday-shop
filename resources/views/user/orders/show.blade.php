@extends('layouts.user')

@section('style')
    <link href="/assets/user/css/orstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('main')
	<div class="main-wrap">

		<div class="user-orderinfo">

			<!--标题 -->
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">订单详情</strong> / <small>Order&nbsp;details</small></div>
			</div>
			<hr/>
			<!--进度条-->
			<div class="m-progress">
				<div class="m-progress-list">
								<span class="step-1 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                   <p class="stage-name">拍下商品</p>
                                </span>
					<span class="step-2 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">2<em class="bg"></em></i>
                                   <p class="stage-name">卖家发货</p>
                                </span>
					<span class="step-3 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">3<em class="bg"></em></i>
                                   <p class="stage-name">确认收货</p>
                                </span>
					<span class="step-4 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">4<em class="bg"></em></i>
                                   <p class="stage-name">交易完成</p>
                                </span>
					<span class="u-progress-placeholder"></span>
				</div>
				<div class="u-progress-bar total-steps-2">
					<div class="u-progress-bar-inner"></div>
				</div>
			</div>

			<div class="order-infoaside">
				<div class="order-logistics">
					<a href="#">
						<div class="icon-log">
							<i><img src="{{ $order->user->avatar }}"></i>
						</div>
						<div class="latest-logistics">
							<p class="text">订单号：{{ $order->no }}</p>
							<div class="time-list">
								<span class="date">{{ $order->created_at }}</span>
							</div>
						</div>
						<span class="am-icon-angle-right icon"></span>
					</a>
					<div class="clear"></div>
				</div>
				<div class="order-addresslist">
					<div class="order-address">
						<div class="icon-add">
						</div>
						<div class="new-mu_l2a new-p-re">
							<p class="new-mu_l2cw">
								<span class="title">收货地址：</span>
								<span class="street">{{ $order->address }}</span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="order-infomain">

				<div class="order-top">
					<div class="th th-item">
						<td class="td-inner">商品</td>
					</div>
					<div class="th th-price">
						<td class="td-inner">单价</td>
					</div>
					<div class="th th-number">
						<td class="td-inner">数量</td>
					</div>
					<div class="th th-operation">
						<td class="td-inner">商品操作</td>
					</div>
					<div class="th th-amount">
						<td class="td-inner">合计</td>
					</div>
				</div>

				<div class="order-main">

					<div class="order-status3">
						<div class="order-content">
							<div class="order-left">

                                @foreach ($order->details as $detail)
                                    <ul class="item-list">
                                        <li class="td td-item">
                                            <div class="item-pic">
                                                <a href="/products/{{ $detail->product->uuid }}" class="J_MakePoint">
                                                    <img src="{{ $detail->product->thumb }}" class="itempic J_ItemImg">
                                                </a>
                                            </div>
                                            <div class="item-info">
                                                <div class="item-basic-info">
                                                    <a href="/products/{{ $detail->product->uuid }}">
                                                        <p>{!! $detail->product->title !!}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="td td-price">
                                            <div class="item-price">
                                                {{ $detail->product->price }}
                                            </div>
                                        </li>
                                        <li class="td td-number">
                                            <div class="item-number">
                                                <span>×</span>{{ $detail->numbers }}
                                            </div>
                                        </li>
                                        <li class="td td-operation">
                                            <div class="item-operation">
                                                退款/退货
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach

							</div>
							<div class="order-right">
								<li class="td td-amount">
									<div class="item-amount">
										合计：{{ $order->total }}
									</div>
								</li>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
