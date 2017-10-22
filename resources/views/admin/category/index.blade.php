@extends('layouts.admin')


@section('main')
	<div class="page-container">
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;">
			<input type="text" name="" id="" placeholder=" 图片名称" style="width:250px" class="input-text">
			<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜图片</button>
		</div>
		<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" onclick="picture_add('添加图片','picture-add.html')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加图片</a></span> <span class="r">共有数据：<strong>{{ $categorys->count() }}</strong> 条</span> </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
					<th width="40"><input name="" type="checkbox" value=""></th>
					<th width="50">ID</th>
					<th width="100">分类名称</th>
					<th width="200">父级分类</th>
					<th width="150">创建时间</th>
					<th width="150">更新时间</th>
					<th width="100">操作</th>
				</tr>
				</thead>
				<tbody>
				    @foreach ($categorys as $category)
						<tr class="text-c">
							<td><input name="" type="checkbox" value="{{ $category->id }}"></td>
							<td>{{ $category->id }}</td>
							<td class="text-l">
                                {!!  str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth)  !!}{{ $category->ancestors->count() ? '┣━━' : '' }} {{ $category->name }}
                            </td>
							<td class="text-l">{{ $category->isRoot() ? '一级分类' : implode(' ➤ ', $category->ancestors->pluck('name')->toArray()) }}</td>
							<td>{{ $category->created_at }}</td>
							<td>{{ $category->updated_at }}</td>
							<td class="td-manage"><a style="text-decoration:none" onClick="picture_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_edit('图库编辑','picture-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
						</tr>
                    @endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
