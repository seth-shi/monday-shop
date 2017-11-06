<?php

namespace App\Presenters;


class CategoryPresenter
{


    public function getThumbLink($link)
    {
        return starts_with($link, 'http') ? $link : "/storage/{$link}";
    }


}