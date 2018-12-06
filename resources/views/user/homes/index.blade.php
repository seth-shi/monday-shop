@extends('layouts.user')


@section('main')
    <div class="main-wrap">
        <div class="wrap-left">
            <div class="wrap-list">
                <div class="m-user">
                    <!--个人信息 -->
                    <div class="m-bg"></div>
                    <div class="m-userinfo">
                        <div class="m-baseinfo">
                            <a href="/user/setting">
                                <img src="{{ $user->avatar }}">
                            </a>
                            <em class="s-name">{{ $user->name }}<span class="vip1"></span></em>

                        </div>
                        <div class="m-right">
                            <!--
                            <div class="m-new">
                                <a href="#"><i class="am-icon-bell-o"></i>消息</a>
                            </div>
                            -->
                            <div class="m-address">
                                <a href="/user/addresses" class="i-trigger">我的收货地址</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-container-bottom"></div>

                <!--订单 -->
                <div class="m-order">
                    <div class="s-bar">
                        <i class="s-icon"></i>我的订单
                        <a class="i-load-more-item-shadow" href="/user/orders">全部订单</a>
                    </div>
                    <ul>
                        <li><a href="/cars"><i><img src="/assets/user/images/send.png"/></i><span>购物车<em class="m-num">{{ $user->cars->count() }}</em></span></a></li>

                        <li><a href="/user/orders"><i><img src="/assets/user/images/refund.png"/></i><span>订单<em class="m-num">{{ $user->orders->count() }}</em></span></a></li>
                    </ul>
                </div>

                <!--收藏夹 -->
                <div >
                    <div class="s-bar">我的收藏</div>
                    <div class="s-content">
                        @foreach ($user->likeProducts as $product)
                            <div class="s-item-wrap">
                                <div class="s-item">

                                    <div class="s-pic">
                                        <a href="/products/{{ $product->uuid }}" class="s-pic-link">
                                            <img src="{{ $product->thumb }}" alt="{{ $product->name }}" title="{{ $product->title }}" class="s-pic-img s-guess-item-img">
                                        </a>
                                    </div>
                                    <div class="s-price-box">
                                        <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">{{ $product->price }}</em></span>
                                        <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">{{ $product->original_price }}</em></span>

                                    </div>
                                    <div class="s-title"><a href="/products/{{ $product->uuid }}" title="{{ $product->name }}">{{ $product->name }}</a></div>
                                    <div class="s-extra-box">
                                        <span class="s-sales">销量: {{ $product->safe_count }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="s-more-btn i-load-more-item"><a href="/user/likes">更多</a></div>

                </div>

            </div>
        </div>
        <div class="wrap-right">

            <!-- 日历-->
            <div class="day-list">
                <div class="s-bar">
                    <a class="i-history-trigger s-icon" href="#"></a>我的日历
                    <a class="i-setting-trigger s-icon" href="#"></a>
                </div>
                <div class="s-care s-care-noweather">
                    <div class="s-date">
                        <em>{{ date('d') }}</em>
                        <span>星期 {{ date('N') }}</span>
                        <span>{{ date('Y-m') }}</span>
                    </div>
                </div>
            </div>

            <!--热卖推荐 -->
            <div class="new-goods">
                <div class="s-bar">
                    <i class="s-icon"></i>热卖推荐
                </div>
                <div class="new-goods-info">

                    <a class="shop-info" href="/products/{{ $hotProduct->uuid }}" target="_blank">
                        <div >
                            <img src="{{ $hotProduct->thumb }}" alt="">
                        </div>
                        <span class="one-hot-goods">{{ $hotProduct->price }}</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
