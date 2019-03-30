<?php


namespace App\Admin\Extensions;


use Encore\Admin\Facades\Admin;

class ReceivedButton
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
let confirmForm = $('#ship_form');
let confirmFormBaseUrl = confirmForm.attr('action');

$('.received_btn').on('click', function () {

    let id = $(this).data('id');
    let _url = confirmFormBaseUrl + '/orders/'+ id +'/shipped';
    let inputs = '<input name="_method" value="PATCH"/>';
    
    // Your code.
    confirmForm.attr('action', _url).append(inputs).submit();
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a href='javascript:;' class='received_btn' data-id='{$this->id}' title='确认收货'><i class='fa fa-check'></i></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
