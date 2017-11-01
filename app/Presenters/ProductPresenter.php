<?php

namespace App\Presenters;


class ProductPresenter
{
    public function getAliveSpan($status)
    {
        $status_span = $this->isAlive($status) ? '上架' : '下架';
        $status_class = $this->isAlive($status) ? 'label-success' : 'label-info';

        $span = <<<span
<span class="label {$status_class}  radius">
{$status_span}
</span>
span;

        return $span;
    }

    private function isAlive($status)
    {
        return $status == 1;
    }

    public function getHotSpan($status)
    {
        $status_span = $this->isHot($status) ? '火卖' : '正常';
        $status_class = $this->isHot($status) ? 'label-danger' : 'label-info';

        $span = <<<span
<span class="label {$status_class}  radius">
{$status_span}
 </span>
span;


        return $span;
    }


    private function isHot($status)
    {
        return $status == 1;
    }
}