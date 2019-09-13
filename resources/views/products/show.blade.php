@extends('layouts.product')

@section('style')
    <style>
        .iteminfo_freprice {
            display: inline-block;
        }
        .pay span {
            line-height: 40px;
        }
        .pay li, .pay .pay-opt {
            height: 40px;
        }
        .tb-btn a {
            height: 40px;
            line-height: 40px;
        }
    </style>
@endsection

@section('main')
    <div class="listMain">
        <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function() {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $("#jqzoom").attr('src', $(this).find("img").attr("src"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <img src="{{ $product->thumb }}" alt="{{ $product->name }}" id="jqzoom" />
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        @foreach ($product->pictures as $key => $image)
                            <li class="{{ $key == 0 ? 'tb-selected' : '' }}">
                                <div class="tb-pic tb-s40">
                                    <a href="javascript:;">
                                        <img src="{{ assertUrl($image) }}">
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $product->name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dt>促销价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $product->price }}</b>  </dd>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dt>原价</dt>
                            <dd><em>¥</em><b class="sys_item_mktprice">{{ $product->original_price }}</b></dd>
                        </li>
                        <div class="clear"></div>
                    </div>

                    @include('hint.fail')
                    @include('hint.validate_errors')
                    @include('hint.status')


                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计销量</span><span class="tm-count">{{ $product->sale_count }}</span></div>
                            <br>
                            <div class="tm-indcon"><span class="tm-label">总浏览数</span><span class="tm-count">{{ $product->view_count }}</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div title="滑动到下方收藏的用户查看"  class="tm-indcon"><span class="tm-label">累计收藏</span><span class="tm-count" id="likes_count">{{ $product->users->count() }}</span></div>
                        </li>
                    </ul>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="" action="" method="post">

                                        <div class="theme-signin-left">
                                            <div class="theme-options">
                                                <div class="cart-title number">数量</div>
                        <dd>
                            <input id="min" class="am-btn am-btn-default" type="button" value="-" />
                            <input id="text_box" name="number" type="text" value="1" style="width:30px;" />
                            <input id="add" class="am-btn am-btn-default"  type="button" value="+" />
                            <span id="Stock" class="tb-hidden">库存<span class="stock">{{ $product->count }}</span>件</span>
                        </dd>
                    </dl>


                </div>
                <div class="clear"></div>

                <!--按钮	-->
                <div class="pay">
                    <div class="pay-opt" style="display: inline-block">
                        <a href="/"><span class="am-icon-home am-icon-fw">首页</span></a>
                        @auth
                            @if ($product->userIsLike)
                                <a href="javascript:;" id="likes_btn"><span class="am-icon-heart am-icon-fw color-green" >已收藏</span></a>
                            @else
                                <a href="javascript:;" id="likes_btn"><span class="am-icon-heart am-icon-fw color-blue" >收藏</span></a>
                            @endif
                        @endauth

                        @guest
                            <a href="/login"><span class="am-icon-heart am-icon-fw">收藏</span></a>
                        @endguest
                    </div>
                    <ul>
                        <li>
                            <div class="clearfix tb-btn">
                                @auth
                                    <a id="nowBug" href="javascript:;" >立即购买</a>
                                @endauth
                                @guest
                                    <a href="/login">立即购买</a>
                                @endguest

                            </div>
                        </li>
                        <li>
                            <div class="clearfix tb-btn tb-btn-basket">
                                <a  title="加入购物车" href="javascript:;"  id="addCar"><i></i>加入购物车</a>
                            </div>
                        </li>
                    </ul>

                    <div class="clear"></div>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->uuid }}">

            </div>


            </form>
        </div>
    </div>

    <div class="clear"></div>




    <!-- introduce-->

    <div class="introduce">
        <div class="browse">
            <div class="mc">
                <ul>
                    <div class="mt">
                        <h2>推荐</h2>
                    </div>

                    @foreach ($recommendProducts as $recommendProduct)
                        <li class="first">
                            <div class="p-img">
                                <a href="/products/{{ $recommendProduct->uuid }}">
                                    <img class="media-object" src="{{ $recommendProduct->thumb }}" alt="{{ $recommendProduct->name }}" width="80">
                                </a>
                            </div>
                            <div class="p-name"><a href="/products/{{ $recommendProduct->uuid }}">
                                    {{ $recommendProduct->name }}
                                </a>
                            </div>
                            <div class="p-price"><strong>
                                    ￥ {{ $recommendProduct->price }}
                                </strong></div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="introduceMain">
            <div class="am-tabs" data-am-tabs>
                <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">

                    <li class="am-active">
                        <a href="#"><span class="index-needs-dt-txt">商品评论</span></a>
                    </li>

                    <li>
                        <a href="#"><span class="index-needs-dt-txt">宝贝详情</span></a>
                    </li>

                    <li>
                        <a href="#"><span class="index-needs-dt-txt">收藏的用户</span></a>
                    </li>
                </ul>

                <div class="am-tabs-bd">


                    <div class="am-tab-panel am-fade am-in am-active">
                        <div class="posted-review panel p-30">
                            <h3 class="h-title">{{ $product->comments->count() }} 评论</h3>
                            @foreach ($product->comments as $comment)
                                <div class="review-single pt-30">
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object mr-10 radius-4" src="{{ $comment->user->avatar }}" width="90" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="review-wrapper clearfix">
                                                <ul class="list-inline">
                                                    <li>
                                                        <span class="review-holder-name h5">{{ $comment->user->name }}</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating">
                                                            <span class="rating-stars" data-rating="5">
                                                                {!! str_repeat('<i class="fa fa-star-o"></i>', 5 - $comment->score) !!}
                                                                {!! str_repeat('<i class="fa fa-star-o star-active"></i>', $comment->score) !!}
										                    </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <p class="review-date mb-5">{{ $comment->created_at }}</p>
                                                <p class="copy">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div class="am-tab-panel am-fade">
                        <div class="details">
                            <div class="attr-list-hd after-market-hd">
                                <h4>商品细节</h4>
                            </div>
                            <div class="twlistNews">
                                {!! $product->detail->content !!}
                            </div>
                        </div>
                        <div class="clear"></div>

                    </div>


                    <div class="am-tab-panel am-fade">

                        <ul class="am-comments-list am-comments-list-flip">
                            @foreach ($product->users as $user)
                                <li class="am-comment">
                                    <a href="">
                                        <img class="am-comment-avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                                    </a>

                                    <div class="am-comment-main">
                                        <header class="am-comment-hd">
                                            <div class="am-comment-meta">
                                                <a href="#" class="am-comment-author">{{ $user->name }}</a>
                                            </div>
                                        </header>

                                        <!-- 评论内容 -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="clear"></div>


                        <div class="tb-reviewsft">
                            <div class="tb-rate-alert type-attention">购买前请查看该商品的 <a href="#" target="_blank">购物保障</a>，明确您的售后保障权益。</div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="clear"></div>

            <div class="footer">
                <div class="footer-hd">
                    <p>
                        <a href="#">星期一商城</a>
                        <b>|</b>
                        <a href="#">商城首页</a>
                        <b>|</b>
                        <a href="#">支付宝</a>
                        <b>|</b>
                        <a href="#">物流</a>
                    </p>
                </div>
                @include('modules.home.footer')
            </div>
        </div>

    </div>

    <form id="pay_form" action="/user/pay/store" method="post">
        {{ csrf_field() }}
    </form>
