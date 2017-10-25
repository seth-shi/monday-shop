@extends('layouts.admin')

@section('main')
    <div class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action="{{ url('admin/categories/' . $category->id) }}" method="post" class="form form-horizontal" id="form-user-add">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="row cl  {{ $errors->has('parent_id') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    父级分类：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <select name="parent_id" class="select" style="padding-bottom: 5px">
                        <option value="-1">请选择父级分类</option>
                        <option {{ $category->parent_id == 0 ? 'selected=\"selected\"' : ''}} value="0">添加一级分类</option>
                        @foreach ($categories as $cate)
                            <option {{ $category->parent_id == $cate->id ? 'selected=\"selected\"' : ''}} value="{{ $cate->id }}">
                               {!! $cate->className !!}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent_id'))
                        <span class="help-block">
                            <strong>{!! $errors->first('parent_id') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ $category->name }}" placeholder="分类名称" name="name">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">备注：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="description" cols="" rows="" class="textarea"  placeholder="描述">{{ $category->description }}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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