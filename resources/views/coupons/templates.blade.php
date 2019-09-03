@extends('layouts.shop')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @include('hint.status')

                <div class="coupon-wrapper">
                    <h3>xxx?领取：</h3>
                    <div class="coupon-item">
                        <div class="style-three">
                            <div class="info-box">
                                <p class="nick">monday优惠券</p>
                                <div class="coupon-money">
                                    <div class="lay of">￥<em>10</em></div>
                                    <div class="lay">
                                        <p class="tit">满100元可用</p>
                                        <p class="demand">2019-09-31~2019-09-21</p>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" class="get-btn">
                                <span>点击领取</span>
                            </a>
                        </div>
                    </div>
                    <div class="coupon-item">
                        <div class="style-three have">
                            <div class="info-box">
                                <p class="nick">xxx</p>
                                <div class="coupon-money">
                                    <div class="lay of">￥<em>10</em></div>
                                    <div class="lay">
                                        <p class="tit">优惠?</p>
                                        <p class="demand">满100元可用</p>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" class="get-btn">
                                <span>已领取</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
