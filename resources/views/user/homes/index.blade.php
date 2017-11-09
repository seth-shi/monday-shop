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
                            <a href="information.html">
                                <img src="{{ $userPresenter->getAvatarLink($user->avatar) }}">
                            </a>
                            <em class="s-name">(小叮当)<span class="vip1">1</em>
                            <div class="s-prestige am-btn am-round">
                            <span>
                                </span>会员福利</div>
                        </div>
                        <div class="m-right">
                            <div class="m-new">
                                <a href="#"><i class="am-icon-bell-o"></i>消息</a>
                            </div>
                            <div class="m-address">
                                <a href="{{ url('/user/address') }}" class="i-trigger">我的收货地址</a>
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
                        <li><a href="order.html"><i><img src="{{ asset('assets/user/images/pay.png') }}"/></i><span>待付款</span></a></li>
                        <li><a href="order.html"><i><img src="{{ asset('assets/user/images/send.png') }}"/></i><span>待发货<em class="m-num">1</em></span></a></li>
                        <li><a href="order.html"><i><img src="{{ asset('assets/user/images/receive.png') }}"/></i><span>待收货</span></a></li>
                        <li><a href="order.html"><i><img src="{{ asset('assets/user/images/comment.png') }}"/></i><span>待评价<em class="m-num">3</em></span></a></li>
                        <li><a href="change.html"><i><img src="{{ asset('assets/user/images/refund.png') }}"/></i><span>退换货</span></a></li>
                    </ul>
                </div>

                <!--物流 -->
                <div class="m-logistics">

                    <div class="s-bar">
                        <i class="s-icon"></i>我的物流
                    </div>
                    <div class="s-content">
                        <ul class="lg-list">

                            <li class="lg-item">
                                <div class="item-info">
                                    <a href="#">
                                        <img src="../images/65.jpg_120x120xz.jpg" alt="抗严寒冬天保暖隔凉羊毛毡底鞋垫超薄0.35厘米厚吸汗排湿气舒适">
                                    </a>

                                </div>
                                <div class="lg-info">

                                    <p>快件已从 义乌 发出</p>
                                    <time>2015-12-20 17:58:05</time>

                                    <div class="lg-detail-wrap">
                                        <a class="lg-detail i-tip-trigger" href="logistics.html">查看物流明细</a>
                                        <div class="J_TipsCon hide">
                                            <div class="s-tip-bar">中通快递&nbsp;&nbsp;&nbsp;&nbsp;运单号：373269427686</div>
                                            <div class="s-tip-content">
                                                <ul>
                                                    <li>快件已从 义乌 发出2015-12-20 17:58:05</li>
                                                    <li>义乌 的 义乌总部直发车 已揽件2015-12-20 17:54:49</li>
                                                    <li class="s-omit"><a data-spm-anchor-id="a1z02.1.1998049142.3" target="_blank" href="#">··· 查看全部</a></li>
                                                    <li>您的订单开始处理2015-12-20 08:13:48</li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="lg-confirm">
                                    <a class="i-btn-typical" href="#">确认收货</a>
                                </div>
                            </li>
                            <div class="clear"></div>

                            <li class="lg-item">
                                <div class="item-info">
                                    <a href="#">
                                        <img src="../images/88.jpg_120x120xz.jpg" alt="礼盒袜子女秋冬 纯棉袜加厚 女式中筒袜子 韩国可爱 女袜 女棉袜">
                                    </a>

                                </div>
                                <div class="lg-info">

                                    <p>已签收,签收人是青年城签收</p>
                                    <time>2015-12-19 15:35:42</time>

                                    <div class="lg-detail-wrap">
                                        <a class="lg-detail i-tip-trigger" href="logistics.html">查看物流明细</a>
                                        <div class="J_TipsCon hide">
                                            <div class="s-tip-bar">天天快递&nbsp;&nbsp;&nbsp;&nbsp;运单号：666287461069</div>
                                            <div class="s-tip-content">
                                                <ul>

                                                    <li>已签收,签收人是青年城签收2015-12-19 15:35:42</li>
                                                    <li>【光谷关山分部】的派件员【关山代派】正在派件 电话:*2015-12-19 14:27:28</li>
                                                    <li class="s-omit"><a data-spm-anchor-id="a1z02.1.1998049142.7" target="_blank" href="//wuliu.taobao.com/user/order_detail_new.htm?spm=a1z02.1.1998049142.7.8BJBiJ&amp;trade_id=1479374251166800&amp;seller_id=1651462988&amp;tracelog=yimaidaologistics">··· 查看全部</a></li>
                                                    <li>您的订单开始处理2015-12-17 14:27:50</li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="lg-confirm">
                                    <a class="i-btn-typical" href="#">确认收货</a>
                                </div>
                            </li>

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