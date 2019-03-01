<section class="section latest-coupons-area ptb-30">
    <header class="panel ptb-15 prl-20 pos-r mb-30">
        <h3 class="section-title font-18">秒杀商品</h3>
    </header>

    <div class="latest-coupons-slider owl-slider" data-autoplay-hover-pause="true" data-loop="true" data-autoplay="true" data-smart-speed="1000" data-autoplay-timeout="10000" data-margin="30" data-nav-speed="false" data-items="1" data-xxs-items="1" data-xs-items="2" data-sm-items="2" data-md-items="3" data-lg-items="4">

        @forelse($secKills as $secKill)
            <div class="coupon-item">
                <a href="/seckills/{{ $secKill->id }}">
                    <div class="coupon-single panel t-center">
                    <div class="ribbon-wrapper is-hidden-xs-down">
                        <div class="ribbon"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-center p-20">
                                <img class="store-logo" style="width: 100%; height: 100px;" src="{{ $secKill->product->thumb }}" alt="">
                            </div>
                            <!-- end media -->
                        </div>
                        <!-- end col -->
                        <div class="col-xs-12">
                            <div class="panel-body">
                                <ul class="deal-meta list-inline mb-10">
                                    <li class="color-green"><i class="ico lnr lnr-smile mr-5"></i>剩余：{{ $secKill->number }}</li>
                                    <li class="color-muted"><i class="ico lnr lnr-users mr-5"></i>已抢: {{ $secKill->sale_count }}</li>
                                </ul>
                                <h5 class="deal-title mb-10">
                                    <a href="/seckills/{{ $secKill->id }}">{{ str_limit($secKill->product->name, 10) }}</a>
                                </h5>
                                <p class="mb-15 text-left color-muted mb-20 font-12"><i class="lnr lnr-clock mr-10"></i>开始时间: {{ $secKill->start_at }}</p>
                                <p class="mb-15 text-left color-muted mb-20 font-12"><i class="lnr lnr-lock mr-10"></i>参考价格: {{ optional($secKill->product)->price }}</p>
                                <div class="showcode" data-toggle-class="coupon-showen" data-toggle-event="click">
                                    <div class="coupon-hide"> {{ $secKill->price }} ￥</div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                </a>
            </div>
        @empty
            <div class="coupon-item">
                <div class="coupon-single panel t-center">
                    <div class="ribbon-wrapper is-hidden-xs-down">
                        <div class="ribbon">没有秒杀活动</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-center p-20">
                                <img class="store-logo" alt="">
                            </div>
                            <!-- end media -->
                        </div>
                        <!-- end col -->

                        <div class="col-xs-12">
                            <div class="panel-body">

                                <h4 class="color-green mb-10 t-uppercase">再等等吧</h4>
                                <h5 class="deal-title mb-10">
                                    <a href="#">没有抢购活动</a>
                                </h5>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
        @endforelse
    </div>
</section>
