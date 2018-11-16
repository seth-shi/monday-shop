<?php $__env->startSection('main'); ?>
    <main id="mainContent" class="main-content">
    <div class="page-container ptb-10">
        <div class="container">
            <div class="section deals-header-area ptb-30">
                <div class="row row-tb-20">
                    <div class="col-xs-12 col-md-4 col-lg-3">
                        <aside>
                            <ul class="nav-coupon-category panel">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href='/categories/<?php echo e($category->id); ?>'>
                                            <i class="fa <?php echo e($category->icon); ?>"></i><?php echo e($category->title); ?>

                                            <span><?php echo e($category->products_count); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <li class="all-cat">
                                    <a class="font-14" href="/categories">查看所有分类</a>
                                </li>
                            </ul>
                        </aside>
                    </div>


                    <div class="col-xs-12 col-md-8 col-lg-9">
                        <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                            <?php $__currentLoopData = $hotProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="deal-single panel item">
                                    <a href="/products/<?php echo e($hotProduct->uuid); ?>">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="<?php echo e($hotProduct->thumb); ?>">
                                            <div class="label-discount top-10 right-10" style="width: auto;">
                                                <?php echo e($hotProduct->price); ?> ￥
                                            </div>
                                        </figure>
                                    </a>
                                    <div class="deal-about p-20 pos-a bottom-0 left-0">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating"><?php echo e($hotProduct->users_count); ?></span>
                                        </div>
                                        <h3 class="deal-title mb-10 ">
                                                <?php echo e($hotProduct->name); ?>

                                        </h3>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">最新的 商品</h3>
                    <a href="/products" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">查看所有</a>
                </header>

                <div class="row row-masnory row-tb-20">
                    <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latestProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-6 col-lg-4">
                            <div class="deal-single panel">
                                <a href="/products/<?php echo e($latestProduct->uuid); ?>">
                                    <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="<?php echo e($latestProduct->thumb); ?>">

                                    </figure>
                                </a>
                                <div class="bg-white pt-20 pl-20 pr-15">
                                    <div class="pr-md-10">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating"><?php echo e($latestProduct->users_count); ?></span>
                                        </div>
                                        <h3 class="deal-title mb-10">
                                            <a href="/products/<?php echo e($latestProduct->uuid); ?>">
                                                <?php echo e($latestProduct->name); ?>

                                            </a>
                                        </h3>
                                        <p class="text-muted mb-20">
                                            <?php echo $latestProduct->title; ?>

                                        </p>
                                    </div>
                                    <div class="deal-price pos-r mb-15">
                                        <h3 class="price ptb-5 text-right">
                                            <span class="price-sale">
                                                <?php echo e($latestProduct->price_original); ?>

                                            </span>
                                            ￥ <?php echo e($latestProduct->price); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="section stores-area stores-area-v1 ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">活跃的用户</h3>
                    <a href="#" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">-</a>
                </header>
                <div class="popular-stores-slider owl-slider" data-loop="true" data-autoplay="true" data-smart-speed="1000" data-autoplay-timeout="10000" data-margin="20" data-items="2" data-xxs-items="2" data-xs-items="2" data-sm-items="3" data-md-items="5" data-lg-items="6">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="store-item t-center">
                            <a href="#" class="panel is-block">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <div class="store-logo">
                                        <img class="user-avatar" src="<?php echo e($user->avatar); ?>" alt="<?php echo e($user->HiddenName); ?>">
                                    </div>
                                </div>
                                <h6 class="store-name ptb-10"><?php echo e($user->HiddenName); ?></h6>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="section subscribe-area ptb-40 t-center">
                <div class="newsletter-form">
                    <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>订阅我们</h4>
                    <p class="mb-20 color-mid">每周六上午八点将发送一封商品推荐信息给你 <br />(测试阶段将为每天发送一封订阅邮件)</p>

                        <div class="input-group mb-10">
                            <input  type="email" id="subscribe_email" class="form-control bg-white" value="<?php echo e(auth()->user()->subscribe->email ?? auth()->user()->email ?? ''); ?>" placeholder="Email Address" <?php echo e(isset(auth()->user()->subscribe) ? 'disabled' : ''); ?>  required="required">
                            <span class="input-group-btn">
                                <?php if(auth()->guard()->check()): ?>
                                    <button class="btn" id="subscribe_btn" type="button" style="<?php echo e(auth()->user()->subscribe()->exists() ? 'display: none;' : ''); ?>">订阅</button>
                                    <button  type="button"  id="desubscribe_btn"  class="btn btn-warning"style="<?php echo e(auth()->user()->subscribe()->exists() ? '' : 'display: none;'); ?>">取消订阅</button>
                                <?php endif; ?>
                                <?php if(auth()->guard()->guest()): ?>
                                    <button class="btn" id="login_subscribe_btn" type="button">订阅</button>
                                <?php endif; ?>
                            </span>
                        </div>

                    <p class="color-muted"><small>我们永远不会与第三方分享您的电子邮件地址.</small> </p>
                </div>
            </section>
        </div>
    </div>


    </main>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script src="/assets/admin/lib/lazyload/lazyload.js"></script>
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>

        var csrf_token = "<?php echo e(csrf_token()); ?>";
        // 订阅邮件
        $('#subscribe_btn').click(function(){
            var _url = "user/subscribe";
            var _email = $('#subscribe_email').val();
            var that = $(this);
            that.attr('disabled', true);

            $.post(_url, {email:_email, _token:csrf_token}, function(res){

                that.attr('disabled', false);

                if (res.code == 200) {
                    that.hide().next().show();
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }

            });
        });

        $('#desubscribe_btn').click(function(){
            var _url = "user/desubscribe";
            var that = $(this);
            that.attr('disabled', true);

            $.post(_url, {_token:csrf_token}, function(res){
                that.attr('disabled', false);

                if (res.code == 200) {
                    that.hide().prev().show();
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }

            });
        });


        $('#login_subscribe_btn').click(function() {
            layer.confirm('请登录后再订阅', {
                btn: ['去登录','再看看']
            }, function(){
                window.location.href = "login?redirect_dir=<?php echo e(url()->current()); ?>";
            }, function(){
                layer.close();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>