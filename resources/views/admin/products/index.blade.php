@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
@endsection

@section('main')
    <div>
        <div class="page-container">
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="40"><input name="" type="checkbox" value=""></th>
                        <th width="40">产品名称</th>
                        <th width="60">缩略图</th>
                        <th width="100">售价/原价</th>
                        <th width="60">收藏数</th>
                        <th width="100">状态</th>
                        <th width="100">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @inject('productPresenter', 'App\Presenters\ProductPresenter')
                    @foreach ($products as $product)
                        <tr class="text-c va-m">
                            <td><input name="" type="checkbox" value="{{ $product->id }}"></td>
                            <td>
                                <a onClick="product_show('哥本哈根橡木地板','product-show.html','10001')" href="javascript:;">{{ $product->name }}</a>
                            </td>
                            <td class="text-l">
                                <img style="height: 90px;width:auto;" title="{{ $product->name }}" src="/storage/{{ $product->thumb }}">
                            </td>
                            <td>
                                {{ $product->price }} / {{ $product->price_original }}
                            </td>
                            <td><span class="price">{{ $product->likes }}</span></td>
                            <td class="td-status">
                                {!! $productPresenter->getAliveSpan($product->is_alive) !!}
                                {!! $productPresenter->getHotSpan($product->is_hot) !!}
                            </td>
                            <td class="td-manage">
                                @if ($productPresenter->isAlive($product->is_alive))
                                <a style="text-decoration:none" onClick="product_stop(this, '{{ $product->id }}', 0)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>
                                @else
                                    <a style="text-decoration:none" onClick="product_stop(this, '{{ $product->id }}', 1)" href="javascript:;" title="上架"><i class="Hui-iconfont">&#xe6dc;</i></a>
                                @endif
                                <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','product-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="{{ asset('assets/admin/lib/datatables/1.10.0/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/lib/laypage/1.2/laypage.js') }}"></script>
    <script type="text/javascript">
        // 数据表格排序
        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,2,6]}// 制定列不参与排序
            ]
        });

        /*产品-查看*/
        function product_show(title,url,id){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*产品-下架*/
        function product_stop(obj,id, status){

            layer.confirm('确认要下架吗？',function(index){
                var url = "{{ url('/admin/products/change/alive') }}/"+id;

                $.post(url, {is_alive:status,_token:'{{ csrf_token() }}'}, function(res){
                    console.log(res);
                });

                layer.msg('已下架!',{icon: 5,time:1000});
            });
        }

        /*产品-编辑*/
        function product_edit(title,url,id){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*产品-删除*/
        function product_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
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