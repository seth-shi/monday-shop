@extends('layouts.shop')

@section('style')
    <style>
        .successInfo {
            padding: 0 65px 0 56px;
            display: inline-block;
        }
    </style>
@endsection

@section('main')
    <div class="container" style="padding: 20px 0px">
        @if ($order)
            <div class="row" style="padding-left: 65px;">

                @if ($order->status == \App\Enums\OrderStatusEnum::PAID)
                    <img src="/images/success.jpg" style="float: left;">
                    <h2 style="color: darkgreen;">您已成功付款</h2>
                @else
                    <img src="/images/error.jpg" style="float: left;">
                    <h2 style="color: darkred;">您还未付款</h2>
                @endif
            </div>

            <div class="successInfo">
                <div class="row">
                    <div class="span">付款金额</div>
                    <div class="span_content"><h2>{{ $order->amount }}</h2></div>
                </div>
                <div class="row">
                    <div class="span">收货人</div>
                    <div class="span_content"><h2>{{ $order->consignee_name }}</h2></div>
                </div>
                <div class="row">
                    <div class="span">联系电话</div>
                    <div class="span_content"><h2>{{ $order->consignee_phone }}</h2></div>
                </div>
                <div class="row">
                    <div class="span">收货地址</div>
                    <div class="span_content"><h2>{{ $order->consignee_address }}</h2></div>
                </div>
                <div class="option">
                    <span class="info">您可以</span>
                    <a href="/user/orders" class="J_MakePoint">查看<span>已买到的宝贝</span></a>
                </div>

                请认真核对您的收货信息，如有错误请联系客服
            </div>
        @else
            <div class="row">
                <div class="col-xs-2"><img src="/images/error.jpg"></div>
                <div class="col-xs-10"><h2 style="color: darkred;">支付失败</h2></div>
            </div>
            <div class="successInfo">
                请稍后刷新再次尝试...
            </div>
        @endif

            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">商品推荐</h3>
                    <a href="/products" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">查看所有</a>
                </header>

                <div class="row row-masnory row-tb-20">
                    @foreach ($latestProducts as $latestProduct)
                        <div class="col-sm-6 col-lg-4">
                            <div class="deal-single panel">
                                <a href="/products/{{ $latestProduct->uuid }}">
                                    <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $latestProduct->thumb }}">

                                    </figure>
                                </a>
                                <div class="bg-white pt-20 pl-20 pr-15">
                                    <div class="pr-md-10">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating">{{ $latestProduct->users_count }}</span>
                                        </div>
                                        <h3 class="deal-title mb-10">
                                            <a href="/products/{{ $latestProduct->uuid }}">
                                                {{ $latestProduct->name }}
                                            </a>
                                        </h3>
                                        <p class="text-muted mb-20">
                                            {!! $latestProduct->title !!}
                                        </p>
                                    </div>
                                    <div class="deal-price pos-r mb-15">
                                        <h3 class="price ptb-5 text-right">
                                            <span class="price-sale">
                                                {{ $latestProduct->original_price }}
                                            </span>
                                            ￥ {{ $latestProduct->price }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
    </div>
@endsection

