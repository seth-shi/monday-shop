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

$('.received_btn').on('click', function () {

    // Your code.
    console.log($(this).data('id'));

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
