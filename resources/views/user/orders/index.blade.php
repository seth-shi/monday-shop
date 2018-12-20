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

                @include('hint.validate_errors')
                @include('hint.status')
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
                                                                    <img src="{{ $detail->product->thumb}}" style="width: 80px; height: 80px;" class="itempic J_ItemImg">
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
                                                                <span>×</span>{{ $detail->number }}
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
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">{{ $order->status ? '交易成功' : '未付款' }}</p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    @if ($order->status == \App\Models\Order::PAY_STATUSES['ALI'])
                                                        <a href="/user/pay/orders/{{ $order->id }}/refund" class="am-btn am-btn-danger anniu delete_btn">退款</a>
                                                        <hr>
                                                    @elseif ($order->status == \App\Models\Order::PAY_STATUSES['UN_PAY'])
                                                        <a href="/user/pay/orders/{{ $order->id }}/again" class="am-btn am-btn-danger anniu delete_btn">去付款</a>
                                                        <hr>
                                                    @endif
                                                        <a href="javascript:;" onclick="handleDelete({{ $order->id }})" class="am-btn am-btn-danger anniu delete_btn">删除订单</a>
                                                </li>
                                                <div class="move-right">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <form id="delete-form" action="/" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>


                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
       function handleDelete(id)
       {
           let url = "/user/orders/" + id;

           let form = document.getElementById('delete-form');
           form.action = url;
           form.submit();
       }
    </script>
@endsection
