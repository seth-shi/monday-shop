@extends('layouts.user')

@section('style')
    <style type="text/css">
        .quiz {
            border: solid 1px #ccc;
            height: 270px;
            width: 772px;
        }

        .quiz h3 {
            font-size: 14px;
            line-height: 35px;
            height: 35px;
            border-bottom: solid 1px #e8e8e8;
            padding-left: 20px;
            background: #f8f8f8;
            color: #666;
            position: relative;
        }

        .quiz_content {
            padding-top: 10px;
            padding-left: 20px;
            position: relative;
            height: 205px;
        }

        .quiz_content .btm {
            border: none;
            width: 100px;
            height: 33px;
            margin: 10px 0 0 64px;
            display: inline;
            cursor: pointer;
        }

        .quiz_content li.full-comment {
            position: relative;
            z-index: 99;
            height: 41px;
        }

        .quiz_content li.cate_l {
            height: 24px;
            line-height: 24px;
            padding-bottom: 10px;
        }

        .quiz_content li.cate_l dl dt {
            float: left;
        }

        .quiz_content li.cate_l dl dd {
            float: left;
            padding-right: 15px;
        }

        .quiz_content li.cate_l dl dd label {
            cursor: pointer;
        }

        .quiz_content .l_text {
            height: 120px;
            position: relative;
            padding-left: 18px;
        }

        .quiz_content .l_text .m_flo {
            float: left;
            width: 47px;
        }

        .quiz_content .l_text .text {
            width: 634px;
            height: 109px;
            border: solid 1px #ccc;
        }

        .quiz_content .l_text .tr {
            position: absolute;
            bottom: -18px;
            right: 40px;
        }

        /*goods-comm-stars style*/

        .goods-comm {
            height: 41px;
            position: relative;
            z-index: 7;
        }

        .goods-comm-stars {
            line-height: 25px;
            padding-left: 12px;
            height: 41px;
            position: absolute;
            top: 0px;
            left: 0;
            width: 400px;
        }

        .goods-comm-stars .star_l {
            float: left;
            display: inline-block;
            margin-right: 5px;
            display: inline;
        }

        .goods-comm-stars .star_choose {
            float: left;
            display: inline-block;
        }

        /* rater star */

        .rater-star {
            position: relative;
            list-style: none;
            margin: 0;
            padding: 0;
            background-repeat: repeat-x;
            background-position: left top;
            float: left;
        }

        .rater-star-item, .rater-star-item-current, .rater-star-item-hover {
            position: absolute;
            top: 0;
            left: 0;
            background-repeat: repeat-x;
        }

        .rater-star-item {
            background-position: -100% -100%;
        }

        .rater-star-item-hover {
            background-position: 0 -48px;
            cursor: pointer;
        }

        .rater-star-item-current {
            background-position: 0 -48px;
            cursor: pointer;
        }

        .rater-star-item-current.rater-star-happy {
            background-position: 0 -25px;
        }

        .rater-star-item-hover.rater-star-happy {
            background-position: 0 -25px;
        }

        .rater-star-item-current.rater-star-full {
            background-position: 0 -72px;
        }

        /* popinfo */

        .popinfo {
            display: none;
            position: absolute;
            top: 30px;
            background: url(/images/infobox-bg.gif) no-repeat;
            padding-top: 8px;
            width: 192px;
            margin-left: -14px;
        }

        .popinfo .info-box {
            border: 1px solid #f00;
            border-top: 0;
            padding: 0 5px;
            color: #F60;
            background: #FFF;
        }

        .popinfo .info-box div {
            color: #333;
        }

        .rater-click-tips {
            font: 12px/25px;
            color: #333;
            margin-left: 10px;
            background: url(/images/infobox-bg-l.gif) no-repeat 0 0;
            width: 125px;
            height: 34px;
            padding-left: 16px;
            overflow: hidden;
        }

        .rater-click-tips span {
            display: block;
            background: #FFF9DD url(/images/infobox-bg-l-r.gif) no-repeat 100% 0;
            height: 34px;
            line-height: 34px;
            padding-right: 5px;
        }

        .rater-star-item-tips {
            background: url(/images/star-tips.gif) no-repeat 0 0;
            height: 41px;
            overflow: hidden;
        }

        .cur.rater-star-item-tips {
            display: block;
        }

        .rater-star-result {
            color: #FF6600;
            font-weight: bold;
            padding-left: 10px;
            float: left;
        }

    </style>
    <style>
        #tab_nav a {
            cursor: pointer;
        }
    </style>
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-order">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">订单管理</strong> / <small>Order</small>
                </div>
            </div>
            <hr/>

            <div class="am-tabs am-tabs-d2 am-margin" data-am-tabs>

                <ul id="tab_nav" class="am-avg-sm-5 am-tabs-nav am-nav am-nav-tabs">
                    <li class="{{ request('tab', 0) == 0 ? 'am-active' : '' }}"><a href="?tab=0">所有订单({{ $ordersCount }})</a></li>
                    <li class="{{ request('tab', 0) == 1 ? 'am-active' : '' }}"><a style="cursor: pointer"
                                                                                   href="?tab=1">待付款({{ $unPayCount }})</a></li>
                    <li class="{{ request('tab', 0) == 2 ? 'am-active' : '' }}"><a href="?tab=2">未发货({{ $shipPendingCount }})</a></li>
                    <li class="{{ request('tab', 0) == 3 ? 'am-active' : '' }}"><a href="?tab=3">待收货({{ $shipDeliveredCount }})</a></li>
                    <li class="{{ request('tab', 0) == 4 ? 'am-active' : '' }}"><a href="?tab=4">待评价({{ $shipReceivedCount }})</a></li>
                </ul>

                @include('hint.validate_errors')
                @include('hint.status')
                @include('hint.fail')

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
                                            <div class="dd-num" style="max-width: 400px">订单编号：<a
                                                        href="/user/orders/{{ $order->id }}"
                                                        style="color: #FF5722;">{{ $order->no }}</a></div>
                                            <span>成交时间：{{ $order->created_at }}</span>
                                            <!--    <em>店铺：小桔灯</em>-->
                                        </div>
                                        <div class="order-content">
                                            <div class="order-left">
                                                @foreach ($order->details as $detail)
                                                    <ul class="item-list">
                                                        <li class="td td-item">
                                                            <div class="item-pic">
                                                                <a href="/products/{{ $detail->product->uuid }}"
                                                                   class="J_MakePoint">
                                                                    <img src="{{ $detail->product->thumb}}"
                                                                         style="width: 80px; height: 80px;"
                                                                         class="itempic J_ItemImg">
                                                                </a>
                                                            </div>
                                                            <div class="item-info" style="float: none;">
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
                                                        {{ $order->amount }}
                                                    </div>
                                                </li>
                                                <li class="td td-status">
                                                    <div class="item-status">
                                                        <p class="Mystatus">{{ $order->status_text }}</p>
                                                    </div>
                                                </li>
                                                <li class="td td-change">
                                                    @foreach ($order->buttons as $button)
                                                        {!! $button !!}
                                                        @if (! $loop->last)
                                                        <hr>
                                                        @endif
                                                    @endforeach
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
    <div id="comment_box" class="quiz" style="display: none; width: 80%;position: fixed; left: 50%; margin-top: 200px; margin-left: -40%;top: 0; background-color: #fff; z-index: 999;">
        <span style="z-index: 1000;position: absolute; top: 10px; right: 10px;cursor: pointer;" id="close_comment_box">X</span>
    <div class="quiz_content">
        <form id="comment_form" method="post">
            <div class="goods-comm">
                <div class="goods-comm-stars">
                    <span class="star_l">满意度：</span>
                    <div id="rate-comm-1" class="rate-comm"></div>
                </div>
            </div>
            <div class="l_text">
                <label class="m_flo">内 容：</label>
                <textarea id="content" class="text" style="width: 90%;"></textarea>
            </div>
            <button id="comment_form_btn" class="btm" type="button" style="color: green;">评论</button>
        </form>
    </div>
    </div>
