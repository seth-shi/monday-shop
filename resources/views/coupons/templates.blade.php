@extends('layouts.shop')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
@endsection

@section('main')

    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @include('hint.status')
                <div class="row row-masnory row-tb-20">
                    <div class="coupon-wrapper">
                        @foreach ($templates as $template)
                            <div class="col-sm-6 col-lg-4">

                                <div class="coupon-item">
                                    <div class="style-three {{ $template->coupons_count > 0 ? 'have' : '' }}">
                                        <div class="info-box">
                                            <p class="nick">
                                                {{ $template->title }}
                                                @if ($template->score > 0)
                                                    <span style="color: #FF5722"> {{ $template->score }}积分</span>
                                                @endif
                                            </p>
                                            <div class="coupon-money">
                                                <div class="lay of">￥<em>{{ $template->amount }}</em></div>
                                                <div class="lay">
                                                    @if ($template->full_amount > 0)
                                                        <p class="tit">满{{ $template->full_amount }}可用</p>
                                                    @else
                                                        <p class="tit">无门槛</p>
                                                    @endif
                                                    <p class="demand"
                                                       style="color: #FFB800;">{{ $template->start_date }}</p>
                                                    <p class="demand"
                                                       style="color: #5FB878;">{{ $template->end_date }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="javascript:;" class="get-btn {{ $template->coupons_count > 0 ? '' : 'get-coupon-btn' }}" data-id="{{ $template->id }}">
                                            <span>{{ $template->coupons_count > 0 ? '已领取' : '点击领取' }}</span>
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

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>


        $('.get-coupon-btn').click(function () {

            var that = $(this);
            if (! that.hasClass('get-coupon-btn')) {
                return false;
            }

            that.removeClass('get-coupon-btn');
            var id = $(this).data('id');
            $.post('/coupons', {template_id: id, _token: '{{ csrf_token() }}'}, function (res) {

                if (res.code != 200) {

                    that.addClass('get-coupon-btn');
                    layer.alert(res.msg, {icon: 2})
                    return false;
                }


                that.parents('.style-three').addClass('have');
                that.html('<span>已领取</span>');
                layer.msg('领取成功');
            });
        });
    </script>
@endsection
