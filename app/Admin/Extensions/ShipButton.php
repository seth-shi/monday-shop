<?php


namespace App\Admin\Extensions;


use Encore\Admin\Facades\Admin;

class ShipButton
{

    protected $id;

    /**
     * Div constructor.
     *
     * @param        $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT
// 发货的动态表单
let shipForm = $('#ship_form');
let shipFormBaseUrl = shipForm.attr('action');

$('.ship_btn').on('click', function () {

    // 发货的 url
    let id = $(this).data('id');
    let _url = shipFormBaseUrl + '/orders/'+ id +'/ship';
    
    layer.prompt({title: '请填写物流公司名称', formType: 3, btn: ['下一步', '取消']}, function(_name, index){
        
        layer.close(index);
        layer.prompt({title: '请填写物流号', formType: 3}, function(_no, index){
            layer.close(index);
            
            let inputs = '<input name="name" value="'+ _name +'" /><input name="no" value="'+ _no +'" />';
            // 拼接当前 url
            shipForm.append(inputs).attr('action', _url).submit();
      });
});
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
        return "<a href='javascript:;' class='ship_btn' data-id='{$this->id}' title='发货'><i class='fa fa-paper-plane-o'></i></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
