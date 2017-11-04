﻿@extends('layouts.admin')

@section('main')
	<article class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<form action="{{ url("/admin/roles/{$role->id}") }}" method="post" class="form form-horizontal" id="form-admin-role-add">

            {{ csrf_field() }}
            {{ method_field('PUT') }}

			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{ $role->name }}" placeholder="" id="roleName" name="name">
				</div>
			</div>
			<div class="row cl">
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
                                        <label class="">
                                            <input type="checkbox" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : ''}} name="permission[][name]">{{ $permission->name }}</label>
                                    @endforeach
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
