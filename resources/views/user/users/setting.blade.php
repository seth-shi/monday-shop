@extends('layouts.user')


@section('style')
    <link href="{{ asset('assets/user/css/infstyle.css') }}" rel="stylesheet" type="text/css">
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
                @inject('userPresenter', 'App\Presenters\UserPresenter')
                <div class="filePic">
                    <input type="file" class="inputPic" allowexts="gif,jpeg,jpg,png,bmp" accept="image/*">
                    <img class="am-circle am-img-thumbnail" src="{{ $userPresenter->getAvatarLink($user->avatar) }}" alt="{{ $user->name }}" />
                </div>

                <p class="am-form-help">头像</p>

                <div class="info-m">
                    <div><b>用户名：<i>{{ $user->name }}</i></b></div>
                </div>
            </div>

            <!--个人信息 -->
            <div class="info-main">
                <form class="am-form am-form-horizontal">

                    <div class="am-form-group">
                        <label for="user-name2" class="am-form-label">昵称</label>
                        <div class="am-form-content">
                            <input type="text" id="user-name2" placeholder="nickname" value="{{ $user->name }}">

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
                        <label for="user-email" class="am-form-label">电子邮件</label>
                        <div class="am-form-content">
                            <input id="user-email" placeholder="Email" type="email" value="{{ $user->email }}">

                        </div>
                    </div>

                    <div class="info-btn">
                        <div class="am-btn am-btn-danger">保存修改</div>
                    </div>

                </form>
            </div>

        </div>

    </div>
@endsection