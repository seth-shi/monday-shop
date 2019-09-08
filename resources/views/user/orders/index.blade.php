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
                    <li><a href="#tab3">未发货</a></li>
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
                                            <div class="dd-num" style="max-width: 400px">订单编号：<a href="/user/orders/{{ $order->id }}" style="color: #FF5722;">{{ $order->no }}</a></div>
                                            <span>成交时间：{{ $order->created_at }}</span>
                                            <!--    <em>店铺：小桔灯</em>-->
                                        </div>
                                        <div class="order-content">
                                            <div class="order-left">
                                                @foreach ($order->details as $detail)


                                                    <ul class="item-list">
                                                        <li class="td td-item">
                                                            <div class="item-pic">
                                                                <a href="/products/{{ $detail->product->uuid }}" class="J_MakePoint">
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
                                                        合计：{{ $order->amount }}
                                                    </div>
                                                </li>
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">{{ $order->status_text }}</p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    @if ($order->show_completed_button)

                                                        <a href="/user/orders/{{ $order->id }}/complete/score" class="am-btn am-btn-success anniu complete_btn" data-score="{{ $order->score }}">完成</a>
                                                    @endif
                                                    @if ($order->show_ship_button)
                                                        <a href="javascript:;" data-id="{{ $order->id }}" class="am-btn am-btn-success anniu confirm_btn">确认收货</a>
                                                    @endif
                                                        <hr>
                                                    @if ($order->show_refund_button)
                                                        <a href="javascript:;" data-id="{{ $order->id }}" class="am-btn am-btn-default anniu refund_btn">退款</a>
                                                    @endif

                                                    @if ($order->show_pay_button)
                                                        <a href="/user/pay/orders/{{ $order->id }}/again" class="am-btn am-btn-danger anniu">去付款</a>
                                                    @endif
                                                        <hr>
                                                    @if ($order->show_delete_button)
                                                        <a href="javascript:;" data-id="{{ $order->id }}" class="am-btn am-btn-default anniu delete_btn">删除订单</a>
                                                    @endif

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
                                <form id="confirm-form" action="/" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
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
    <script src="/assets/shop/js/jquery-1.12.3.min.js"></script>
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>
        $(function () {

            // 显示可增加多少积分
            $('.complete_btn').each(function () {

                let score = $(this).data('score');

                layer.tips('完成订单预计可得<span style="color: red; font-weight: bold;">'+score+'</span>积分', $(this),  {tips:1, tipsMore: true});
            });
        });


        // 确认收货
        $('.confirm_btn').click(function () {

            let id = $(this).data('id');
            let url = "/user/orders/"+ id +"/shipped";

            $('#confirm-form').attr('action', url).submit();
        });

        // 退款申请
        $('.refund_btn').click(function () {

            let id = $(this).data('id');
            let url = "/user/pay/orders/"+ id +"/refund";

            layer.prompt({title: '请填写退款理由!!!', formType: 2}, function(text, index){
                layer.close(index);

                $.post(url, {refund_reason: text}, function (res) {

                    if (res.code != 200) {

                        layer.alert(res.msg, {icon: 2});
                        return;
                    }

                    // 刷新页面
                    alert(res.msg);
                    location.reload();
                })
            });
        });

        // 删除订单
       $('.delete_btn').click(function (){

           let id = $(this).data('id');
           let url = "/user/orders/" + id;

           let form = document.getElementById('delete-form');
           form.action = url;
           form.submit();
       });
    </script>
@endsection