@endsection

@section('script')
    <script src="/assets/shop/js/jquery-1.12.3.min.js"></script>
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script src="/js/comment.js"></script>
    <script>
        $(function () {

            // 显示可增加多少积分
            $('.comment_btn').each(function () {

                let score = $(this).data('score');

                layer.tips('评价订单预计可得<span style="color: red; font-weight: bold;">' + score + '</span>积分', $(this), {
                    tips: 1,
                    tipsMore: true
                });
            });
        });


        $('#close_comment_box').click(function () {

           $('#comment_box').hide();
        });

        // 评价订单
        var orderId = null;
        $('.comment_btn').click(function () {

            orderId = $(this).data('id');
            $('#comment_box').show(500);
        });
        $('#comment_form_btn').click(function () {

            console.log(orderId);
            if (!orderId) {
                return false;
            }

            var star = $(".rater-star-result").data('star');
            var content = $('#content').val();
            var paramters = {star: star, content: content};
            paramters._token = '{{ csrf_token() }}';

            $.post('/user/orders/' + orderId + '/complete', paramters, function (res) {

                if (res.code != 200) {

                    layer.alert(res.msg, {icon: 2});
                    return;
                }

                layer.msg(res.msg);
                window.location.reload();
            });
        });


        // 确认收货
        $('.confirm_btn').click(function () {

            let id = $(this).data('id');
            let url = "/user/orders/" + id + "/shipped";

            $('#confirm-form').attr('action', url).submit();
        });

        // 退款申请
        $('.refund_btn').click(function () {

            let id = $(this).data('id');
            let url = "/user/pay/orders/" + id + "/refund";

            layer.prompt({title: '请填写退款理由!!!', formType: 2}, function (text, index) {
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
        $('.delete_btn').click(function () {

            let id = $(this).data('id');
            let url = "/user/orders/" + id;

            let form = document.getElementById('delete-form');
            form.action = url;
            form.submit();
        });
    </script>
@endsection
