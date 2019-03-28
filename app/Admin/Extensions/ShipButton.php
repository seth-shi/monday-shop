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

$('.ship_btn').on('click', function () {

    // Your code.
    console.log($(this).data('id'));

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
