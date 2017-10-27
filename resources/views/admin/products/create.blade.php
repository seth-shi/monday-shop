@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/layui/css/layui.css') }}">
@endsection

@section('main')
<div class="page-container">
    <form action="{{ url('admin/products') }}" method="post" class="form form-horizontal" id="form-article-add">
        {{ csrf_field() }}

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="商品名称" id="" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                    <select name="category_id" class="select" style="padding-bottom: 5px">
                                <option value="-1">请选择分类</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{!!  str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth)  !!}{{ $category->ancestors->count() ? '┣━━' : '' }} {{ $category->name }}</option>
                        @endforeach
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl" id="attrContainer">
            <label class="form-label col-xs-4 col-sm-2">添加产品属性：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <button type="button" class="layui-btn" id="addAttrBtn">添加产品属性</button>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">价格计算单位：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" name="unit" id="" placeholder="如 件 / 个 / 台" value="" class="input-text" style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">销售价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="price" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品展示价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="price_original" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">商品描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="description" id="description" style="display: none;"></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片上传：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-list-container">
                    <div class="layui-upload">
                        <button title="第一张默认为商品缩略图" type="button" class="layui-btn" id="testList">选择商品图片</button>
                        <button type="button" class="layui-btn" id="testListAction">开始上传</button>
                        <div class="layui-upload-list">
                            <table class="layui-table">
                                <thead>
                                <tr><th>文件名</th>
                                    <th>大小</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr></thead>
                                <tbody id="demoList"></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="hidden_images_container">

        </div>

        <hr>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="submit" class="layui-btn layui-btn-normal" value="添加商品">
            </div>
        </div>
    </form>
</div>

<!--请在下方写此页面业务相关的脚本-->
<script src="{{ asset('assets/admin/lib/layui/layui.js') }}"></script>
<script type="text/javascript">
    layui.use(['upload', 'layedit'], function() {
        var $ = layui.jquery
            , upload = layui.upload
            , layedit = layui.layedit;

        // 添加产品属性
        $("#addAttrBtn").click(function(){
            var inputText = '<label class="form-label col-xs-4 col-sm-2">产品属性：</label><div class="formControls col-xs-8 col-sm-9"> <input type="text" name="product_attribute[]" id="" placeholder="产品属性名：如颜色" value="" class="input-text" style=" width:25%">===><input type="text" name="product_items[]" id="" placeholder="产品属性值：对应颜色：红" value="" class="input-text" style=" width:25%">===><input type="text" name="product_markup[]" id="" placeholder="浮动价格，如白色的比较贵10￥" value="" class="input-text" style=" width:25%"></div>';
            $('#attrContainer').append(inputText);
        });

        // 富文本编辑器
        layedit.set({
            uploadImage: {
                url: "{{ url('api/product/upload/product') }}?fieldName=file" //接口url  _token={{ csrf_token() }}
            }
        });
        layedit.build('description');

        //多文件列表示例
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: "{{ url('api/product/upload/images') }}"
            ,data: '{"_token":"{{ csrf_token() }}"}'
            ,accept: 'images'
            ,field: 'product_image'
            ,size: 1024*2
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,choose: function(obj){

                var files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-mini layui-btn-danger demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                    //单个重传
                    tr.find('.demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                    });

                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){

                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html('<img src="/storage/'+ res.data.src +'" />'); //清空操作
                    // delete files[index]; //删除文件队列已经上传成功的文件

                    // 加入隐藏域
                    var text = "<input type='hidden' name='image[]' value='"+  res.data.src +"' />";
                    $('#hidden_images_container').append(text);

                    return;
                }

                layer.msg(res.msg);
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });

    });
</script>
@endsection