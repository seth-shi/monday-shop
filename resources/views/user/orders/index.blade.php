@extends('layouts.user')

@section('main')
    <div class="main-wrap">

        <div class="user-order">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">订单管理</strong> / <small>Order</small></div>
            </div>
            <hr/>

            <div class="am-tabs am-tabs-d2 am-margin" data-am-tabs>

                <ul class="am-avg-sm-5 am-tabs-nav am-nav am-nav-tabs">
                    <li class="am-active"><a href="#tab1">所有订单</a></li>
                  {{--  <li><a href="#tab2">待付款</a></li>
                    <li><a href="#tab3">待发货</a></li>
                    <li><a href="#tab4">待收货</a></li>
                    <li><a href="#tab5">待评价</a></li>--}}
                </ul>

                @if (session()->has('status'))
                    <div class="am-alert am-alert-success" data-am-alert>
                        <button type="button" class="am-close">&times;</button>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
                <div class="am-tabs-bd">
                    <div class="am-tab-panel am-fade am-in am-active" id="tab1">
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
                            <div class="th th-status">
                                <td class="td-inner">交易状态</td>
                            </div>
                            <div class="th th-change">
                                <td class="td-inner">交易操作</td>
                            </div>
                        </div>

                        <div class="order-main">
                            <div class="order-list">

                                <!--交易成功-->
                                @foreach ($orders as $order)
                                    <div class="order-status5">
                                        <div class="order-title">
                                            <div class="dd-num" style="max-width: 400px">订单编号：<a href="javascript:;">{{ $order->no }}</a></div>
                                            <span>成交时间：{{ $order->created_at }}</span>
                                            <!--    <em>店铺：小桔灯</em>-->
                                        </div>
                                        <div class="order-content">
                                            <div class="order-left">
                                                @foreach ($order->details as $detail)
                                                    <ul class="item-list">
                                                        <li class="td td-item">
                                                            <div class="item-pic">
                                                                <a href="#" class="J_MakePoint">
                                                                    <img src="{{ $detail->product->thumb }}" style="width: 80px; height: 80px;" class="itempic J_ItemImg">
                                                                </a>
                                                            </div>
                                                            <div class="item-info">
                                                                <div class="item-basic-info">
                                                                    <a href="/products/{{ $detail->product->uuid }}">
                                                                        <p>{{ $detail->product->name }}</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="td td-price">
                                                            <div class="item-price">
                                                                {{ $detail->price }}
                                                            </div>
                                                        </li>
                                                        <li class="td td-number">
                                                            <div class="item-number">
                                                                <span>×</span>{{ $detail->numbers }}
                                                            </div>
                                                        </li>
                                                        <li class="td td-operation">
                                                            <div class="item-operation">

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
                                                <div class="move-right">
                                                    <li class="td td-status">
                                                        <div class="item-status">
                                                            <p class="Mystatus">{{ $order->status ? '交易成功' : '未付款' }}</p>
                                                        </div>
                                                    </li>
                                                    <li class="td td-change">
                                                        <a href="javascript:;" onclick="handleDelete({{ $order->id }})" class="am-btn am-btn-danger anniu delete_btn">删除订单</a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <form id="delete-form" action="/" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                </form>


                            </div>

                        </div>

                    </div>
                    {{--<div class="am-tab-panel am-fade" id="tab2">

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
                            <div class="th th-status">
                                <td class="td-inner">交易状态</td>
                            </div>
                            <div class="th th-change">
                                <td class="td-inner">交易操作</td>
                            </div>
                        </div>

                        <div class="order-main">
                            <div class="order-list">
                                <div class="order-status1">
                                    <div class="order-title">
                                        <div class="dd-num">订单编号：<a href="javascript:;">1601430</a></div>
                                        <span>成交时间：2015-12-20</span>
                                        <!--    <em>店铺：小桔灯</em>-->
                                    </div>
                                    <div class="order-content">
                                        <div class="order-left">
                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">

                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/62988.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>礼盒袜子女秋冬 纯棉袜加厚 韩国可爱 </p>
                                                                <p class="info-little">颜色分类：李清照
                                                                    <br/>尺码：均码</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">

                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-right">
                                            <li class="td td-amount">
                                                <div class="item-amount">
                                                    合计：676.00
                                                    <p>含运费：<span>10.00</span></p>
                                                </div>
                                            </li>
                                            <div class="move-right">
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">等待买家付款</p>
                                                        <p class="order-info"><a href="#">取消订单</a></p>

                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    <a href="pay.html">
                                                        <div class="am-btn am-btn-danger anniu">
                                                            一键支付</div></a>
                                                </li>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="am-tab-panel am-fade" id="tab3">
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
                            <div class="th th-status">
                                <td class="td-inner">交易状态</td>
                            </div>
                            <div class="th th-change">
                                <td class="td-inner">交易操作</td>
                            </div>
                        </div>

                        <div class="order-main">
                            <div class="order-list">
                                <div class="order-status2">
                                    <div class="order-title">
                                        <div class="dd-num">订单编号：<a href="javascript:;">1601430</a></div>
                                        <span>成交时间：2015-12-20</span>
                                        <!--    <em>店铺：小桔灯</em>-->
                                    </div>
                                    <div class="order-content">
                                        <div class="order-left">
                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/62988.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>礼盒袜子女秋冬 纯棉袜加厚 韩国可爱 </p>
                                                                <p class="info-little">颜色分类：李清照
                                                                    <br/>尺码：均码</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-right">
                                            <li class="td td-amount">
                                                <div class="item-amount">
                                                    合计：676.00
                                                    <p>含运费：<span>10.00</span></p>
                                                </div>
                                            </li>
                                            <div class="move-right">
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">买家已付款</p>
                                                        <p class="order-info"><a href="orderinfo.html">订单详情</a></p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    <div class="am-btn am-btn-danger anniu">
                                                        提醒发货</div>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-tab-panel am-fade" id="tab4">
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
                            <div class="th th-status">
                                <td class="td-inner">交易状态</td>
                            </div>
                            <div class="th th-change">
                                <td class="td-inner">交易操作</td>
                            </div>
                        </div>

                        <div class="order-main">
                            <div class="order-list">
                                <div class="order-status3">
                                    <div class="order-title">
                                        <div class="dd-num">订单编号：<a href="javascript:;">1601430</a></div>
                                        <span>成交时间：2015-12-20</span>
                                        <!--    <em>店铺：小桔灯</em>-->
                                    </div>
                                    <div class="order-content">
                                        <div class="order-left">
                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/62988.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>礼盒袜子女秋冬 纯棉袜加厚 韩国可爱 </p>
                                                                <p class="info-little">颜色分类：李清照
                                                                    <br/>尺码：均码</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>
                                        <div class="order-right">
                                            <li class="td td-amount">
                                                <div class="item-amount">
                                                    合计：676.00
                                                    <p>含运费：<span>10.00</span></p>
                                                </div>
                                            </li>
                                            <div class="move-right">
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">卖家已发货</p>
                                                        <p class="order-info"><a href="orderinfo.html">订单详情</a></p>
                                                        <p class="order-info"><a href="logistics.html">查看物流</a></p>
                                                        <p class="order-info"><a href="#">延长收货</a></p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    <div class="am-btn am-btn-danger anniu">
                                                        确认收货</div>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="am-tab-panel am-fade" id="tab5">
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
                            <div class="th th-status">
                                <td class="td-inner">交易状态</td>
                            </div>
                            <div class="th th-change">
                                <td class="td-inner">交易操作</td>
                            </div>
                        </div>

                        <div class="order-main">
                            <div class="order-list">
                                <!--不同状态的订单	-->
                                <div class="order-status4">
                                    <div class="order-title">
                                        <div class="dd-num">订单编号：<a href="javascript:;">1601430</a></div>
                                        <span>成交时间：2015-12-20</span>

                                    </div>
                                    <div class="order-content">
                                        <div class="order-left">
                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>
                                        <div class="order-right">
                                            <li class="td td-amount">
                                                <div class="item-amount">
                                                    合计：676.00
                                                    <p>含运费：<span>10.00</span></p>
                                                </div>
                                            </li>
                                            <div class="move-right">
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">交易成功</p>
                                                        <p class="order-info"><a href="orderinfo.html">订单详情</a></p>
                                                        <p class="order-info"><a href="logistics.html">查看物流</a></p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    <a href="commentlist.html">
                                                        <div class="am-btn am-btn-danger anniu">
                                                            评价商品</div>
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="order-status4">
                                    <div class="order-title">
                                        <div class="dd-num">订单编号：<a href="javascript:;">1601430</a></div>
                                        <span>成交时间：2015-12-20</span>
                                        <!--    <em>店铺：小桔灯</em>-->
                                    </div>
                                    <div class="order-content">
                                        <div class="order-left">
                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/62988.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>礼盒袜子女秋冬 纯棉袜加厚 韩国可爱 </p>
                                                                <p class="info-little">颜色分类：李清照
                                                                    <br/>尺码：均码</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="item-list">
                                                <li class="td td-item">
                                                    <div class="item-pic">
                                                        <a href="#" class="J_MakePoint">
                                                            <img src="../images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
                                                        </a>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-basic-info">
                                                            <a href="#">
                                                                <p>美康粉黛醉美唇膏 持久保湿滋润防水不掉色</p>
                                                                <p class="info-little">颜色：12#川南玛瑙
                                                                    <br/>包装：裸装 </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="td td-price">
                                                    <div class="item-price">
                                                        333.00
                                                    </div>
                                                </li>
                                                <li class="td td-number">
                                                    <div class="item-number">
                                                        <span>×</span>2
                                                    </div>
                                                </li>
                                                <li class="td td-operation">
                                                    <div class="item-operation">
                                                        <a href="refund.html">退款/退货</a>
                                                    </div>
                                                </li>
                                            </ul>


                                        </div>
                                        <div class="order-right">
                                            <li class="td td-amount">
                                                <div class="item-amount">
                                                    合计：676.00
                                                    <p>含运费：<span>10.00</span></p>
                                                </div>
                                            </li>
                                            <div class="move-right">
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">交易成功</p>
                                                        <p class="order-info"><a href="orderinfo.html">订单详情</a></p>
                                                        <p class="order-info"><a href="logistics.html">查看物流</a></p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    <a href="commentlist.html">
                                                        <div class="am-btn am-btn-danger anniu">
                                                            评价商品</div>
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>--}}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
       function handleDelete(id)
       {
           var url = "/user/orders/" + id;

           var form = document.getElementById('delete-form');
           form.action = url;
           form.submit();
       }
    </script>
@endsection
