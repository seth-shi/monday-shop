@extends('layouts.admin')

@section('main')
	<article class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<form action="{{ url("/admin/roles") }}" method="post" class="form form-horizontal" id="form-admin-role-add">

            {{ csrf_field() }}

			<div class="row cl {{ $errors->has('name') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="roleName" name="name">
					@if ($errors->has('name'))
						<span class="help-block">
											<strong>{!! $errors->first('name') !!}</strong>
										</span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('permission') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3">网站角色权限：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<dl class="permission-list">
						<dd>
							<dl class="cl permission-list2">
                                <dt>
                                    <label class="">
                                        分配权限
                                    </label>
                                </dt>
								<dd>
									@foreach ($permissions as $permission)
                                        <label class="" style="display: inline-block">
                                            <input type="checkbox" value="{{ $permission->name }}" name="permission[][name]">{{ $permission->name }}</label>
                                    @endforeach
									@if ($errors->has('permission'))
										<span class="help-block">
											<strong>{!! $errors->first('permission') !!}</strong>
										</span>
									@endif
								</dd>
							</dl>
						</dd>
					</dl>
				</div>
			</div>
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
					<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
				</div>
			</div>
		</form>
	</article>
@endsection
