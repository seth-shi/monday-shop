@extends('layouts.home')


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
                                        <a href='{{ url("/home/categories/{$category->id}") }}'>
                                            <i class="fa fa-shopping-cart"></i>{{ $category->name }}
                                            <span>{{ $category->products->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="all-cat">
                                    <a class="font-14" href="{{ url('/home/categories') }}">查看所有分类</a>
                                </li>
                            </ul>
                        </aside>
                    </div>


                    <div class="col-xs-12 col-md-8 col-lg-9">
                        <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                            @inject('productPresenter', 'App\Presenters\ProductPresenter')
                            @foreach ($hotProducts as $hotProduct)
                                <div class="deal-single panel item">
                                    <a href="{{ url("/home/products/{$hotProduct->id}") }}">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $productPresenter->getThumbLink($hotProduct->thumb) }}">
                                            <div class="label-discount top-10 right-10" style="width: auto;">
                                                {{ $hotProduct->price }} ￥
                                            </div>
                                            <ul class="deal-actions top-10 left-10">
                                                <li class="like-deal" data-id="{{ $hotProduct->id }}">
                                                    <span>
                                                        <i class="fa fa-heart"></i>
                                                    </span>
                                                </li>
                                            </ul>
                                        </figure>
                                    </a>
                                    <div class="deal-about p-20 pos-a bottom-0 left-0">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating">{{ $hotProduct->likes }}</span>
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

            <div class="section explain-process-area ptb-30">
                <div class="row row-rl-10">
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="#" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">电脑</h5>
                                    <p class="color-mid">你可能喜欢的.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="#" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">电脑</h5>
                                    <p class="color-mid">你可能喜欢的.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="#" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">电脑</h5>
                                    <p class="color-mid">你可能喜欢的.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">最新的 商品</h3>
                    <a class="btn btn-o btn-xs pos-a right-10 pos-tb-center">View All</a>
                </header>

                <div class="row row-masnory row-tb-20">
                    @foreach ($latestProducts as $latestProduct)
                        <div class="col-sm-6 col-lg-4">
                            <div class="deal-single panel">
                                <a href="{{ url("/home/products/$latestProduct->id") }}">
                                    <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $productPresenter->getThumbLink($latestProduct->thumb) }}">
                                        <ul class="deal-actions top-15 right-20">
                                            <li class="like-deal">
                                                <span>
                                                    <i class="fa fa-heart"></i>
                                                </span>
                                            </li>
                                        </ul>
                                    </figure>
                                </a>
                                <div class="bg-white pt-20 pl-20 pr-15">
                                    <div class="pr-md-10">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating">{{ $latestProduct->likes }}</span>
                                        </div>
                                        <h3 class="deal-title mb-10">
                                            <a href="{{ url("/home/products/$latestProduct->id") }}">
                                                {{ $latestProduct->name }}
                                            </a>
                                        </h3>
                                        <p class="text-muted mb-20">
                                            {{ $latestProduct->title }}
                                        </p>
                                    </div>
                                    <div class="deal-price pos-r mb-15">
                                        <h3 class="price ptb-5 text-right">
                                            <span class="price-sale">
                                                {{ $latestProduct->price_original }}
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
                    <a href="#" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">All Stores</a>
                </header>
                <div class="popular-stores-slider owl-slider" data-loop="true" data-autoplay="true" data-smart-speed="1000" data-autoplay-timeout="10000" data-margin="20" data-items="2" data-xxs-items="2" data-xs-items="2" data-sm-items="3" data-md-items="5" data-lg-items="6">
                    @inject('userPresenter', 'App\Presenters\UserPresenter')
                    @foreach ($users as $user)
                        <div class="store-item t-center">
                            <a href="#" class="panel is-block">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <div class="store-logo">
                                        <img src="{{ $userPresenter->getThumbLink($user->avatar) }}" alt="{{ $user->name }}">
                                    </div>
                                </div>
                                <h6 class="store-name ptb-10">{{ $userPresenter->getHiddenPartName($user->name) }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="section subscribe-area ptb-40 t-center">
                <div class="newsletter-form">
                    <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>订阅我们</h4>
                    <p class="mb-20 color-mid">每周将发送一封商品推荐信息给你</p>
                    <form method="post" action="#">
                        <div class="input-group mb-10">
                            <input type="email" class="form-control bg-white" placeholder="Email Address" required="required">
                            <span class="input-group-btn">
                                        <button class="btn" type="submit">订阅</button>
                                    </span>
                        </div>
                    </form>
                    <p class="color-muted"><small>我们永远不会与第三方分享您的电子邮件地址.</small> </p>
                </div>
            </section>
        </div>
    </div>


    </main>
@endsection