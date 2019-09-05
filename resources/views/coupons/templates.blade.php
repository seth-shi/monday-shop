@extends('layouts.shop')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
@endsection

@section('main')
    {{--    <div class="coupon-item">--}}
    {{--        <div class="style-three have">--}}
    {{--            <div class="info-box">--}}
    {{--                <p class="nick">xxx</p>--}}
    {{--                <div class="coupon-money">--}}
    {{--                    <div class="lay of">￥<em>10</em></div>--}}
    {{--                    <div class="lay">--}}
    {{--                        <p class="tit">优惠?</p>--}}
    {{--                        <p class="demand">满100元可用</p>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <a href="javascript:;" class="get-btn">--}}
    {{--                <span>已领取</span>--}}
    {{--            </a>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @include('hint.status')
                <div class="row row-masnory row-tb-20">
                    <div class="coupon-wrapper">
                        @foreach ($templates as $template)
                            <div class="col-sm-6 col-lg-4">

                                <div class="coupon-item">
                                    <div class="style-three">
                                        <div class="info-box">
                                            <p class="nick">{{ $template->title }}</p>
                                            <div class="coupon-money">
                                                <div class="lay of">￥<em>{{ $template->amount }}</em></div>
                                                <div class="lay">
                                                    @if ($template->full_amount > 0)
                                                        <p class="tit">满{{ $template->full_amount }}元可用</p>
                                                    @else
                                                        <p class="tit">无门槛</p>
                                                    @endif
                                                    <p class="demand"
                                                       style="color: #FFB800;">{{ $template->start_date }} ~</p>
                                                    <p class="demand"
                                                       style="color: #5FB878;">{{ $template->end_date }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:;" class="get-btn">
                                            <span>点击领取</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
