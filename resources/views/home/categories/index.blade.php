@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <div class="row row-rl-10 row-tb-20">
                    <div class="page-content col-xs-12 col-md-8">


                        <section class="section deals-area">

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
                            <div class="row row-tb-20">
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_01.jpg">
                                                    <div class="label-discount left-20 top-15">-50%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2019/09/01 01:30:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_01.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="5">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">241</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">The Crash Bad Instant Folding Twin Bed</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United State</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>120 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$150.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_02.jpg">
                                                    <div class="label-discount left-20 top-15">-30%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2020/10/10 12:25:10"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_02.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="3">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">132</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Western Digital USB 3.0 Hard Drives</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United Kingdom</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>42 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$150.00</span>$100.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_03.jpg">
                                                    <div class="label-discount left-20 top-15">-30%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2020/10/10 12:25:10"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_03.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="4">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">160</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Hampton Bay LED Light Ceiling Exhaust Fan</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>Australia</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>75 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$150.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_04.jpg">
                                                    <div class="label-discount left-20 top-15">-15%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2018/01/02 10:35:23"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_04.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="2">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">100</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Timberland Men's Thorton Waterproof Boots</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>Canada</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>10 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$380.00</span>$340.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_05.jpg">
                                                    <div class="label-discount left-20 top-15">-60%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2021/12/03 03:15:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_05.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="3">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">32</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">New and Refurbished Lenovo Laptops</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United State</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>65 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$700.00</span>$576.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_06.jpg">
                                                    <div class="label-discount left-20 top-15">-60%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2019/10/10 12:00:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_06.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="5">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">29</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Buying a TV Is Easy When You Know These Terms</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United Kingdom</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>134 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$250.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_07.jpg">
                                                    <div class="label-discount left-20 top-15">-50%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2019/09/01 01:30:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_01.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="5">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">241</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">The Crash Bad Instant Folding Twin Bed</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United State</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>120 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$150.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_08.jpg">
                                                    <div class="label-discount left-20 top-15">-30%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2020/10/10 12:25:10"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_02.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="3">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">132</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Western Digital USB 3.0 Hard Drives</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United Kingdom</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>42 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$150.00</span>$100.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_09.jpg">
                                                    <div class="label-discount left-20 top-15">-30%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2020/10/10 12:25:10"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_03.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="4">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">160</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Hampton Bay LED Light Ceiling Exhaust Fan</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>Australia</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>75 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$150.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_10.jpg">
                                                    <div class="label-discount left-20 top-15">-15%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2018/01/02 10:35:23"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_04.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="2">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">100</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Timberland Men's Thorton Waterproof Boots</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>Canada</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>10 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$380.00</span>$340.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_11.jpg">
                                                    <div class="label-discount left-20 top-15">-60%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2021/12/03 03:15:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_05.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="3">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">32</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">New and Refurbished Lenovo Laptops</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United State</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>65 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$700.00</span>$576.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="deal-single panel">
                                        <div class="row row-rl-0 row-sm-cell">
                                            <div class="col-sm-5">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9 col-absolute-cell" data-bg-img="assets/images/deals/deal_12.jpg">
                                                    <div class="label-discount left-20 top-15">-60%</div>
                                                    <ul class="deal-actions top-15 right-20">
                                                        <li class="like-deal">
                                                                <span>
						                                <i class="fa fa-heart"></i>
						                            </span>
                                                        </li>
                                                        <li class="share-btn">
                                                            <div class="share-tooltip fade">
                                                                <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                            </div>
                                                            <span><i class="fa fa-share-alt"></i></span>
                                                        </li>
                                                        <li>
                                                                <span>
						                                <i class="fa fa-camera"></i>
						                            </span>
                                                        </li>
                                                    </ul>
                                                    <div class="time-left bottom-15 right-20 font-md-14 is-hidden-md-up is-hidden-md-down">
                                                            <span>
						                        	<i class="ico fa fa-clock-o mr-10"></i>
						                        	<span class="t-uppercase" data-countdown="2019/10/10 12:00:00"></span>
						                        </span>
                                                    </div>
                                                    <div class="deal-store-logo">
                                                        <img src="assets/images/brands/brand_06.jpg" alt="">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="bg-white pt-20 pl-20 pr-15">
                                                    <div class="pr-md-10">
                                                        <div class="rating mb-10">
                                                                <span class="rating-stars rate-allow" data-rating="5">
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        		<i class="fa fa-star-o"></i>
						                        	</span>
                                                            <span class="rating-reviews">
						                        		( <span class="rating-count">29</span> rates )
                                                                </span>
                                                        </div>
                                                        <h3 class="deal-title mb-10">
                                                            <a href="deal_single.html">Buying a TV Is Easy When You Know These Terms</a>
                                                        </h3>
                                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                                            <li><i class="ico fa fa-map-marker mr-10"></i>United Kingdom</li>
                                                            <li><i class="ico fa fa-shopping-basket mr-10"></i>134 Bought</li>
                                                        </ul>
                                                        <p class="text-muted mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam numquam nostrum.</p>
                                                    </div>
                                                    <div class="deal-price pos-r mb-15">
                                                        <h3 class="price ptb-5 text-right"><span class="price-sale">$300.00</span>$250.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Page Pagination -->
                            <div class="page-pagination text-center mt-30 p-10 panel">
                                <nav>
                                    <!-- Page Pagination -->
                                    <ul class="page-pagination">
                                        <li><a class="page-numbers previous" href="#">Previous</a>
                                        </li>
                                        <li><a href="#" class="page-numbers">1</a>
                                        </li>
                                        <li><span class="page-numbers current">2</span>
                                        </li>
                                        <li><a href="#" class="page-numbers">3</a>
                                        </li>
                                        <li><a href="#" class="page-numbers">4</a>
                                        </li>
                                        <li><span class="page-numbers dots">...</span>
                                        </li>
                                        <li><a href="#" class="page-numbers">20</a>
                                        </li>
                                        <li><a href="#" class="page-numbers next">Next</a>
                                        </li>
                                    </ul>
                                    <!-- End Page Pagination -->
                                </nav>
                            </div>
                            <!-- End Page Pagination -->

                        </section>

                    </div>
                    <div class="page-sidebar col-md-4 col-xs-12">

                        <!-- Blog Sidebar -->
                        <aside class="sidebar blog-sidebar">
                            <div class="row row-tb-10">
                                <div class="col-xs-12">
                                    <!-- Latest Deals Widegt -->
                                    <div class="widget latest-deals-widget panel prl-20">
                                        <div class="widget-body ptb-20">
                                            <div class="owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">
                                                <div class="latest-deals__item item">
                                                    <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_02.jpg">
                                                        <div class="label-discount top-10 right-10">-30%</div>
                                                        <ul class="deal-actions top-10 left-10">
                                                            <li class="like-deal">
                                                                    <span>
		                        <i class="fa fa-heart"></i>
		                    </span>
                                                            </li>
                                                            <li class="share-btn">
                                                                <div class="share-tooltip fade">
                                                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                                </div>
                                                                <span><i class="fa fa-share-alt"></i></span>
                                                            </li>
                                                            <li>
                                                                    <span>
		                        <i class="fa fa-camera"></i>
		                    </span>
                                                            </li>
                                                        </ul>
                                                        <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                            <div class="rating mb-10">
                                                                    <span class="rating-stars rate-allow" data-rating="4">
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                    </span>
                                                                <span class="rating-reviews color-lighter">
		                    	(<span class="rating-count">160</span> Reviews)
                                                                    </span>
                                                            </div>
                                                            <h5 class="deal-title mb-10">
                                                                <a href="deal_single.html" class="color-lighter">Hampton Bay LED Light Ceiling Exhaust Fan</a>
                                                            </h5>
                                                        </div>
                                                    </figure>
                                                </div>
                                                <div class="latest-deals__item item">
                                                    <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_03.jpg">
                                                        <div class="label-discount top-10 right-10">-15%</div>
                                                        <ul class="deal-actions top-10 left-10">
                                                            <li class="like-deal">
                                                                    <span>
		                        <i class="fa fa-heart"></i>
		                    </span>
                                                            </li>
                                                            <li class="share-btn">
                                                                <div class="share-tooltip fade">
                                                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                                </div>
                                                                <span><i class="fa fa-share-alt"></i></span>
                                                            </li>
                                                            <li>
                                                                    <span>
		                        <i class="fa fa-camera"></i>
		                    </span>
                                                            </li>
                                                        </ul>
                                                        <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                            <div class="rating mb-10">
                                                                    <span class="rating-stars rate-allow" data-rating="2">
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                    </span>
                                                                <span class="rating-reviews color-lighter">
		                    	(<span class="rating-count">100</span> Reviews)
                                                                    </span>
                                                            </div>
                                                            <h5 class="deal-title mb-10">
                                                                <a href="deal_single.html" class="color-lighter">Timberland Men's Thorton Waterproof Boots</a>
                                                            </h5>
                                                        </div>
                                                    </figure>
                                                </div>
                                                <div class="latest-deals__item item">
                                                    <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_04.jpg">
                                                        <div class="label-discount top-10 right-10">-60%</div>
                                                        <ul class="deal-actions top-10 left-10">
                                                            <li class="like-deal">
                                                                    <span>
		                        <i class="fa fa-heart"></i>
		                    </span>
                                                            </li>
                                                            <li class="share-btn">
                                                                <div class="share-tooltip fade">
                                                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                                </div>
                                                                <span><i class="fa fa-share-alt"></i></span>
                                                            </li>
                                                            <li>
                                                                    <span>
		                        <i class="fa fa-camera"></i>
		                    </span>
                                                            </li>
                                                        </ul>
                                                        <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                            <div class="rating mb-10">
                                                                    <span class="rating-stars rate-allow" data-rating="3">
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                    </span>
                                                                <span class="rating-reviews color-lighter">
		                    	(<span class="rating-count">32</span> Reviews)
                                                                    </span>
                                                            </div>
                                                            <h5 class="deal-title mb-10">
                                                                <a href="deal_single.html" class="color-lighter">New and Refurbished Lenovo Laptops</a>
                                                            </h5>
                                                        </div>
                                                    </figure>
                                                </div>
                                                <div class="latest-deals__item item">
                                                    <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_05.jpg">
                                                        <div class="label-discount top-10 right-10">-60%</div>
                                                        <ul class="deal-actions top-10 left-10">
                                                            <li class="like-deal">
                                                                    <span>
		                        <i class="fa fa-heart"></i>
		                    </span>
                                                            </li>
                                                            <li class="share-btn">
                                                                <div class="share-tooltip fade">
                                                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                                    <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                                </div>
                                                                <span><i class="fa fa-share-alt"></i></span>
                                                            </li>
                                                            <li>
                                                                    <span>
		                        <i class="fa fa-camera"></i>
		                    </span>
                                                            </li>
                                                        </ul>
                                                        <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                            <div class="rating mb-10">
                                                                    <span class="rating-stars rate-allow" data-rating="5">
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                        <i class="fa fa-star-o"></i>
		                    </span>
                                                                <span class="rating-reviews color-lighter">
		                    	(<span class="rating-count">29</span> Reviews)
                                                                    </span>
                                                            </div>
                                                            <h5 class="deal-title mb-10">
                                                                <a href="deal_single.html" class="color-lighter">Buying a TV Is Easy When You Know These Terms</a>
                                                            </h5>
                                                        </div>
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Latest Deals Widegt -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Best Rated Deals -->
                                    <div class="widget best-rated-deals panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Best Rated Deals</h3>
                                        <div class="widget-body ptb-30">


                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="assets/images/deals/thumb_01.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-5">
                                                        <a href="#">Aenean ut orci vel massa</a>
                                                    </h6>
                                                    <div class="mb-5">
                                                            <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                                                            </span>
                                                    </div>
                                                    <h4 class="price font-16">$60.00 <span class="price-sale color-muted">$200.00</span></h4>
                                                </div>
                                            </div>


                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="assets/images/deals/thumb_02.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-5">
                                                        <a href="#">Aenean ut orci vel massa</a>
                                                    </h6>
                                                    <div class="mb-5">
                                                            <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                                                            </span>
                                                    </div>
                                                    <h4 class="price font-16">$60.00 <span class="price-sale color-muted">$200.00</span></h4>
                                                </div>
                                            </div>


                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="assets/images/deals/thumb_03.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-5">
                                                        <a href="#">Aenean ut orci vel massa</a>
                                                    </h6>
                                                    <div class="mb-5">
                                                            <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                                                            </span>
                                                    </div>
                                                    <h4 class="price font-16">$60.00 <span class="price-sale color-muted">$200.00</span></h4>
                                                </div>
                                            </div>


                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="assets/images/deals/thumb_04.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-5">
                                                        <a href="#">Aenean ut orci vel massa</a>
                                                    </h6>
                                                    <div class="mb-5">
                                                            <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                                                            </span>
                                                    </div>
                                                    <h4 class="price font-16">$60.00 <span class="price-sale color-muted">$200.00</span></h4>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- Best Rated Deals -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Subscribe Widget -->
                                    <div class="widget subscribe-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Subscribe to mail</h3>
                                        <div class="widget-content ptb-30">

                                            <p class="color-mid mb-20">Get our Daily email newsletter with Special Services, Updates, Offers and more!</p>
                                            <form method="post" action="#">
                                                <div class="input-group">
                                                    <input type="email" class="form-control" placeholder="Your Email Address" required="required">
                                                    <span class="input-group-btn">
		        	<button class="btn" type="submit">Sign Up</button>
		    	</span>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- End Subscribe Widget -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Trending Stores -->
                                    <div class="widget trend-store-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Trending Stores</h3>
                                        <div class="widget-body ptb-30">


                                            <div class="trend-store-item media">
                                                <div class="post-thumb media-left">
                                                    <a href="#">
                                                        <img class="media-object pr-10" width="90" src="assets/images/brands/brand_01.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="store_single_01.html">Amazon</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Upto 70% Rewards Lorem ipsum dolor sit amet.</p>
                                                </div>
                                            </div>


                                            <div class="trend-store-item media">
                                                <div class="post-thumb media-left">
                                                    <a href="#">
                                                        <img class="media-object pr-10" width="90" src="assets/images/brands/brand_02.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="store_single_01.html">Ashford</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Upto 70% Rewards Lorem ipsum dolor sit amet.</p>
                                                </div>
                                            </div>


                                            <div class="trend-store-item media">
                                                <div class="post-thumb media-left">
                                                    <a href="#">
                                                        <img class="media-object pr-10" width="90" src="assets/images/brands/brand_03.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="store_single_01.html">DELL</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="4">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Upto 70% Rewards Lorem ipsum dolor sit amet.</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Trending Stores -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Instagram Widget -->
                                    <div class="widget instagram-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Instagram</h3>
                                        <div class="widget-body ptb-30">

                                            <div class="row row-tb-5 row-rl-5">


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_01.jpg" alt="">
                                                </div>


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_02.jpg" alt="">
                                                </div>


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_03.jpg" alt="">
                                                </div>


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_04.jpg" alt="">
                                                </div>


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_05.jpg" alt="">
                                                </div>


                                                <div class="instagram-widget__item col-xs-4">
                                                    <img src="assets/images/instagram/instagram_06.jpg" alt="">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Instagram Widget -->
                                </div>
                                <div class="col-xs-12">

                                    <!-- Instagram Widget -->
                                    <div class="widget subscribe-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Latest tweets</h3>
                                        <div class="widget-body ptb-20">

                                            <ul class="twitter-list">
                                                <li class="twitter-list__item">
                                                    <p>
                                                        <i class="twitter-icon fa fa-twitter"></i>
                                                        <a href="#">@masum_rana :</a>
                                                        <span class="tweet-text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</span>
                                                    </p>
                                                </li>
                                                <li class="twitter-list__item">
                                                    <p>
                                                        <i class="twitter-icon fa fa-twitter"></i>
                                                        <a href="#">@masum_rana :</a>
                                                        <span class="tweet-text">Recusandae sed, aperiam earum sapiente rem neque officiis quaerat.</span>
                                                    </p>
                                                </li>
                                                <li class="twitter-list__item">
                                                    <p>
                                                        <i class="twitter-icon fa fa-twitter"></i>
                                                        <a href="#">@masum_rana :</a>
                                                        <span class="tweet-text">Sed quaerat, error harum sunt, sapiente voluptas temporibus porro quam, magnam dolores recusandae.</span>
                                                    </p>
                                                </li>
                                                <li class="twitter-list__item">
                                                    <p>
                                                        <i class="twitter-icon fa fa-twitter"></i>
                                                        <a href="#">@masum_rana :</a>
                                                        <span class="tweet-text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</span>
                                                    </p>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <!-- End Instagram Widget -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Latest Reviews -->
                                    <div class="widget posted-reviews-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Recent Reviews</h3>
                                        <div class="widget-body ptb-30">
                                            <!-- Review -->
                                            <div class="review media">
                                                <div class="media-left pr-10">
                                                    <a href="#">
                                                        <img class="media-object img-circle" src="assets/images/avatars/avatar_01.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="#">John Doe</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="3">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Vivamus sem massa, cursus at mollis eu, euismod id risus. Ve...</p>
                                                </div>
                                            </div>
                                            <!-- End Review -->
                                            <!-- Review -->
                                            <div class="review media">
                                                <div class="media-left pr-10">
                                                    <a href="#">
                                                        <img class="media-object img-circle" src="assets/images/avatars/avatar_02.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="#">John Doe</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="3">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Nullam porttitor porta augue vel iaculis. Pellentesque a pre...</p>
                                                </div>
                                            </div>
                                            <!-- End Review -->
                                            <!-- Review -->
                                            <div class="review media">
                                                <div class="media-left pr-10">
                                                    <a href="#">
                                                        <img class="media-object img-circle" src="assets/images/avatars/avatar_03.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="#">John Doe</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="3">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Ut consequat eget nulla eu ultrices. Curabitur ac pellentesq...</p>
                                                </div>
                                            </div>
                                            <!-- End Review -->
                                            <!-- Review -->
                                            <div class="review media">
                                                <div class="media-left pr-10">
                                                    <a href="#">
                                                        <img class="media-object img-circle" src="assets/images/avatars/avatar_04.jpg" alt="Thumb" width="80">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-5">
                                                        <a href="#">John Doe</a>
                                                        <span class="rating">
                        <span class="rating-stars" data-rating="3">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                    </span>
                                                    </h5>
                                                    <p class="color-mid">Duis eu lectus dictum, placerat quam sed, ornare urna....</p>
                                                </div>
                                            </div>
                                            <!-- End Review -->
                                        </div>
                                    </div>
                                    <!-- End Latest Reviews -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Contact Us Widget -->
                                    <div class="widget contact-us-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Got any questions?</h3>
                                        <div class="widget-body ptb-30">
                                            <p class="mb-20 color-mid">If you are having any questions, please feel free to ask.</p>
                                            <a href="contact_us_01.html" class="btn btn-block"><i class="mr-10 font-15 fa fa-envelope-o"></i>Drop Us a Line</a>
                                        </div>
                                    </div>
                                    <!-- End Contact Us Widget -->
                                </div>
                            </div>
                        </aside>
                        <!-- End Blog Sidebar -->
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection