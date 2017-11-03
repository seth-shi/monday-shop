@extends('layouts.admin')

@section('main')
	<article class="page-container">
		<form class="form form-horizontal" id="form-admin-add">
			<div class="row cl {{ $errors->has('name') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="adminName" name="name">
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
			<div class="row cl {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password2" name="confirm_password">
					@if ($errors->has('confirm_password'))
						<span class="help-block">
                            <strong>{!! $errors->first('confirm_password') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('role') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3">角色：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:150px;">
						<select class="select" name="role" size="1">
							@foreach ($roles as $role)
								<option value="{{ $role->name }}">{{ $role->name }}</option>
							@endforeach
						</select>
						@if ($errors->has('role'))
							<span class="help-block">
                            <strong>{!! $errors->first('role') !!}</strong>
                        </span>
						@endif
					</span>
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

@endsection