@extends('layouts.user')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
    <style>
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
    <style>
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            z-index: 2;
            color: #23527c;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        .pagination .current {
            color: #999;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .pagination-lg > li > a,
        .pagination-lg > li > span {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
        }
        .pagination-lg > li:first-child > a,
        .pagination-lg > li:first-child > span {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }
        .pagination-lg > li:last-child > a,
        .pagination-lg > li:last-child > span {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .pagination-sm > li > a,
        .pagination-sm > li > span {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }
        .pagination-sm > li:first-child > a,
        .pagination-sm > li:first-child > span {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }
        .pagination-sm > li:last-child > a,
        .pagination-sm > li:last-child > span {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }
        .pager {
            padding-left: 0;
            margin: 20px 0;
            text-align: center;
            list-style: none;
        }
        .pager li {
            display: inline;
        }
        .pager li > a,
        .pager li > span {
            display: inline-block;
            padding: 5px 14px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 15px;
        }
        .pager li > a:hover,
        .pager li > a:focus {
            text-decoration: none;
            background-color: #eee;
        }
        .pager .next > a,
        .pager .next > span {
            float: right;
        }
        .pager .previous > a,
        .pager .previous > span {
            float: left;
        }
        .pager .disabled > a,
        .pager .disabled > a:hover,
        .pager .disabled > a:focus,
        .pager .disabled > span {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
        }
    </style>
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-order">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">优惠券管理</strong></div>
            </div>
            <hr/>

            <div class="am-tabs am-tabs-d2 am-margin" data-am-tabs>

                <ul class="am-avg-sm-5 am-tabs-nav am-nav am-nav-tabs">
                    <li class="{{ (request('tab', 1) == 1) ? 'am-active' : '' }}"><a href="?tab=1">未使用的</a></li>
                    <li class="{{ request('tab') == 2 ? 'am-active' : '' }}"><a href="?tab=2">已使用的</a></li>
                    <li class="{{ request('tab') == 3 ? 'am-active' : '' }}"><a href="?tab=3">已过期的</a></li>
                </ul>

                @include('hint.validate_errors')
                @include('hint.status')


                <div class="row row-masnory row-tb-20">
                    <div class="coupon-wrapper">
                        @foreach ($coupons as $coupon)
                            <div class="col-sm-6 col-lg-4">

                                <div class="coupon-item">
                                    <div style="height: 6rem;" class="style-three {{ $coupon->used ? 'have' : '' }}">
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

                                        <a href="{{ $coupon->used ? 'javascript:;' : '/products' }}"
                                           style="height: 6rem;"
                                           class="get-btn">
                                            <span>{{ $coupon->show_title }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                            {{ $coupons->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>


    </div>

@endsection
