@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">

        @inject('productPresenter', 'App\Presenters\ProductPresenter')
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <div class="row row-rl-10 row-tb-20">
                    <div class="page-content col-xs-12 col-sm-7 col-md-8">
                        <div class="row row-tb-20">
                            <div class="col-xs-12">
                                <div class="deal-deatails panel">
                                    <div class="deal-slider">
                                        <div id="product_slider" class="flexslider">
                                            <ul class="slides">

                                                @foreach ($product->productImages as $image)
                                                    <li>
                                                        <img alt="" src="{{ $productPresenter->getThumbLink($image->link) }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div id="product_slider_nav" class="flexslider flexslider-nav">
                                            <ul class="slides">
                                                @foreach ($product->productImages as $image)
                                                    <li>
                                                        <img alt="" src="{{ $productPresenter->getThumbLink($image->link) }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="deal-body p-20">
                                        <h2 class="price mb-15">￥ {{ $product->price }}</h2>

                                        详情：{{ $product->productDetail->description }}
                                    </div>

                                </div>

                                <div class="buy-now mb-40">
                                    <a href="#" target="_blank" class="btn btn-block btn-warning btn-lg">
                                        <i class="fa fa-shopping-cart font-16 mr-10"></i> 加入购物车
                                    </a>

                                    <a href="#" target="_blank" class="btn btn-block btn-lg">
                                        <i class="fa fa-shopping-bag font-16 mr-10"></i> 马上&nbsp;&nbsp;购买
                                    </a>
                                </div>

                            </div>
                            <div class="col-xs-12">
                                <div class="posted-review panel p-30">
                                    <h3 class="h-title">16 评论</h3>

                                    @foreach ([1, 2, 3, 4] as $v)
                                        <div class="review-single pt-30">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img class="media-object mr-10 radius-4" src="assets/images/avatars/avatar_01.jpg" width="90" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="review-wrapper clearfix">
                                                        <ul class="list-inline">
                                                            <li>
                                                                <span class="review-holder-name h5">匿名</span>
                                                            </li>
                                                        </ul>
                                                        <p class="review-date mb-5">9, 2016</p>
                                                        <p class="copy">哈哈哈哈，好评.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="post-review panel p-20">
                                    <h3 class="h-title">发表评论</h3>
                                    <form class="horizontal-form pt-30" action="#">
                                        <div class="row row-v-10">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Name">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Email">
                                            </div>
                                            <div class="col-xs-12">
                                                <textarea class="form-control" placeholder="Your Review" rows="6"></textarea>
                                            </div>
                                            <div class="col-xs-12 text-right">
                                                <button type="submit" class="btn mt-20">提交</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-sidebar col-md-4 col-sm-5 col-xs-12">
                        <!-- Blog Sidebar -->
                        <aside class="sidebar blog-sidebar">
                            <div class="row row-tb-10">
                                <div class="col-xs-12">
                                    <div class="widget single-deal-widget panel ptb-30 prl-20">
                                        <div class="widget-body text-center">
                                            <h2 class="mb-20 h3">
                                                {{ $product->name }}
                                            </h2>

                                            <p class="color-muted">
                                                简单描述：{{ $product->title }}
                                            </p>
                                            <div class="price mb-20">
                                                <h2 class="price">
                                                    <span class="price-sale">￥ {{ $product->price_original }}</span>
                                                    ￥ {{ $product->price }}
                                                </h2>
                                            </div>
                                            <div class="buy-now mb-40">
                                                <a href="#" target="_blank" class="btn btn-block btn-lg">
                                                    <i class="fa fa-shopping-bag font-16 mr-10"></i> 购买
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <!-- Recent Posts -->
                                    <div class="widget about-seller-widget panel ptb-30 prl-20">
                                        <h3 class="widget-title h-title">收藏</h3>
                                        <div class="widget-body t-center">
                                            <div class="store-about mb-20">
                                                <h3 class="mb-10">喜欢这款商品吗？</h3>
                                                <div class="mb-10">
                                                    收藏人数 <span class="rating-count rating">{{ $product->likes }}</span>
                                                </div>
                                                <button class="btn btn-info">收藏</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Recent Posts -->
                                </div>

                                <div class="col-xs-12">
                                    <!-- Best Rated Deals -->
                                    <div class="widget best-rated-deals panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">更多推荐</h3>
                                        <div class="widget-body ptb-30">

                                            @foreach ($recommendProducts as $recommendProduct)
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="{{ url("/home/products/{$recommendProduct->id}") }}">
                                                            <img class="media-object" src="{{ $productPresenter->getThumbLink($recommendProduct->thumb) }}" alt="{{ $recommendProduct->name }}" width="80">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-5">
                                                            <a href="#">{{ $recommendProduct->name }}</a>
                                                        </h6>
                                                        <h4 class="price font-16">￥ {{ $recommendProduct->price }} <span class="price-sale color-muted">￥ {{ $product->price_original }}</span></h4>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <!-- Best Rated Deals -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Contact Us Widget -->
                                    <div class="widget contact-us-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">有什么问题?</h3>
                                        <div class="widget-body ptb-30">
                                            <p class="mb-20 color-mid">如果有问题，请联系我们</p>
                                            <a href="#" class="btn btn-block"><i class="mr-10 font-15 fa fa-envelope-o"></i>给我们写信</a>
                                        </div>
                                    </div>
                                    <!-- End Contact Us Widget -->
                                </div>
                            </div>
                        </aside>
                        <!-- End Blog Sidebar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Container -->


    </main>
@endsection