<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class DividerAction extends RowAction
{
    public $name = '分隔线';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    /**
     * Render row action.
     *
     * @return string
     */
    public function render()
    {
        return '<li class="divider"></li>';
    }
}
