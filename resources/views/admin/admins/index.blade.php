@extends('layouts.admin')


@section('main')
    <div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif


        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">管理员列表</th>
            </tr>
            <tr class="text-c">
                <th width="150">登录名</th>
                <th>角色</th>
                <th width="130">加入时间</th>
                <th width="100">上一次登录ip</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($admins as $admin)
                <tr class="text-c">
                    <td>{{ $admin->name }}</td>
                    <td>{!! implode('&nbsp;&nbsp;', $admin->getRoleNames()->toArray()) !!}</td>
                    <td>{{ $admin->created_at }}</td>
                    <td>{{ dump($admin->last_ip) }}</td>
                    <td class="td-manage">
                        <a title="编辑" href="{{ url('admin/admins/'.  $admin->id .'/edit')}}"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" data-id="{{ $admin->id }}" class="ml-5 delete_admin" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form id="delete_form" action="" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('.delete_admin').click(function () {
            var id = $(this).data('id');
            var uri = "{{ url('/admin/admins') }}/" + id;

            $('#delete_form').attr('action', uri);
            $('#delete_form').submit();
        });
    </script>
@endsection