@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script src="/js/jquery-addShopping.js"></script>
    <script>
        let product_id = $('input[name=product_id]').val();
        let _url = "/user/likes/" + product_id;
        let token = "{{ csrf_token() }}";
        let likes_nums = $('#likes_count');

        // 收藏
        $('#likes_btn').click(function(){
            let that = $(this);

            $.post(_url, {_token:token, _method: 'PUT'}, function(res){
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                // 收藏成功
                if (res.code == 201) {

                    that.find('span').text('已收藏');
                    that.find('span').removeClass('color-blue').addClass('color-green');
                    likes_nums.text(parseInt(likes_nums.text()) + 1);
                } else {

                    // 已收藏
                    that.find('span').text('收藏');
                    that.find('span').removeClass('color-green').addClass('color-blue');
                    likes_nums.text(parseInt(likes_nums.text()) - 1);
                }
            });
        });

        // 加入购物车
        $('#addCar').shoping({
            endElement:"#car_icon",
            iconCSS: "",
            iconImg: $('#jqzoom').attr('src'),
            endFunction:function(element){

                let number = $("input[name=number]").val();


                @auth
                    let data = {product_id: product_id,_token:token, number:number};
                    $.post("/cars", data, function(res){

                        if (res.code != 200) {
                            layer.msg(res.msg, {icon: 2});
                            return;
                        }

                        // 更新购物车显示数量
                        renderIncrementCar(number, false);
                        layer.msg(res.msg, {icon: 1});
                    });
                @endauth
                @guest
                    LocalCar.increment("{{ $product->uuid }}", "{{ $product->name }}", "{{ $product->thumb }}", number, {{ $product->price }});
                    // 更新购物车显示数量
                    renderIncrementCar(number, true);
                    layer.msg('加入本地购物车成功', {icon: 1});
                @endguest
            }
        });

        // 现在购买
        $('#nowBug').click(function(){
            let _number = $('input[name=number]').val();

            window.location.href = "/user/comment/orders/create?ids[]=" + product_id + "&numbers[]=" + _number;
        });


        // 增加和减少按钮
        $('#min').click(function () {

            let val = $('input[name=number]').val();
            val = parseInt(val);

            if (val == 1) {
                layer.msg('不能再减少了');
                return;
            }

            $('input[name=number]').val(val - 1);
        });
        $('#add').click(function () {
            let val = $('input[name=number]').val();

            $('input[name=number]').val(parseInt(val) + 1);
        });
    </script>
@endsection
