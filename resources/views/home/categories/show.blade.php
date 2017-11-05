@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-10">
            <div class="container">
                <section class="section deals-area ptb-30">

                    <!-- Page Control -->
                    <header class="page-control panel ptb-15 prl-20 pos-r mb-30">

                        <!-- List Control View -->
                        <ul class="list-control-view list-inline">
                            <li><a href="deals_list.html"><i class="fa fa-bars"></i></a>
                            </li>
                            <li><a href="deals_grid.html"><i class="fa fa-th"></i></a>
                            </li>
                        </ul>
                        <!-- End List Control View -->
                        <div class="right-10 pos-tb-center">
                            <select class="form-control input-sm">
                                <option>SORT BY</option>
                                <option>Newest items</option>
                                <option>Best sellers</option>
                                <option>Best rated</option>
                                <option>Price: low to high</option>
                                <option>Price: high to low</option>
                            </select>
                        </div>
                    </header>
                    <!-- End Page Control -->
                    <div class="row row-masnory row-tb-20">
                        @inject('productPresenter', 'App\Presenters\ProductPresenter')
                        @foreach ($categoryProducts as $product)
                            <div class="col-xs-12">
                                <div class="deal-single panel">
                                    <div class="row row-rl-0 row-sm-cell">
                                        <div class="col-sm-5">
                                            <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="{{ $productPresenter->getThumbLink($product->thumb) }}">
                                                <div class="label-discount left-20 top-15">-50%</div>
                                                <ul class="deal-actions top-15 right-20">
                                                    <li class="like-deal" data-id="{{ $product->id }}">
                                                                <span>
                                                                    <i class="fa fa-heart"></i>
                                                                </span>
                                                    </li>
                                                </ul>
                                            </figure>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="bg-white pt-20 pl-20 pr-15">
                                                <div class="pr-md-10">
                                                    <div class="rating mb-10">
                                                        <div class="mb-10">
                                                            收藏人数 <span class="rating-count rating">{{ $product->likes }}</span>
                                                        </div>
                                                    </div>
                                                    <h3 class="deal-title mb-10">
                                                        <a href="deal_single.html">
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
                                                                    {{ $product->price_original }}
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
                            {{ $categoryProducts->links() }}
                        </nav>
                    </div>
                    <!-- End Page Pagination -->

                </section>

            </div>
        </div>


    </main>
@endsection