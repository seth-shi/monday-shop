@extends('layouts.admin')

@section('main')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 管理员管理
        <span class="c-gray en">&gt;</span> 权限管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>

    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
                <a href="javascript:;" onclick="admin_permission_add('添加权限','{{ url('/admin/permissions/create') }}','','310')" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加权限</a></span> <span class="r">共有数据：<strong>{{ $permissions->count() }}</strong> 条</span> </div>
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr class="text-c">
                <th width="200">权限名称</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr class="text-c">
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a title="编辑" href="javascript:;" onclick="admin_permission_edit('角色编辑','{{ url("/admin/permissions/{$permission->id}/edit") }}','1','','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a title="删除" href="javascript:;" onclick="admin_permission_del(this, '{{ $permission->id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>



@endsection

@section('script')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript">
        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*管理员-权限-添加*/
        function admin_permission_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-权限-编辑*/
        function admin_permission_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }

        /*管理员-权限-删除*/
        function admin_permission_del(obj,id){

            layer.confirm('确认要删除吗？',function(index){
                layer.close(index);
                var _url = '{{ url('/admin/permissions') }}/' + id;
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