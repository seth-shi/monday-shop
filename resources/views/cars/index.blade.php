@extends('layouts.shop')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">

                        <form action="/user/comment/orders/create" class="mb-30" method="get" id="create_form">

                            <div class="cart-wrapper">
                                <div class="cart-price">
                                    <div class="t-right">
                                        <!-- Checkout Area -->
                                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                            <h2 class="h3 mb-20 h-title">支付信息</h2>
                                            @include('hint.status')
                                            @include('hint.fail')


                                            <div class="row">


                                            </div>
                                            @auth
                                                <button type="submit" class="btn btn-lg btn-rounded mr-10">下单</button>
                                            @endauth
                                            @guest
                                                <a href="/login" class="btn btn-lg btn-rounded mr-10">下单</a>
                                            @endguest
                                        </section>
                                    </div>
                                </div>
                                <h3 class="h-title mb-30 t-uppercase">我的购物车</h3>
                                <table id="cart_list" class="cart-list mb-30">
                                    <thead class="panel t-uppercase">
                                    <tr>
                                        <th>
                                            <div class="custom-checkbox mb-20">
                                                <input type="checkbox"  id="all_check">
                                                <label class="color-mid" for="all_check"></label>
                                            </div>
                                        </th>
                                        <th>商品名字</th>
                                        <th>商品图片</th>
                                        <th>商品价格</th>
                                        <th>数量</th>
                                        <th>删除</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cars_data">
                                    @foreach ($cars as $car)
                                        <tr class="panel alert cars_td">
                                            <input type="hidden" name="cars[]" value="{{ $car->id }}">
                                            <td>
                                                <div class="custom-checkbox mb-20">
                                                    <input value="{{ $car->product->uuid }}" class="product_ids" type="checkbox" name="ids[]" id="cars_{{ $car->id }}">
                                                    <label class="color-mid" for="cars_{{ $car->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="media-body valign-middle">
                                                    <h6 class="title mb-15 t-uppercase">
                                                        <a href="/products/{{ $car->product->uuid }}">
                                                            {{ $car->product->name }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ $car->product->thumb }}" alt="">
                                            </td>
                                            <td class="prices">{{ $car->product->price }}</td>
                                            <td>
                                                <input
                                                        style="border-bottom: 1px solid #ddd;"
                                                        data-id="{{ $car->product->uuid }}"
                                                       class="quantity-label car_number"
                                                       type="number"
                                                        name="numbers[]"
                                                       value="{{ $car->number }}" id="{{ $car->product->uuid }}">
                                            </td>

                                            <td>
                                                <button data-number="{{ $car->number }}"
                                                        data-car="{{ $car->id }}"
                                                        data-id="{{ $car->product->uuid }}" class="close delete_car"
                                                        type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </form>
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

        function syncCarsToDatabase() {
            if (LocalCar.number() > 0) {
                layer.confirm('是否同步本地购物车到本账户下', {
                    btn: ['是', '放弃本地购物车']
                }, function () {
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
                                let html = buildCarDom(product.id, product.name, product.thumb, product.number, product.price);
                                $('#cars_data').append(html);
                            }

                            layer.msg('同步 [' + product.name + '] 商品到购物车成功');
                        });
                    }

                    localDom.text(0);
                    LocalCar.flush();

                }, function () {

                    LocalCar.flush();
                    localDom.text(0);
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
            dom += buildCarDom(product.id, product.name, product.thumb, product.number, product.price);
        }

        $('#cars_data').append(dom);
        getTotal();

        @endguest


        // 删除购物车
        $("#cart_list").on('click', '.delete_car', function () {

            let that = $(this);
            let id = that.data('id');
            let carId = that.data('car');

            @auth
            let _url = "/cars/" + carId;
            $.post(_url, {_token: token, _method: 'DELETE'}, function (res) {

                if (res.code != 302 && res.code != 200) {

                    layer.msg(res.msg, {icon: 2});
                    return;
                }

                that.parent().parent().remove();
                getTotal();
                renderIncrementCar(-that.data('number'), false);
            });
            @endauth
            @guest
            LocalCar.delete(id);
            that.parent().parent().remove();
            getTotal();
            renderIncrementCar(-that.data('number'), true);
            @endguest

        });


        // 更改购物车数量
        $('#cart_list').on('change', '.car_number', function () {

            let id = $(this).data('id');
            let number = $(this).val();


                    @auth
            let data = {product_id: id, _token: "{{ csrf_token() }}", number: number, action: "sync"};
            $.post("/cars", data, function (res) {


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

        function getTotal() {
            let total = 0;
            let total_number = 0;
            $('.prices').each(function () {
                let price = $(this).text();
                let number = $(this).next().find('input').val();
                number = parseInt(number);

                total_number += number;
                total += price * number;
            });

            $('#cars_price').text(total);
        }

        /**
         * 构建购物车的 dom
         */
        function buildCarDom(id, name, thumb, number, price) {
            return '<tr class="panel alert local-car">\
                <td>\
                     <div class="custom-checkbox mb-20">\
                     <input type="checkbox" name="ids" id="cars_'+ id +'">\
                     <label class="color-mid" for="cars_'+ id +'"></label>\
                </div>\
                </td>\
                <td>\
                <div class="media-body valign-middle">\
                <h6 class="title mb-15 t-uppercase">\
                <a href="/products/' + id + '">\
                    ' + name + '\
                </a>\
                </h6>\
                </div>\
                </td>\
                <td>\
                    <img src="' + thumb + '" alt="">\
                </td>\
                <td  class="prices">' + price + '</td>\
                <td>\
                <input data-id="' + id + '" class="quantity-label car_number" type="number" value="' + number + '">\
                </td>\
                <td>\
                <button type="button" class="close delete_car" data-number="' + price + '" data-id="' + id + '"  >\
                <i class="fa fa-trash-o"></i>\
                </button>\
                </td>\
                </tr>';
        }
    </script>
    <script>
        // 全选按钮
        $('#all_check').change(function () {

            var checked = $(this).prop('checked');

            $('.product_ids').prop('checked', checked);
        });

        // 商品的选择
        $('.product_ids').change(function () {

            var checked = $(this).prop('checked');
            // 只要不是选中，那么就把全选去掉
            if (! checked) {
                $('#all_check').prop('checked', false);
                return;
            }

            var carsCount = $('.product_ids').length;
            var selectCount = $('.product_ids:checked').length;
            if (carsCount === selectCount) {

                $('#all_check').prop('checked', true);
            }
        });

        // 提交做处理
        $('#create_form').submit(function () {

            if ($('.product_ids:checked').length == 0) {

                layer.alert('请至少选中一个购物车', {icon: 2})
                return false;
            }

            // 移除掉没有选中的td提交
            $('.product_ids:not(:checked)').parents('.cars_td').remove();

            return true;
        });

    </script>
@endsection
