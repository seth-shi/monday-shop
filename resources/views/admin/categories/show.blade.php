@extends('layouts.admin')

@section('main')
    <div class="page-container">

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    父级分类：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    {{ $category->isRoot() ? '一级分类' : implode(' ➤ ', $category->ancestors->pluck('name')->toArray()) }}
                </div>
            </div>
            <div class="row cl ">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                    <div class="formControls col-xs-6 col-sm-6">
                        {{ $category->name }}
                    </div>
                </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">描述：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    {{ $category->description }}
                </div>
            </div>
    </div>
@endsection