@extends('layouts.user')

@section('style')
	<link href="/assets/user/css/stepstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('main')
	<div class="main-wrap">

		<div class="am-cf am-padding">
			<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">修改密码</strong> / <small>Password</small></div>
		</div>
		<hr/>
		<!--进度条-->
		<div class="m-progress">
			<div class="m-progress-list">
                <span class="{{ session()->has('status') ? 'step-2' : 'step-1' }} step">
                    <em class="u-progress-stage-bg"></em>
                    <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                    <p class="stage-name">重置密码</p>
                </span>
				<span class="{{ session()->has('status') ? 'step-1' : 'step-2' }} step">
                    <em class="u-progress-stage-bg"></em>
                    <i class="u-stage-icon-inner">2<em class="bg"></em></i>
                    <p class="stage-name">完成</p>
                </span>
				<span class="u-progress-placeholder"></span>
			</div>
			<div class="u-progress-bar total-steps-2">
				<div class="u-progress-bar-inner"></div>
			</div>
		</div>

		@include('hint.status')
		@include('hint.validate_errors')

		<form class="am-form am-form-horizontal" action="/user/password" method="post">

            {{ csrf_field() }}

			{{-- 如果是初始密码就不用再社会 --}}
			@if (! $user->is_init_password)
				<div class="am-form-group">
					<label for="user-old-password" class="am-form-label">原密码</label>
					<div class="am-form-content">
						<input type="password" id="user-old-password" name="old_password" value="{{ old('old_password') }}" placeholder="请输入原登录密码">
					</div>
				</div>
			@endif
			<div class="am-form-group">
				<label for="user-new-password" class="am-form-label">新密码</label>
				<div class="am-form-content">
					<input type="password" id="user-new-password" name="password" placeholder="由数字、字母组合">
				</div>
			</div>
			<div class="am-form-group">
				<label for="user-confirm-password" class="am-form-label">确认密码</label>
				<div class="am-form-content">
					<input type="password" id="user-confirm-password" name="password_confirmation" placeholder="请再次输入上面的密码">
				</div>
			</div>
			<div class="info-btn">
				<button class="am-btn am-btn-danger">保存修改</button>
			</div>

		</form>

	</div>
@endsection
