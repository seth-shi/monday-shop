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
                                                        <img alt="{{ $product->name }}" src="{{ $productPresenter->getThumbLink($image->link) }}">
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
                                    <button id="addCar" class="btn btn-block btn-warning btn-lg">
                                        <i class="fa fa-shopping-cart font-16 mr-10"></i> 加入购物车
                                    </button>

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

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
                                                    收藏人数 <span class="rating-count rating" id="likes_count">{{ $product->users->count() }}</span>
                                                </div>
                                                @auth
                                                    @if ($product->users()->where('user_id', \Auth::user()->id)->count() > 0)
                                                    <button class="btn btn-success" style="display: none" id="likes_btn">收藏</button>
                                                    <button class="btn btn-info" id="de_likes_btn">取消收藏</button>
                                                    @else
                                                    <button class="btn btn-success" id="likes_btn">收藏</button>
                                                    <button class="btn btn-info" style="display: none" id="de_likes_btn">取消收藏</button>
                                                    @endif
                                                @endauth

                                                @guest
                                                <button class="btn btn-success" id="likes_btn">收藏</button>
                                                @endguest
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
                                                            <a href="{{ url("/home/products/{$recommendProduct->id}") }}">{{ $recommendProduct->name }}</a>
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

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script src="{{ asset('js/jquery-addShopping.js') }}"></script>
    <script>
        var product_id = $('input[name=product_id]').val();
        var _url = "{{ url("/user/likes") }}/" + product_id;
        var token = "{{ csrf_token() }}";
        var likes_nums = $('#likes_count');

        $('#likes_btn').click(function(){
            var that = $(this);

            $.post(_url, {_token:token}, function(res){
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().next().show();
                likes_nums.text(parseInt(likes_nums.text()) + 1);
            });
        });
        $('#de_likes_btn').click(function(){
            var that = $(this);

            $.post(_url, {_token:token,_method:'DELETE'}, function(res){
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().prev().show();
                likes_nums.text(parseInt(likes_nums.text()) - 1);
            });
        });

        var Car = {
            addProduct:function(product_id) {

                if (! localStorage.getItem(product_id)) {
                    var product = {name:"{{ $product->name }}", numbers:1, price:"{{ $product->price }}"};
                } else {
                    var product = $.parseJSON(localStorage.getItem(product_id));
                    product.numbers += 1;
                }
                localStorage.setItem(product_id, JSON.stringify(product))
            }
        };

        var car_nums = $('#cart-number');
        $('#addCar').shoping({
            endElement:"#car_icon",
            iconCSS: "",
            iconImg: $('#product_slider_nav img').attr('src'),
            endFunction:function(element){

                var data = {product_id:"{{ $product->id }}",_token:token};
                var url = "{{ url('/home/cars') }}";
                $.post(url, data, function(res){
                    console.log(res);

                    if (res.code = 302) {
                        Car.addProduct(product_id);
                    }

                    console.log(localStorage);
                    layer.msg('加入购物车成功');
                });
                car_nums.text(parseInt(car_nums.text())+1);
            }
        })
    </script>
@endsection