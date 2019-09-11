@extends('layouts.shop')

@section('style')
    <link rel="stylesheet" href="/css/coupons.css">
@endsection

@section('main')
    <main id="mainContent" class="main-content">
    <div class="page-container ptb-10">
        <div class="container">
            <div class="section deals-header-area ptb-30">
                <div class="row row-tb-20">
                    <div class="col-xs-12 col-md-4 col-lg-3">
                        <aside>
                            <ul class="nav-coupon-category panel">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href='/categories/{{ $category->id }}'>
                                            <i class="fa {{ $category->icon }}"></i>{{ $category->title }}
                                            <span>{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="all-cat">
                                    <a class="font-14" href="/categories">查看所有分类</a>
                                </li>
                            </ul>
                        </aside>
                    </div>


                    <div class="col-xs-12 col-md-8 col-lg-9">
                        <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                            @foreach ($hotProducts as $hotProduct)
                                <div class="deal-single panel item">
                                    <a href="/products/{{ $hotProduct->uuid }}">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $hotProduct->thumb }}">
                                            <div class="label-discount top-10 right-10" style="width: auto;">
                                                {{ $hotProduct->price }} ￥
                                            </div>
                                        </figure>
                                    </a>
                                    <div class="deal-about p-20 pos-a bottom-0 left-0">
                                        <div class="mb-10">
                                            <span class="rating-count rating">收藏人数{{ $hotProduct->users_count }}</span>
                                            <span class="rating-count rating float-right">总浏览{{ $hotProduct->view_count }}</span>
                                        </div>
                                        <h3 class="deal-title mb-10 ">
                                                {{ $hotProduct->name }}
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @includeWhen($isOpenSeckill, 'homes.seckills')

            <section class="section latest-coupons-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">优惠券</h3>
                    <a href="/coupon_templates" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">查看所有</a>
                </header>

                <div class="row row-masnory row-tb-20">

                    @foreach($couponTemplates as $template)
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
                                <a href="/coupon_templates" class="get-btn">
                                    <span>去领取</span>
                                </a>
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
            </section>


            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">最新的 商品</h3>
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
                                             <span class="rating-count rating">收藏人数{{ $latestProduct->users_count }}</span>
                                             <span class="rating-count rating float-right">总浏览{{ $latestProduct->view_count }}</span>
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

            <section class="section stores-area stores-area-v1 ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">活跃的用户</h3>
                    <a href="#" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">-</a>
                </header>
                <div class="popular-stores-slider owl-slider" data-loop="true" data-autoplay="true" data-smart-speed="1000" data-autoplay-timeout="10000" data-margin="20" data-items="2" data-xxs-items="2" data-xs-items="2" data-sm-items="3" data-md-items="5" data-lg-items="6">
                    @foreach ($users as $user)
                        <div class="store-item t-center">
                            <a href="#" class="panel is-block">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <div class="store-logo">
                                        <img class="user-avatar" src="{{ $user->avatar }}" alt="{{ $user->HiddenName }}">
                                    </div>
                                </div>
                                <h6 class="store-name ptb-10">{{ $user->HiddenName }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="section subscribe-area ptb-40 t-center">
                <div class="newsletter-form">
                    <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>订阅我们</h4>
                    <p class="mb-20 color-mid">每周六上午八点将发送一封商品推荐信息给你 <br />(测试阶段将为每天发送一封订阅邮件)</p>

                        <div class="input-group mb-10">

                            @if ($loginUser)
                                <input  type="email" id="subscribe_email" class="form-control bg-white"
                                        value="{{ $loginUser->subscribe->email ?? optional($loginUser)->email }}"
                                        placeholder="请输入邮箱地址"
                                        {{ $loginUser->subscribe ? 'disabled' : ''  }}
                                required="required">
                                <span class="input-group-btn">
                                    <button class="btn {{ $loginUser->subscribe ? 'btn-warning' : '' }}" id="subscribe" type="button">
                                        {{ $loginUser->subscribe ? '取消订阅' : '订阅' }}
                                    </button>
                                 </span>
                            @else
                                <input  type="email" id="subscribe_email" class="form-control bg-white"
                                        value=""
                                        placeholder="请输入邮箱地址"
                                        required="required">
                                <span class="input-group-btn">
                                    <button class="btn" id="login_subscribe_btn" type="button" style="">订阅</button>
                                 </span>
                            @endif

                        </div>

                    <p class="color-muted"><small>我们永远不会与第三方分享您的电子邮件地址.</small> </p>
                </div>
            </section>
        </div>
    </div>


    </main>
@endsection


@section('script')
    <script src="/assets/admin/lib/lazyload/lazyload.js"></script>
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>

        let csrf_token = "{{ csrf_token() }}";
        // 订阅邮件
        $('#subscribe').click(function(){
            let _url = "user/subscribe";
            let _email = $('#subscribe_email').val();
            let that = $(this);
            that.attr('disabled', true);

            $.post(_url, {email:_email, _token:csrf_token, _method: "PUT"}, function(res){
                that.attr('disabled', false);

                // 取消订阅成功
                if (res.code == 200) {

                    $('#subscribe_email').attr('disabled', false);
                    that.text('订阅').removeClass('btn-warning');
                } else if (res.code == 201) {

                    $('#subscribe_email').attr('disabled', true);
                    that.text('取消订阅').addClass('btn-warning');
                }else {
                    layer.msg(res.msg, {icon: 2});
                    return;
                }

                layer.msg(res.msg, {icon: 1});
            });
        });



        $('#login_subscribe_btn').click(function() {
            layer.confirm('请登录后再订阅', {
                btn: ['去登录','再看看']
            }, function(){
                window.location.href = "login?redirect_dir={{ url()->current() }}";
            }, function(){
                layer.close();
            });
        });
    </script>
@endsection
