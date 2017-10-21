@extends('layouts.admin')


@section('main')
    <div class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-user-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="" placeholder="" id="user-name" name="product-category-name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">备注：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)"></textarea>
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