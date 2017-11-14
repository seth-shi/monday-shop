@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
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
                                @inject('productPresenter', 'App\Presenters\ProductPresenter')
                                @foreach ($cars as $car)
                                <tr class="panel alert">
                                    <td>
                                        <div class="media-body valign-middle">
                                            <h6 class="title mb-15 t-uppercase">
                                                <a href="{{ url("/home/products/{$car->product->id}") }}">
                                                    {{ $car->product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="prices">{{ $car->product->price }}</td>
                                    <td>
                                        <input class="quantity-label" type="number" value="{{ $car->numbers }}">
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
                                    <a href="{{ url("/user/orders") }}" class="btn btn-rounded btn-lg">下单</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>
        var cars_span = '';
        var cars = localStorage;
        var cars_prices = 0;
        var token = "{{ csrf_token() }}";


        @auth
        syncCarsToDatabase();
        function syncCarsToDatabase()
        {
            var cars = localStorage;
            for (var i in cars) {
                var product = $.parseJSON(cars[i]);

                var data = {product_id: i, numbers: product.numbers, _token: token};
                var url = "{{ url('/home/cars') }}";
                console.log(product);

                $.post(url, data, function (res) {
                    layer.msg('同步购物车成功，请刷新查看');
                });
            }

            localStorage.clear();
        }
        @endauth

        for (var i in cars) {

            var procuct_id = i;
            var product = cars[i];
            product = $.parseJSON(product);

            cars_span += '<tr class="panel alert local-car">\
            <td>\
            <div class="media-body valign-middle">\
            <h6 class="title mb-15 t-uppercase">\
            <a href="{{ url("/home/products") }}/'+ i +'">\
                '+ product.name +'\
            </a>\
            </h6>\
            </div>\
            </td>\
            <td  class="prices">'+ product.price +'</td>\
            <td>\
            <input class="quantity-label" type="number" value="'+ product.numbers +'">\
            </td>\
            <td>\
            <button type="button" class="close delete_car" data-id="'+  procuct_id +'"  >\
            <i class="fa fa-trash-o"></i>\
            </button>\
            </td>\
            </tr>';

            cars_prices += product.price * product.numbers;
        }

        $('#cars_data').append(cars_span);
        getTotal();

        var cars_url = "{{ url("/home/cars") }}/";
        $('.delete_car').click(function () {
            var that = $(this);
            var id = that.data('id');
            var _url = cars_url + id;
            $.post(_url, {_token:token,_method:'DELETE'}, function(res){
                if (res.code == 302) {
                    localStorage.removeItem(id);
                }

                that.parent().parent().remove();
                getTotal();
            });
        });

        function getTotal()
        {
            var total = 0;
            $('.prices').each(function(){
                var price = $(this).text();
                var numbers = $(this).next().find('input').val();
                total += price*numbers;
            });

            $('#cars_price').text(total);
        }
    </script>
@endsection