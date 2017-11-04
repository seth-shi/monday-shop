@extends('layouts.admin')


@section('main')
	<div class="page-container">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span> 管理员管理
            <span class="c-gray en">&gt;</span> 角色管理
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>

		<div class="cl pd-5 bg-1 bk-gray"> <span class="l">
                <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','{{ url("/admin/roles/create") }}','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>{{ $roles->count() }}</strong> 条</span> </div>
		<table class="table table-border table-bordered table-hover table-bg">
			<thead>
			<tr>
				<th scope="col" colspan="6">角色管理</th>
			</tr>
			<tr class="text-c">
				<th width="200">角色名</th>
				<th width="70">操作</th>
			</tr>
			</thead>
			<tbody>
				@foreach ($roles as $role)
					<tr class="text-c">
						<td>{{ $role->name }}</td>
						<td class="f-14">
							<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','{{ url("/admin/roles/{$role->id}/edit") }}','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							<a title="删除" href="javascript:;" onclick="admin_role_del(this, '{{ $role->id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection


@section('script')
	<script type="text/javascript">
		/*管理员-角色-添加*/
        function admin_role_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
		/*管理员-角色-编辑*/
        function admin_role_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
		/*管理员-角色-删除*/
        function admin_role_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                layer.close(index);
                var _url = '{{ url('/admin/roles') }}/' + id;
                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: {_token: '{{ csrf_token() }}', _method:'DELETE'},
                    dataType: 'json',
                    success: function(res){

                        if (res.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg(res.msg,{icon:1,time:1000});
                        } else {
                            layer.msg(res.msg,{icon:2,time:1000});
                        }
                    },
                    error:function(res) {
                        layer.msg(res.msg);
                    },
                });
            });
        }
	</script>
@endsection