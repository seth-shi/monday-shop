<?php

namespace App\Admin\Actions\Post;

use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ActiveUserAction extends RowAction
{
    public $name = '激活';

    public function handle(User $model)
    {
        // $model ...
        $model->is_active = 1;
        $model->save();

        return $this->response()->success('操作成功.')->refresh();
    }

}
