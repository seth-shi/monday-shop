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
                        <img src="{{ assertUrl($product->thumb) }}" alt="{{ $product->name }}" id="jqzoom" />
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
                            <dt>秒杀价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $redisSeckill->price }}</b>  </dd>
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
                        <hr>
                        <dt>收货地址请设置好收货地址，避免秒杀失败</dt>
                        <hr>
                        <div class="iteminfo_freprice">
                            <div class="am-form-content">

                                @if ($addresses->isNotEmpty())
                                    <select class="form-control" style="width: 100%" id="address_id">
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
                        <li class="tm-ind-item tm-ind-sumCount" style="cursor:default;">
                            <div class="tm-indcon"><span class="tm-label">总量</span><span class="tm-count">{{ $redisSeckill->number }}</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3" id="bought">
                            <div  class="tm-indcon"><span class="tm-label">已抢购</span><span class="tm-count" id="likes_count">{{ $redisSeckill->sale_count }}</span></div>
                        </li>
                    </ul>
                    <div class="clear"></div>



                </div>
                <div class="clear"></div>

                <!--按钮	-->
                <div class="pay">
                    <div class="clearfix tb-btn">
                        @auth
                            @if ($redisSeckill->is_start)
                                <a  style="width: 100%" href="javascript:;" id="nowBug" >立即抢购</a>
                            @else
                                <a  style="width: 100%" href="javascript:;" id="countDown"></a>
                                <a  style="width: 100%;display: none;" href="javascript:;" id="nowBug" >立即抢购</a>
                            @endif    
                        @endauth
                        @guest
                            <span style="color: #666">请登录后再操作</span>
                            <a href="/login" style="width: 100%" title="请先登录" id="countDown">立即抢购</a>
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
        let timestamp = {{ $redisSeckill->diff_time }};
        let timer = null;
        let step = 0.5;


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

            $('#nowBug').click(function () {

                let address_id = $('#address_id').val();
                let that = $(this);
                that.hide();
                layer.msg('抢购中, 请耐心等待');

                let parameters = {address_id: address_id, _token: "{{ csrf_token() }}"};
                $.post('/user/seckills/{{ $redisSeckill->id }}', parameters, function (res) {

                    that.show();
                    if (res.code != 200) {

                        layer.alert(res.msg, {
                            icon: 2,
                            title: '错误'
                        });

                        return;
                    }

                    // 提交表单
                    document.write(res.data.form);
                })
            });
        });


        // 查看已经购买的人
        $('#bought').click(function () {

            $.get('/seckills/{{ $redisSeckill->id }}/users', function (res) {

                if (res.code != 200) {
                    alert(res.msg);
                    return;
                }

                let persons = '';
                for (let i in res.data) {

                    persons += res.data[i] + "<br/>";
                }

                layer.tips(persons, '#bought');
            });


        });


        // 转换时间戳为倒计时
        function transTime(timestamp)
        {
            let result = "";

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
