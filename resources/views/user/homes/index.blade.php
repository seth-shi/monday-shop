@extends('layouts.user')


@section('main')
    <div class="main-wrap">
        <div class="wrap-left">
            <div class="wrap-list">
                <div class="m-user">
                    <!--个人信息 -->
                    @inject('userPresenter', 'App\Presenters\UserPresenter')
                    <div class="m-bg"></div>
                    <div class="m-userinfo">
                        <div class="m-baseinfo">
                            <a href="{{ url('/user/setting') }}">
                                <img src="{{ $userPresenter->getAvatarLink($user->avatar) }}">
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
                                <a href="{{ url('/user/addresses') }}" class="i-trigger">我的收货地址</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-container-bottom"></div>

                <!--订单 -->
                <div class="m-order">
                    <div class="s-bar">
                        <i class="s-icon"></i>我的订单
                        <a class="i-load-more-item-shadow" href="{{ url('/user/orders') }}">全部订单</a>
                    </div>
                    <ul>
                        <li><a href="{{ url('/home/cars') }}"><i><img src="{{ asset('assets/user/images/send.png') }}"/></i><span>购物车<em class="m-num">{{ $user->cars->count() }}</em></span></a></li>

                        <li><a href="{{ url('/home/orders') }}"><i><img src="{{ asset('assets/user/images/refund.png') }}"/></i><span>订单<em class="m-num">{{ $user->orders->count() }}</em></span></a></li>
                    </ul>
                </div>

                <!--物流 -->
                <div class="m-logistics">

                    <div class="s-bar">
                        <i class="s-icon"></i>订单
                    </div>
                    <div class="s-content">
                        <ul class="lg-list">

                            @foreach ($user->orders as $order)
                                <li class="lg-item">
                                    <div class="lg-info">

                                        <p>订单号：{{ $order->uuid }}</p>
                                        <time>{{ $order->created_at }}</time>
                                    </div>
                                    <div class="lg-confirm">
                                        <a class="i-btn-typical" href="{{ url("/user/orders/{$order->id}") }}">查看详细信息</a>
                                    </div>
                                </li>
                                <div class="clear"></div>
                            @endforeach

                        </ul>

                    </div>

                </div>

                <!--收藏夹 -->
                <div class="you-like">
                    <div class="s-bar">我的收藏
                        <a class="am-badge am-badge-danger am-round">降价</a>
                        <a class="am-badge am-badge-danger am-round">下架</a>
                        <a class="i-load-more-item-shadow" href="#"><i class="am-icon-refresh am-icon-fw"></i>换一组</a>
                    </div>
                    <div class="s-content">
                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/0-item_pic.jpg_220x220.jpg" alt="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰" title="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">42.50</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">68.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰">包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 98.03%</span>
                                    <span class="s-sales">月销: 219</span>

                                </div>
                            </div>
                        </div>

                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/1-item_pic.jpg_220x220.jpg" alt="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰" title="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">49.90</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">88.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰">s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 99.74%</span>
                                    <span class="s-sales">月销: 69</span>

                                </div>
                            </div>
                        </div>

                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/-0-saturn_solar.jpg_220x220.jpg" alt="4折抢购!十二生肖925银女戒指,时尚开口女戒" title="4折抢购!十二生肖925银女戒指,时尚开口女戒" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">378.00</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">1888.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="4折抢购!十二生肖925银女戒指,时尚开口女戒">4折抢购!十二生肖925银女戒指,时尚开口女戒</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 99.93%</span>
                                    <span class="s-sales">月销: 278</span>

                                </div>
                            </div>
                        </div>

                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/0-item_pic.jpg_220x220.jpg" alt="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰" title="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">42.50</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">68.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰">包邮s925纯银项链女吊坠短款锁骨链颈链日韩猫咪银饰简约夏配饰</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 98.03%</span>
                                    <span class="s-sales">月销: 219</span>

                                </div>
                            </div>
                        </div>

                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/1-item_pic.jpg_220x220.jpg" alt="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰" title="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">49.90</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">88.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰">s925纯银千纸鹤锁骨链短款简约时尚韩版素银项链小清新秋款女配饰</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 99.74%</span>
                                    <span class="s-sales">月销: 69</span>

                                </div>
                            </div>
                        </div>

                        <div class="s-item-wrap">
                            <div class="s-item">

                                <div class="s-pic">
                                    <a href="#" class="s-pic-link">
                                        <img src="../images/-0-saturn_solar.jpg_220x220.jpg" alt="4折抢购!十二生肖925银女戒指,时尚开口女戒" title="4折抢购!十二生肖925银女戒指,时尚开口女戒" class="s-pic-img s-guess-item-img">
                                    </a>
                                </div>
                                <div class="s-price-box">
                                    <span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">378.00</em></span>
                                    <span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">1888.00</em></span>

                                </div>
                                <div class="s-title"><a href="#" title="4折抢购!十二生肖925银女戒指,时尚开口女戒">4折抢购!十二生肖925银女戒指,时尚开口女戒</a></div>
                                <div class="s-extra-box">
                                    <span class="s-comment">好评: 99.93%</span>
                                    <span class="s-sales">月销: 278</span>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="s-more-btn i-load-more-item" data-screen="0"><i class="am-icon-refresh am-icon-fw"></i>更多</div>

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

                    @inject('productPresenter', 'App\Presenters\ProductPresenter')
                    <a class="shop-info" href="{{ url("/home/products/{$hotProduct->id}") }}" target="_blank">
                        <div >
                            <img src="{{ $productPresenter->getThumbLink($hotProduct->thumb) }}" alt="">
                        </div>
                        <span class="one-hot-goods">{{ $hotProduct->price }}</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection