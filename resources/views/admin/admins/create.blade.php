@extends('layouts.admin')


@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/layui/css/layui.css') }}">
@endsection

@section('main')
	<article class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<form class="form form-horizontal layui-form" id="form-admin-add" method="post" action='{{ url("/admin/admins") }}'>

			{{ csrf_field() }}

			<div class="row cl {{ $errors->has('name') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="adminName" name="name">
					@if ($errors->has('name'))
						<span class="help-block">
                            <strong>{!! $errors->first('name') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('password') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" autocomplete="off" value="" placeholder="密码" id="password" name="password">
					@if ($errors->has('password'))
						<span class="help-block">
                            <strong>{!! $errors->first('password') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password2" name="password_confirmation">
					@if ($errors->has('password_confirmation'))
						<span class="help-block">
                            <strong>{!! $errors->first('password_confirmation') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('roles') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3">角色：</label>
				<div class="formControls col-xs-8 col-sm-9">
                    <!-- multiple="multiple" -->
                    <div class="layui-form-item">
                            @foreach ($roles as $role)
                                <input type="radio" name="roles[][role]" value="{{ $role->name }}" title="{{ $role->name }}" {{ (old('roles') && in_array($role->name, array_column(old('roles'), 'role'))) ? 'checked' : ''}}>
                            @endforeach
                    </div>
                    @if ($errors->has('roles'))
                        <span class="help-block">
                            <strong>{!! $errors->first('roles') !!}</strong>
                        </span>
                    @endif
                </div>
			</div>
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
					<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
				</div>
			</div>
		</form>
	</article>
@endsection

@section('script')
	<script src="{{ asset('assets/admin/lib/layui/layui.js') }}"></script>
	<script>
        layui.use(['form'], function() {
            var form = layui.form;
        });
	</script>
@endsection