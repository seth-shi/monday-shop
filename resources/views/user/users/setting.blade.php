@extends('layouts.user')



@section('style')
    <link rel="stylesheet" href="/assets/admin/lib/layui/css/layui.css">
    <link href="/assets/user/css/infstyle.css" rel="stylesheet" type="text/css">
    <link href="/assets/shop/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>
        .oauth_button {
            padding: 5px 20px;
            min-width: 150px;
        }
    </style>
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-info">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">个人资料</strong> / <small>Personal&nbsp;information</small></div>
            </div>
            <hr/>

            <!--头像 -->
            <div class="user-infoPic">
                <div class="filePic">
                    <img style="cursor: pointer;width: 60px;height: 60px;" id="avatar_img" class="am-circle am-img-thumbnail" src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                </div>

                <p class="am-form-help">头像</p>

                <div class="info-m">
                    <div><b>用户名：<i>{{ $user->name }}</i></b></div>
                </div>
            </div>

            <!--个人信息 -->
            <div class="info-main">
                @include('hint.status')
                @include('hint.validate_errors')

                <form class="am-form am-form-horizontal" method="post" action="/user/update">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <input type="hidden" name="avatar" value="{{ $user->avatar }}">

                    <span style="color: #aaa">第三方账号注册的账户可以有一次机会更改用户名和邮箱</span>
                    <div class="am-form-group">
                        <label for="user-name2" class="am-form-label">用户名</label>
                        <div class="am-form-content">
                            <input type="text" id="user-name2" placeholder="用户名" name="name" value="{{ $user->name }}" {{ $user->is_init_name ? '' : 'disabled' }}>

                        </div>
                    </div>

                    <div class="am-form-group">
                        <label class="am-form-label">性别</label>
                        <div class="am-form-content sex">
                            <label class="am-radio-inline">
                                <input type="radio" name="sex" value="1" {{ $user->sex == 1 ? 'checked' : '' }} data-am-ucheck> 男
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="sex" value="0"  {{ $user->sex == 0 ? 'checked' : '' }} data-am-ucheck> 女
                            </label>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-form-label">账号绑定</label>
                        <div class="am-form-content">
                            @if (! is_null($user->github_id))
                                <button class="oauth_button" type="button" disabled>
                                    <i class="fa fa-github" style="color: #00aced;"></i>&nbsp;{{ $user->github_name }}
                                </button>
                                <a href="/auth/oauth/unbind/github" style="color: #009a61;text-decoration: underline;">
                                    解绑
                                </a>
                            @else
                                <a href="/auth/oauth?driver=github">
                                    <button class="oauth_button" type="button">
                                        <i class="fa fa-github" style="color: #3b5999;"></i>&nbsp;Github
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-email" class="am-form-label">账号绑定</label>
                        <div class="am-form-content">
                            @if (! is_null($user->qq_id))
                                <button class="oauth_button" type="button" disabled>
                                    <i class="fa fa-qq" style="color: #00aced;"></i>&nbsp;{{ $user->qq_name }}
                                </button>
                                <a href="/auth/oauth/unbind/qq" style="color: #009a61;text-decoration: underline;">
                                    解绑
                                </a>
                            @else
                                <a href="/auth/oauth?driver=qq">
                                    <button class="oauth_button" type="button">
                                        <i class="fa fa-qq" style="color: #00aced;"></i>&nbsp;QQ
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-email" class="am-form-label">账号绑定</label>
                        <div class="am-form-content">
                            @if (! is_null($user->weibo_id))
                                <button class="oauth_button" type="button" disabled>
                                    <i class="fa fa-weibo" style="color: #dd4b39;"></i>&nbsp;{{ $user->weibo_name }}
                                </button>
                                <a href="/auth/oauth/unbind/weibo" style="color: #009a61;text-decoration: underline;">
                                    解绑
                                </a>
                            @else
                                <a href="/auth/oauth?driver=weibo">
                                    <button class="oauth_button" type="button">
                                        <i class="fa fa-weibo" style="color: #dd4b39;"></i>&nbsp;微博
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-form-label">电子邮件</label>
                        <div class="am-form-content">
                            <input name="email" placeholder="Email" type="email" value="{{ $user->email }}" {{ $user->is_init_email ? '' : 'disabled' }}>

                        </div>
                    </div>

                    <div class="info-btn">
                        <button type="submit" class="am-btn am-btn-danger">保存修改</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
@endsection


@section('script')
    <script src="/assets/admin/lib/layui/layui.js"></script>
    <script>
        layui.use('upload', function() {
            let $ = layui.jquery
                ,upload = layui.upload;


            upload.render({
                elem: '#avatar_img'
                ,method: 'post'
                ,url: '/user/upload/avatar'
                ,done: function(res){

                    if (res.code == 0) {
                        console.log(res.data.src);
                        $('input[name=avatar]').val(res.data.src);
                        $('#avatar_img').attr('src', res.data.link);
                    }

                    layer.msg(res.msg);
                    console.log(res);
                }
            });
        });
    </script>
@endsection
