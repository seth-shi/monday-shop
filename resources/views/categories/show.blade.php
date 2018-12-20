@extends('layouts.shop')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-10">
            <div class="container">

                <section class="store-header-area panel t-xs-center t-sm-left">
                    <div class="row row-rl-10">
                        <div class="col-sm-3 col-md-2 t-center">
                            <figure class="pt-20 pl-10">
                                <img src="{{ $category->thumb }}" alt="{{ $category->name }}">
                            </figure>
                        </div>

                        <div class="col-sm-5 col-md-6">
                            <div class="store-about ptb-30">
                                <h3 class="mb-10">{{ $category->name }}</h3>
                                <p class="mb-15">
                                    {{ $category->description }}
                                </p>
                                <button class="btn btn-info">好看</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="store-splitter-left">
                                <div class="left-splitter-header prl-10 ptb-20 bg-lighter">
                                    <div class="row">
                                        <div class="col-xs-12 t-center">
                                            <h2>{{ $category->products()->count() }}</h2>
                                            <p>商品</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section deals-area ptb-30">

                    <!-- Page Control -->
                    <header class="page-control panel ptb-15 prl-20 pos-r mb-30">

                        <!-- List Control View -->
                        <ul class="list-control-view list-inline">
                            <li><a href="/categories"><i class="fa fa-reply"></i></a>
                            </li>
                        </ul>
                        <!-- End List Control View -->
                        <div class="right-10 pos-tb-center">
                            <form id="order-form" action="" method="get">
                                <select id="order-select" name="orderBy" class="form-control input-sm">
                                    <option value="">排序</option>
                                    <option value="updated_at">最新的</option>
                                    <option value="likes">最受欢迎</option>
                                    <option value="price">价格</option>
                                </select>
                            </form>
                        </div>
                    </header>
                    <!-- End Page Control -->
                    <div class="row row-masnory row-tb-20">

                        @foreach ($categoryProducts as $product)
                            <div class="col-xs-12">
                                <div class="deal-single panel">
                                    <div class="row row-rl-0 row-sm-cell">
                                        <div class="col-sm-5">
                                            <a href="/products/{{ $product->uuid }}">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="{{ $product->thumb }}">
                                                    <div class="label-discount left-20 top-15">-50%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li  class="like-deal" data-id="{{ $product->uuid }}">
                                                            <span>
                                                                <i class="fa fa-heart"></i>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </figure>
                                            </a>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="bg-white pt-20 pl-20 pr-15">
                                                <div class="pr-md-10">
                                                    <div class="rating mb-10">
                                                        <div class="mb-10">
                                                            收藏人数 <span class="rating-count rating">{{ $product->users_count }}</span>
                                                        </div>
                                                    </div>
                                                    <h3 class="deal-title mb-10">
                                                        <a href="/products/{{ $product->uuid }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </h3>
                                                    <p class="text-muted mb-20">
                                                        {{ $product->title }}
                                                    </p>
                                                </div>
                                                <div class="deal-price pos-r mb-15">
                                                    <h3 class="price ptb-5 text-right">
                                                                <span class="price-sale">
                                                                    {{ $product->original_price }}
                                                                </span>
                                                        ￥ {{ $product->price }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Page Pagination -->
                    <div class="page-pagination text-center mt-30 p-10 panel">
                        <nav>
                            {{ $categoryProducts->appends(request()->only('orderBy'))->links() }}
                        </nav>
                    </div>
                    <!-- End Page Pagination -->

                </section>

            </div>
        </div>


    </main>
@endsection


@section('script')
    <script>
        $('.like-deal').click(function(){
            let id = $(this).data('id');

            alert('收藏商品ID ' + id);

            // 不传递父级点击事件
            return false;
        });

        $('.like-deal').hover(function(){
            $(this).find('i').css('color', 'red');
        }, function(){
            $(this).find('i').css('color', '#fff');
        });
    </script>
    <script>
        $('#order-select').change(function(){
            $('#order-form').submit();
        });
    </script>
@endsection
