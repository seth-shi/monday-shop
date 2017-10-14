<header id="mainHeader" class="main-header">

    <!-- Top Bar -->
    <div class="top-bar bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 is-hidden-sm-down">
                    <ul class="nav-top nav-top-left list-inline t-left">
                        <li><a href="terms_conditions.html"><i class="fa fa-question-circle"></i>指南</a>
                        </li>
                        <li><a href="faq.html"><i class="fa fa-support"></i>帮助</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-8">
                    <ul class="nav-top nav-top-right list-inline t-xs-center t-md-right">
                        <li>
                            <a href="#"><i class="fa fa-flag-checkered"></i>游客</a>
                        </li>
                        <li><a href="{{ url('login') }}"><i class="fa fa-lock"></i>登录</a>
                        </li>
                        <li><a href="{{ url('register') }}"><i class="fa fa-user"></i>注册</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->

    <!-- Header Header -->
    <div class="header-header bg-white">
        <div class="container">
            <div class="row row-rl-0 row-tb-20 row-md-cell">
                <div class="brand col-md-3 t-xs-center t-md-left valign-middle">
                    <a href="#" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" width="250">
                    </a>
                </div>
                <div class="header-search col-md-9">
                    <div class="row row-tb-10 ">
                        <div class="col-sm-8">
                            <form class="search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg search-input" placeholder="输入关键字 ..." required="required">
                                    <div class="input-group-btn">
                                        <div class="input-group">
                                            <select class="form-control input-lg search-select">
                                                <option>选择分类</option>
                                                <option>科  技</option>
                                                <option>家  居</option>
                                                <option>食  品</option>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-lg btn-search btn-block">
                                                    <i class="fa fa-search font-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4 t-xs-center t-md-right">
                            <div class="header-cart">
                                <a href="cart.html">
                                    <span class="icon lnr lnr-cart"></span>
                                    <div><span class="cart-number">0</span>
                                    </div>
                                    <span class="title">Cart</span>
                                </a>
                            </div>
                            <div class="header-wishlist ml-20">
                                <a href="wishlist.html">
                                    <span class="icon lnr lnr-heart font-30"></span>
                                    <span class="title">收藏列表</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Header -->

    <!-- Header Menu -->
    <div class="header-menu bg-blue">
        <div class="container">
            <nav class="nav-bar">
                <div class="nav-header">
                            <span class="nav-toggle" data-toggle="#header-navbar">
		                        <i></i>
		                        <i></i>
		                        <i></i>
		                    </span>
                </div>
                <div id="header-navbar" class="nav-collapse">
                    <ul class="nav-menu">
                        <li class="active">
                            <a href="index.html">主页</a>
                        </li>
                        <li class="dropdown-mega-menu">
                            <a href="deals_grid.html">交易</a>
                            <div class="mega-menu">
                                <div class="row row-v-10">
                                    <div class="col-md-3">
                                        <ul>
                                            <li><a href="deals_grid.html">网格视图</a>
                                            </li>
                                            <li><a href="deals_grid_sidebar.html">电网侧边栏</a>
                                            </li>
                                            <li><a href="deals_list.html">查看列表</a>
                                            </li>
                                            <li><a href="deal_single.html">处理单</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_03.jpg">
                                            <div class="label-discount top-10 right-10">-15%</div>
                                            <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                <div class="rating mb-10">
                                                            <span class="rating-stars rate-allow" data-rating="2">
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                    </span>
                                                </div>
                                                <h6 class="deal-title mb-10">
                                                    <a href="deal_single.html" class="color-lighter">Aenean ut orci vel massa</a>
                                                </h6>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="col-md-3">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_04.jpg">
                                            <div class="label-discount top-10 right-10">-60%</div>
                                            <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                <div class="rating mb-10">
                                                            <span class="rating-stars rate-allow" data-rating="3">
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                    </span>
                                                </div>
                                                <h6 class="deal-title mb-10">
                                                    <a href="deal_single.html" class="color-lighter">Aenean ut orci vel massa</a>
                                                </h6>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="col-md-3">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="assets/images/deals/deal_05.jpg">
                                            <div class="label-discount top-10 right-10">-60%</div>
                                            <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                <div class="rating mb-10">
                                                            <span class="rating-stars rate-allow" data-rating="5">
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                        <i class="fa fa-star-o"></i>
										                    </span>
                                                </div>
                                                <h6 class="deal-title mb-10">
                                                    <a href="deal_single.html" class="color-lighter">Aenean ut orci vel massa</a>
                                                </h6>
                                            </div>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="coupons_grid.html">礼券</a>
                            <ul>
                                <li><a href="coupons_grid.html">Grid View</a>
                                </li>
                                <li><a href="coupons_grid_sidebar.html">Grid With Sidebar</a>
                                </li>
                                <li><a href="coupons_list.html">List View</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="stores_01.html">商店</a>
                            <ul>
                                <li><a href="stores_01.html">Stores Search</a>
                                </li>
                                <li><a href="stores_02.html">Stores Categories</a>
                                </li>
                                <li><a href="store_single_01.html">Store Single 1</a>
                                </li>
                                <li><a href="store_single_02.html">Store Single 2</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="contact_us_01.html">联系我们</a>
                            <ul>
                                <li><a href="contact_us_01.html">Contact Us 1</a>
                                </li>
                                <li><a href="contact_us_02.html">Contact Us 2</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">博客</a>
                            <ul>
                                <li>
                                    <a href="#">Classic View</a>
                                    <ul>
                                        <li><a href="blog_classic_right_sidebar.html">Right Sidenar</a>
                                        </li>
                                        <li><a href="blog_classic_left_sidebar.html">Left Sidebar</a>
                                        </li>
                                        <li><a href="blog_classic_fullwidth.html">Full Width</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Grid View</a>
                                    <ul>
                                        <li><a href="blog_grid_3col.html">3 Columns</a>
                                        </li>
                                        <li><a href="blog_grid_2col.html">2 Columns</a>
                                        </li>
                                        <li><a href="blog_grid_right_sidebar.html">Right Sidebar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">List View</a>
                                    <ul>
                                        <li><a href="blog_list_right_sidebar.html">Right Sidenar</a>
                                        </li>
                                        <li><a href="blog_list_left_sidebar.html">Left Sidebar</a>
                                        </li>
                                        <li><a href="blog_list_fullwidth.html">Full Width</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Blog Single</a>
                                    <ul>
                                        <li><a href="blog_single_standard.html">Standard Post</a>
                                        </li>
                                        <li><a href="blog_single_gallery.html">Gallery Post</a>
                                        </li>
                                        <li><a href="blog_single_youtube.html">Youtube Video</a>
                                        </li>
                                        <li><a href="blog_single_vimeo.html">Vimeo Video</a>
                                        </li>
                                        <li><a href="blog_single_map.html">Google Map</a>
                                        </li>
                                        <li><a href="blog_single_quote.html">Quote Post</a>
                                        </li>
                                        <li><a href="blog_single_audio.html">Audio Post</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">页面</a>
                            <ul>
                                <li><a href="index.html">Home Default</a>
                                </li>
                                <li><a href="signin.html">Sign In</a>
                                </li>
                                <li><a href="signup.html">Sign Up</a>
                                </li>
                                <li><a href="404.html">404 Page</a>
                                </li>
                                <li><a href="faq.html">FAQ Page</a>
                                </li>
                                <li><a href="cart.html">Cart Page</a>
                                </li>
                                <li>
                                    <a href="checkout_method.html">Checkout</a>
                                    <ul>
                                        <li><a href="checkout_method.html">Checkout method</a>
                                        </li>
                                        <li><a href="checkout_billing.html">Billing Information</a>
                                        </li>
                                        <li><a href="checkout_payment.html">Payment Information</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Contact Us</a>
                                    <ul>
                                        <li><a href="contact_us_01.html">Contact Us 1</a>
                                        </li>
                                        <li><a href="contact_us_02.html">Contact Us 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Deals Pages</a>
                                    <ul>
                                        <li><a href="deals_grid.html">Grid View</a>
                                        </li>
                                        <li><a href="deals_list.html">List View</a>
                                        </li>
                                        <li><a href="deal_single.html">Deal Single</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Coupons Pages</a>
                                    <ul>
                                        <li><a href="coupons_grid.html">Grid View</a>
                                        </li>
                                        <li><a href="coupons_grid_sidebar.html">Grid With Sidebar</a>
                                        </li>
                                        <li><a href="coupons_list.html">List View</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="terms_conditions.html">Terms &amp; conditions</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="nav-menu nav-menu-fixed">
                    <a href="#">获取报价</a>
                </div>
            </nav>
        </div>
    </div>
    <!-- End Header Menu -->

</header>