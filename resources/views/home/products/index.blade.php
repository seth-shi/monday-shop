@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <section class="stores-area stores-area-v2">
                    <h3 class="mb-40 t-uppercase">分类列表</h3>
                    <div class="letters-toolbar p-10 panel mb-40">
                        <span class="all-stores"><a href="#">选择商品</a></span>

                        @foreach ($productPinyins as $pinyin)
                            <span>
                                <a class="pinyinBtn" href="javascript:;" data-pinyin="{{ $pinyin->first_pinyin }}">{{ $pinyin->first_pinyin }}</a>
                            </span>
                        @endforeach
                    </div>
                    <div class="stores-cat panel mb-40">
                        <h3 class="stores-cat-header" id="pinyin_char">随机展示商品</h3>
                        <ul class="row stores-cat-body" id="data">

                            <li class="col-sm-4">
                                <ul>
                                    @if (isset($products[0]))
                                        @foreach ($products[0] as $product)
                                            <li><a href="{{ url("/home/products/{$product->id}") }}"> {{ $product->name }} </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="col-sm-4">
                                <ul>
                                    @if (isset($products[1]))
                                        @foreach ($products[1] as $product)
                                            <li><a href="{{ url("/home/products/{$product->id}") }}"> {{ $product->name }} </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="col-sm-4">
                                <ul>
                                    @if (isset($products[2]))
                                        @foreach ($products[2] as $product)
                                            <li><a href="{{ url("/home/products/{$product->id}") }}"> {{ $product->name }} </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        <!-- End Page Container -->


    </main>




@endsection



@section('script')
    <script>
        var url = "{{ url("/home/products/pinyin") }}/";
        var loadImg = '<div style="background: #ddd"><img src="{{ asset('images/loading.svg') }}" style="width: 100%; height: auto;" alt=""></div>';
        var dataContainer = $('#data');

        $('.pinyinBtn').click(function(){
            var pinyin = $(this).data('pinyin');
            var _url = url +  pinyin;
            dataContainer.html(loadImg);

            $.get(_url, function(res){

                var str = '';

                for (var i in res) {
                    var products = res[i];
                    str += '<li class="col-sm-4"><ul>';
                    for (var j in products) {
                        str += "<li><a href="+ url + products[j]['id'] +">"+ products[j]['name'] +"</a></li>";
                    }
                    str += '</ul></li>';
                }

                $('#pinyin_char').text(pinyin);
                dataContainer.html(str);
            });
        });
    </script>
@endsection