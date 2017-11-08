@extends('layouts.admin')

@section('main')
    <div class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action="{{ url('admin/categories') }}" method="post" class="form form-horizontal" id="form-user-add" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row cl  {{ $errors->has('parent_id') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    父级分类：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <select name="parent_id" class="select" style="padding-bottom: 5px">
                        <option value="-1">请选择父级分类</option>
                        <option value="0">添加一级分类</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : ''}}>{!! $category->className !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent_id'))
                        <span class="help-block">
                            <strong>{!! $errors->first('parent_id') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ old('name') }}" placeholder="分类名称" name="name">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row cl {{ $errors->has('thumb') ? 'has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">分类缩略图：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <span class="btn-upload form-group">
                        <input class="input-text upload-url" type="text" id="uploadfile" readonly placeholder="选择分类缩略图！" style="width:200px">
                        <a href="javascript:;" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>
                        <input type="file" name="thumb" class="input-file">
                    </span>
                    @if ($errors->has('thumb'))
                        <span class="help-block">
                            <strong>{!! $errors->first('thumb') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row cl {{ $errors->has('description') ? 'has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">备注：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="description" cols="" rows="" class="textarea"  placeholder="描述">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{!! $errors->first('description') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>
@endsection