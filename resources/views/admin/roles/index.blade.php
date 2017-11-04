@extends('layouts.admin')


@section('main')
	<div class="page-container">
		<div class="cl pd-5 bg-1 bk-gray"> <span class="l">
                <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','admin-role-add.html','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
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
							<a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
            layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    success: function(data){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
	</script>
@endsection