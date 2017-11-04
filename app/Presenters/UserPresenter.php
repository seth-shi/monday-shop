<?php

namespace App\Presenters;


class UserPresenter
{
    public function getAvatarLink($link)
    {
        return starts_with($link, 'http') ? $link : "/storage/{$link}";
    }

    public function getStatusSpan($status)
    {
        $class = $this->isActive($status) ? 'label-success' : 'label-info';
        $span = $this->isActive($status) ? '已激活' : '未激活';

        $html = <<<html
<span class="label {$class}">{$span}</span>
html;

        return $html;
    }

    public function getThumbLink($link)
    {
        return starts_with($link, 'http') ? $link : "/storage/{$link}";
    }

    public function getHiddenPartName($name)
    {
        $lastStr = mb_substr($name, 0, 1, 'utf-8');

        $hiddenStr = str_repeat('*', mb_strlen($name, 'utf-8') - 1);

        return $lastStr . $hiddenStr;
    }

    public function isActive($status)
    {
        return $status == 1;
    }
}