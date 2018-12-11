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
                                        <img src="{{ imageUrl($image) }}">
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
                            <dt>秒杀价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $seckill->price }}</b>  </dd>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dt>原价</dt>
                            <dd><em>¥</em><b class="sys_item_mktprice">{{ $product->price }}</b></dd>
                        </li>
                        <div class="clear"></div>
                    </div>

                    @include('hint.validate_errors')

                    <!--地址-->
                    <div class="iteminfo_parameter" style="text-align: center">
                        <dt>收货地址</dt>
                        <div class="iteminfo_freprice">
                            <div class="am-form-content">

                                @if ($addresses->isNotEmpty())
                                    <select class="form-control" style="width: 100%" name="address_id">
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>{{ $address->name }}/{{ $address->phone }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <a style="line-height:27px;color:red;" href="/user/addresses">添加收货地址</a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">剩余量</span><span class="tm-count">{{ $seckill->numbers }}</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div  class="tm-indcon"><span class="tm-label">已抢购</span><span class="tm-count" id="likes_count">{{ $seckill->safe_count }}</span></div>
                        </li>
                    </ul>
                    <div class="clear"></div>



                </div>
                <div class="clear"></div>

                <!--按钮	-->
                <div class="pay">
                    <div class="clearfix tb-btn">
                        @auth
                            @if ($seckill->is_start)
                                <a  style="width: 100%" href="javascript:;" id="nowBug" >立即抢购</a>
                            @else
                                <a  style="width: 100%" href="javascript:;" id="countDown"></a>
                                <a  style="width: 100%;display: none;" href="javascript:;" id="nowBug" >立即抢购</a>
                            @endif    
                        @endauth
                        @guest
                            <a href="/login?redirect_url={{ url()->current() }}">请先登录</a>
                        @endguest
                    </div>
                    <div class="clear"></div>
                </div>
            </div>


            </form>
        </div>
    </div>

    <div class="clear"></div>

@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>
        var timestamp = {{ $seckill->diff_time }};
        var timer = null;
        var step = 0.5;


        $(function () {

            if (timestamp > 0) {

                timer = setInterval(function () {

                    if (timestamp <= 0) {

                        clearInterval(timer);
                        $('#countDown').hide();
                        $('#nowBug').show();
                        return;
                    }

                    $('#countDown').text(transTime(timestamp));
                    timestamp -= step;
                }, 500);
            }
        });


        function transTime(timestamp)
        {
            var result = "";

            if (timestamp >= 86400) {
                $days = Math.floor(timestamp / 86400);
                timestamp = timestamp % 86400;
            } else {
                $days = 0;
            }
            result = $days + '天';

            if (timestamp >= 3600) {
                $hours = Math.floor(timestamp / 3600);
                timestamp = timestamp % 3600;
                if ($hours < 10) {
                    $hours = '0' + $hours;
                }
            } else {
                $hours = '00';
            }
            result += $hours + '时';


            if (timestamp >= 60) {
                $minutes = Math.floor(timestamp / 60);
                timestamp = timestamp % 60;
                if ($minutes < 10) {
                    $minutes = '0' + $minutes;
                }

            } else {
                $minutes = '00'
            }
            result += $minutes + '分';

            $secend = Math.floor(timestamp);

            if ($secend < 10) {
                $secend = '0' + $secend;
            }

            result += $secend + "秒";

            return result;
        }
    </script>
@endsection
