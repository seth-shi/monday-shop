@extends('layouts.shop')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <div class="cart-price">
                                <h5 class="t-uppercase mb-20">购物车总价</h5>
                                <ul class="panel mb-20">
                                    <li>
                                        <div class="item-name">
                                            <strong class="t-uppercase">订单总价</strong>
                                        </div>
                                        <div class="price">
                                            <span id="cars_price">
                                                0
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="t-right">
                                    <!-- Checkout Area -->
                                    <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                        <h2 class="h3 mb-20 h-title">支付信息</h2>
                                        @include('hint.status')
                                        <form class="mb-30" method="post" action="/user/pay/store">
                                            {{ csrf_field() }}

                                            <div class="row">

                                                @include('hint.validate_errors')

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>选择收货地址</label>
                                                        @if ($addresses->isNotEmpty())
                                                            <select class="form-control" name="address_id">
                                                                <option value="">请选择收货地址</option>
                                                                @foreach ($addresses as $address)
                                                                    <option value="{{ $address->id }}">{{ $address->name }}/{{ $address->phone }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <a style="color: green;" href="/user/addresses">添加收货地址</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 支付宝支付 -->
                                            <input type="hidden" name="pay_type" value="1">

                                            @auth
                                            <button type="submit"  class="btn btn-lg btn-rounded mr-10">下单</button>
                                            @endauth
                                            @guest
                                            <a href="/login"  class="btn btn-lg btn-rounded mr-10">下单</a>
                                            @endguest
                                        </form>
                                    </section>
                                </div>
                            </div>
                            <h3 class="h-title mb-30 t-uppercase">我的购物车</h3>
                            <table id="cart_list" class="cart-list mb-30">
                                <thead class="panel t-uppercase">
                                <tr>
                                    <th>商品名字</th>
                                    <th>商品价格</th>
                                    <th>数量</th>
                                    <th>删除</th>
                                </tr>
                                </thead>
                                <tbody id="cars_data">
                                @foreach ($cars as $car)
                                <tr class="panel alert">
                                    <td>
                                        <div class="media-body valign-middle">
                                            <h6 class="title mb-15 t-uppercase">
                                                <a href="/products/{{ $car->product->uuid }}">
                                                    {{ $car->product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="prices">{{ $car->product->price }}</td>
                                    <td>
                                        <input data-id="{{ $car->product->uuid }}" class="quantity-label car_number" type="number" value="{{ $car->number }}">
                                    </td>

                                    <td>
                                        <button data-id="{{ $car->id }}" class="close delete_car" type="button" >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>
        var cars_span = '';
        var cars = localStorage;
        var cars_prices = 0;
        var token = "{{ csrf_token() }}";

        // 购物车对象
        var Car = {
            syncnumber:function(product_id, number) {

                console.log(product_id);
                if (! localStorage.getItem(product_id)) {
                    alert('非法添加');
                    return;
                } else {
                    var product = $.parseJSON(localStorage.getItem(product_id));
                    product.number = parseInt(number);
                }
                localStorage.setItem(product_id, JSON.stringify(product))
            }
        };


        @auth
            syncCarsToDatabase();
            function syncCarsToDatabase()
            {
                if (localStorage.length > 0) {
                    layer.confirm('是否同步本地购物车到本账户下', {
                        btn: ['是', '否'],
                    }, function(){
                        layer.closeAll();
                        var cars = localStorage;
                        for (var i in cars) {
                            var product = $.parseJSON(cars[i]);

                            var data = {product_id: i, number: product.number, _token: token};
                            var url = "/cars";
                            console.log(product);

                            $.post(url, data, function (res) {

                                if (res.code != 302 && res.code != 200) {

                                    layer.msg(res.msg, {icon: 2});
                                    return;
                                }

                                layer.msg('同步购物车成功，请刷新查看');
                            });
                        }

                        localStorage.clear();
                    }, function(){});
                }
            }
        @endauth

        @guest
            for (var i in cars) {

                var procuct_id = i;
                var product = cars[i];
                product = $.parseJSON(product);

                cars_span += '<tr class="panel alert local-car">\
                <td>\
                <div class="media-body valign-middle">\
                <h6 class="title mb-15 t-uppercase">\
                <a href="/products/'+ i +'">\
                    '+ product.name +'\
                </a>\
                </h6>\
                </div>\
                </td>\
                <td  class="prices">'+ product.price +'</td>\
                <td>\
                <input data-id="'+ procuct_id +'" class="quantity-label car_number" type="number" value="'+ product.number +'">\
                </td>\
                <td>\
                <button type="button" class="close delete_car" data-id="'+  procuct_id +'"  >\
                <i class="fa fa-trash-o"></i>\
                </button>\
                </td>\
                </tr>';

                cars_prices += product.price * product.number;
            }

            $('#cars_data').append(cars_span);
            getTotal();

         @endguest

        var cars_url = "/cars/";

        $("#cart_list").on('click', '.delete_car', function () {

            console.log(1);
            var that = $(this);
            var id = that.data('id');
            var _url = cars_url + id;
            $.post(_url, {_token:token,_method:'DELETE'}, function(res){

                if (res.code != 302 && res.code != 200) {

                    layer.msg(res.msg, {icon: 2});
                    return;
                }

                if (res.code == 302) {
                    localStorage.removeItem(id);
                }

                that.parent().parent().remove();
                getTotal();
            });
        });


        // 更改购物车数量
        $('#cart_list').on('change', '.car_number', function () {

            var id = $(this).data('id');
            var number = $(this).val();


            var data = {product_id:id,_token:"{{ csrf_token() }}", number:number, action:"sync"};
            var url = "/cars";
            $.post(url, data, function(res){
                console.log(res);

                if (res.code != 302 && res.code != 200) {

                    layer.msg(res.msg, {icon: 2});
                    return;
                }

                if (res.code == 302) {

                    Car.syncnumber(id, number);
                }

                layer.msg(res.msg, {icon: 1});

                getTotal();
            });

        });

        getTotal();
        function getTotal()
        {
            var total = 0;
            var total_number = 0;
            $('.prices').each(function(){
                var price = $(this).text();
                var number = $(this).next().find('input').val();
                number = parseInt(number);

                total_number += number;
                total += price*number;
            });

            $('#cars_price').text(total);
            $('#cart-number').text(total_number);
        }
    </script>
@endsection
