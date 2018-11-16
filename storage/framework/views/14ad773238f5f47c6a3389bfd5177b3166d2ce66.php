<header id="mainHeader" class="main-header">

    <!-- Top Bar -->
    <div class="top-bar bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 is-hidden-sm-down">
                    <ul class="nav-top nav-top-left list-inline t-left">
                        <li><a href="https://baidu.com"><i class="fa fa-question-circle"></i>指南</a>
                        </li>
                        <li><a href="https://baidu.com"><i class="fa fa-support"></i>帮助</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-8">
                    <ul class="nav-top nav-top-right list-inline t-xs-center t-md-right">
                        <?php if(auth()->guard()->check()): ?>
                            <li>
                                <a href="/user"><i class="fa fa-user"></i><?php echo e(Auth::user()->name); ?></a>
                            </li>
                            <li>
                                <a href="javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i>注销</a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>
                            <li><a href="#"><i class="fa fa-user"></i>游客</a></li>
                            <li><a href="/login?redirect_url=<?php echo e(url()->current()); ?>"><i class="fa fa-lock"></i>登录</a>
                            </li>
                            <li><a href="/register"><i class="fa fa-user"></i>注册</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->



</header>
