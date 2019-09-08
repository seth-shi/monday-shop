@extends('layouts.shop')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
    <style>
        #select_coupon_btn {
            padding: 0 5px;
            border-radius: 10%;
            height: 30px;
            font-size: 13px;
            line-height: 20px;
            background-color: #009688;
            color: #fff;
        }

        .coupon-item .coupon-money em {
            font-size: 2rem;
        }
        .coupon-item .coupon-money .lay:last-child {
            flex: 1;
            padding: 0 3%;
            line-height: 1rem;
        }
        .coupon-item .coupon-money {
            font-size: .8rem;
        }
        .coupon-wrapper .coupon-item .get-btn span {
            font-size: 0.8rem;
        }
        .style-two.have .get-btn span, .style-three.have .get-btn span, .style-six.have .get-btn span, .style-seven.have .get-btn span {
            width: 2.6rem;
        }
    </style>
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <div class="cart-price">
                                <h5 class="t-uppercase mb-20">购物车总价</h5>
                                <ul class="panel mb-20">
                                    <li>
                                        <div class="item-name">
                                            <strong class="t-uppercase">订单总价</strong>
                                        </div>
                                        <div class="price">
                                            <span data-amount="{{ $totalAmount }}" id="total_amount">
                                                {{ $totalAmount }}
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="t-right">
                                    <!-- Checkout Area -->
                                    <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                        <h2 class="h3 mb-20 h-title">支付信息</h2>
                                        @include('hint.status')
                                        <form class="mb-30" id="store_form" method="post">
                                            {{ csrf_field() }}
                                            @foreach ($products as $product)
                                                <input type="hidden" name="ids[]" value="{{ $product->uuid }}">
                                                <input type="hidden" name="numbers[]" value="{{ $product->number }}">
                                            @endforeach
                                            @foreach ($cars as $id)
                                                <input type="hidden" name="cars[]" value="{{ $id }}">
                                            @endforeach

                                            <input type="hidden" name="coupon_id" >

                                            <div class="row">

                                                @include('hint.validate_errors')

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        @if ($addresses->isNotEmpty())
                                                            <select class="form-control" name="address_id">
                                                                <option value="">请选择收货地址</option>
                                                                @foreach ($addresses as $address)
                                                                    <option {{ $address->is_default ? 'selected' : '' }} value="{{ $address->id }}">{{ $address->name }}/{{ $address->phone }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <a style="color: green;" href="/user/addresses">添加收货地址</a>
                                                        @endif
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span style="color: #df3033" id="coupon_show"></span>
                                                    <button type="button" id="select_coupon_btn">选择优惠券</button>
                                                    <hr>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>运费</label>
                                                    <span style="color: green;">+ {{ $postAmount }}</span>
                                                    <hr>
                                                </div>
                                            </div>
                                            <!-- 支付宝支付 -->
                                            <input type="hidden" name="pay_type" value="1">

                                            <button type="submit"  class="btn btn-lg btn-rounded mr-10">去付款</button>
                                        </form>
                                    </section>
                                </div>
                            </div>
                            <h3 class="h-title mb-30 t-uppercase">我的订单</h3>
                            <table id="cart_list" class="cart-list mb-30">
                                <thead class="panel t-uppercase">
                                <tr>
                                    <th style="width: 50%;">商品名字</th>
                                    <th style="width: 15%;">商品图片</th>
                                    <th>商品价格</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                </tr>
                                </thead>
                                <tbody id="cars_data">
                                @foreach ($products as $product)
                                <tr class="panel alert">
                                    <td>
                                        <div class="media-body valign-middle">
                                            <h6 class="title mb-15 t-uppercase">
                                                <a href="/products/{{ $product->uuid }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </td>
                                    <td><img src="{{ assertUrl($product->thumb) }}" alt=""></td>
                                    <td class="prices">{{ $product->price }}</td>
                                    <td>
                                        * {{ $product->number }}
                                    </td>
                                    <td>
                                        {{ $product->total_amount }}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>


    <div id="select_coupon_box"  style="display: none; position: fixed; left: 0; top: 0; width: 100%; background-color: #ddd; z-index: 999;" >
        <div class="row row-masnory row-tb-20">
            <div class="coupon-wrapper">
                <div class="col-sm-6 col-lg-4">

                    <div class="coupon-item">
                        <div style="height: 6rem; " class="style-three">
                            <div class="info-box">
                                <p class="nick">
                                    任性不用优惠券
                                </p>
                                <div class="coupon-money">
                                    <div class="lay of"></div>
                                    <div class="lay">

                                    </div>
                                </div>
                            </div>

                            <a href="javascript:;"
                               style="height: 6rem;"
                               class="get-btn close_btn">
                                <span style="color: green; font-weight: bold">关闭</span>
                            </a>
                        </div>
                    </div>
                </div>
                @foreach ($coupons as $coupon)
                    <div class="col-sm-6 col-lg-4">

                        <div class="coupon-item">
                            <div style="height: 6rem;" class="style-three">
                                <div class="info-box">
                                    <p class="nick">
                                        {{ $coupon->title }}
                                    </p>
                                    <div class="coupon-money">
                                        <div class="lay of">￥<em>{{ $coupon->amount }}</em></div>
                                        <div class="lay">
                                            @if ($coupon->full_amount > 0)
                                                <p class="tit">满{{ $coupon->full_amount }}可用</p>
                                            @else
                                                <p class="tit">无门槛</p>
                                            @endif
                                            <p class="demand"
                                               style="color: #FFB800;">{{ $coupon->start_date }}</p>
                                            <p class="demand"
                                               style="color: #5FB878;">{{ $coupon->end_date }}</p>
                                        </div>
                                    </div>
                                </div>

                                <a href="javascript:;"
                                   data-model='@json($coupon)'
                                   style="height: 6rem;"
                                   class="get-btn use_btn">
                                    <span>使用</span>
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>
        $('#select_coupon_btn').click(function () {
            $('#select_coupon_box').show(500);
            return false;
        });

        $('.close_btn').click(function () {

            $('#select_coupon_box').hide(1000);
        });

        $('#mainContent').click(function () {

            $('#select_coupon_box').hide(1000);
        });

        // 使用优惠券
        $('.use_btn').click(function () {

            var model = $(this).data('model');

            $('#coupon_show').text(model.title + ' -' + model.amount);
            var amount = $('#total_amount').data('amount');
            var showAmount = Number(amount) - Number(model.amount);
            $('#total_amount').text(showAmount.toFixed(2));
            $('#select_coupon_box').hide(1000);

            $('input[name=coupon_id]').val(model.id);
        });


        $('#store_form').submit(function () {

            layer.load();
            $.post('/user/comment/orders', $(this).serialize(), function (res) {

                layer.closeAll();
                if (res.code != 200) {

                    layer.alert(res.msg, {icon: 2});
                    return;
                }

                var orderId = res.data.order_id;

                // 跳去支付
                window.location.href = "/user/pay/orders/"+ orderId +"/again";
            });

            return false;
        });
    </script>
@endsection
