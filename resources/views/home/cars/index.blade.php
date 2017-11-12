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
                                    <td>{{ $car->product->price }}</td>
                                    <td>
                                        <input class="quantity-label" type="number" value="{{ $car->numbers }}">
                                    </td>

                                    <td>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
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
                                            小计
                                        </div>
                                        <div class="price">
                                            $68.50
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-name">
                                            <strong class="t-uppercase">Order total</strong>
                                        </div>
                                        <div class="price">
                                            <span>$150.50</span>
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
    <script>
        var cars_span = '';
        var cars = localStorage;

        console.log(cars);
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
            <td>'+ product.price +'</td>\
            <td>\
            <input class="quantity-label" type="number" value="'+ product.numbers +'">\
            </td>\
            <td>\
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">\
            <i class="fa fa-trash-o"></i>\
            </button>\
            </td>\
            </tr>';

        }

        $('#cars_data').append(cars_span);

    </script>
@endsection