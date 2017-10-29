@extends('layouts.admin')

@section('main')
	<div class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" id="batch_delete_btn" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
            </span>
            <span class="l" style="margin-left: 10px;">
                <a class="btn btn-success radius r"  href="javascript:location.reload();" title="刷新" >
                    <i class="Hui-iconfont">&#xe68f;</i>
                </a>
            </span>

            <span class="r">共有数据：<strong>{{ $categories->count() }}</strong> 条</span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
					<th width="40"><input name="" type="checkbox" value=""></th>
					<!-- <th width="50">ID</th> -->
					<th width="100">分类名称</th>
					<th width="200">父级分类</th>
					<th width="100">创建时间</th>
					<th width="100">更新时间</th>
					<th width="100">操作</th>
				</tr>
				</thead>
				<tbody>
				    @foreach ($categories as $category)
						<tr class="text-c">
							<td><input name="catetory_id" type="checkbox" value="{{ $category->id }}"></td>
							<!-- <td>{{ $category->id }}</td> -->
							<td class="text-l">
                                {!! $category->className !!}
                            </td>
							<td class="text-l">{{ $category->parentClass }}</td>
							<td>{{ $category->created_at }}</td>
							<td>{{ $category->updated_at }}</td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href="{{ url('admin/categories/'.  $category->id .'/edit')}}" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>

                                <a href="javascript:;" class="ml-5 delete_category" data-id="{{ $category->id }}" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
						</tr>
                    @endforeach

                    <form id="delete_form" action="{{ url('admin/categories') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                    </form>
				</tbody>
			</table>
		</div>
	</div>
@endsection


@section('script')
    <script>
        $('.delete_category').click(function(){
            var id = $(this).data('id');

            var url = $('#delete_form').attr('action') + '/' + id;

            $('#delete_form').attr('action', url);

            $('#delete_form').submit();
        });

        $('#batch_delete_btn').click(function(){
            $('input[name=catetory_id]:checked').each(function (index,element) {

                var url = $('#delete_form').attr('action') + '/' + $(this).val();

                $.post(url, {_token:'{{ csrf_token() }}', _method:'DELETE'}, function(res){
                    if (res.code == 0) {
                        layer.msg(res.msg + '  请刷新数据');
                    }
                });
            });
        });
    </script>
@endsection