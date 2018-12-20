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
                                        <input data-id="{{ $car->product->uuid }}" class="quantity-label car_number" type="number" value="{{ $car->number }}" id="{{ $car->product->uuid }}">
                                    </td>

                                    <td>
                                        <button data-number="{{ $car->number }}" data-id="{{ $car->product->uuid }}" class="close delete_car" type="button" >
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
        let token = "{{ csrf_token() }}";



        @auth
            syncCarsToDatabase();
            function syncCarsToDatabase()
            {
                if (LocalCar.number() > 0) {
                    layer.confirm('是否同步本地购物车到本账户下', {
                        btn: ['是', '放弃本地购物车']
                    }, function(){
                        layer.closeAll();

                        let cars = LocalCar.all();
                        for (let i in cars) {

                            let product = cars[i];

                            let data = {product_id: product.id, number: product.number, _token: token};
                            let url = "/cars";

                            $.post(url, data, function (res) {

                                if (res.code != 200) {

                                    layer.msg(res.msg, {icon: 2});
                                    return;
                                }

                                // 更新 DOM，如果已经有了这个元素，那么加数量，
                                // 如果是没有的，新增加 DOM
                                let dom = $('#' + product.id);
                                if (dom.length > 0) {
                                    dom.val(parseInt(dom.val()) + product.number);
                                } else {
                                    // 增加 DOM
                                    let html = buildCarDom(product.id, product.name, product.number, product.price);
                                    $('#cars_data').append(html);
                                }

                                layer.msg('同步 ['+ product.name +'] 商品到购物车成功');
                            });
                        }

                        LocalCar.flush();

                    }, function () {

                        LocalCar.flush();
                        layer.msg('清除本地购物车成功');
                    });
                }
            }
        @endauth

        @guest
            let localCars = LocalCar.all();
            let dom = '';

            for (let i in localCars) {

                let product = localCars[i];
                dom += buildCarDom(product.id, product.name, product.number, product.price);
            }

            $('#cars_data').append(dom);
            getTotal();

         @endguest


        // 删除购物车
        $("#cart_list").on('click', '.delete_car', function () {

            let that = $(this);
            let id = that.data('id');

            @auth
                let _url = "/cars/" + id;
                $.post(_url, {_token:token,_method:'DELETE'}, function(res){

                    if (res.code != 302 && res.code != 200) {

                        layer.msg(res.msg, {icon: 2});
                        return;
                    }

                    that.parent().parent().remove();
                    getTotal();
                    renderIncrementCar(- that.data('number'), false);
                });
            @endauth
            @guest
                LocalCar.delete(id);
                that.parent().parent().remove();
                getTotal();
                renderIncrementCar(- that.data('number'), true);
            @endguest

        });


        // 更改购物车数量
        $('#cart_list').on('change', '.car_number', function () {

            let id = $(this).data('id');
            let number = $(this).val();


            @auth
                let data = {product_id:id,_token:"{{ csrf_token() }}", number:number, action:"sync"};
                $.post("/cars", data, function(res){


                if (res.code != 200) {

                    layer.msg(res.msg, {icon: 2});
                    return;
                }

                layer.msg(res.msg, {icon: 1});
                renderIncrementCar(res.data.change, false);
                getTotal();
            });
            @endauth
            @guest
                let change = LocalCar.syncNumber(id, number);
                layer.msg('本地修改成功', {icon: 1});
                renderIncrementCar(change, true);
                getTotal();
            @endguest




        });

        // 更新总价
        getTotal();
        function getTotal()
        {
            let total = 0;
            let total_number = 0;
            $('.prices').each(function(){
                let price = $(this).text();
                let number = $(this).next().find('input').val();
                number = parseInt(number);

                total_number += number;
                total += price*number;
            });

            $('#cars_price').text(total);
        }

        /**
         * 构建购物车的 dom
         */
        function buildCarDom(id, name, number, price)
        {
            return '<tr class="panel alert local-car">\
                <td>\
                <div class="media-body valign-middle">\
                <h6 class="title mb-15 t-uppercase">\
                <a href="/products/'+ id +'">\
                    '+ name +'\
                </a>\
                </h6>\
                </div>\
                </td>\
                <td  class="prices">'+ price +'</td>\
                <td>\
                <input data-id="'+ id +'" class="quantity-label car_number" type="number" value="'+ number +'">\
                </td>\
                <td>\
                <button type="button" class="close delete_car" data-number="'+ price +'" data-id="'+ id +'"  >\
                <i class="fa fa-trash-o"></i>\
                </button>\
                </td>\
                </tr>';
        }
    </script>
@endsection
