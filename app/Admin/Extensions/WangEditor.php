<?php


namespace App\Admin\Extensions;

use Illuminate\Support\Collection;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.css',
    ];

    protected static $js = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);
        $token = csrf_token();
        $url = admin_base_path('upload/editor');

        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0
editor.customConfig.uploadFileName = 'pictures[]'
// 配置服务器端地址
editor.customConfig.uploadImgServer = '{$url}'
editor.customConfig.uploadImgParams = {
    _token: '{$token}'
}
// 文件改变添加内容到隐藏域
editor.customConfig.onchange = function (html) {
    $('input[name=\'$name\']').val(html);
}
// 监听上传错误
editor.customConfig.uploadImgHooks = {
    fail: function (xhr, editor) {
        var response = $.parseJSON(xhr.response);
        
        alert(response.msg);
    }
}
editor.create()

EOT;
        return parent::render();
    }
}
