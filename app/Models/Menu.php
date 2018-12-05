<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Menu as AdminMenu;

class Menu extends AdminMenu
{
    public function allNodes() : array
    {
        $nodes = parent::allNodes();

        // 如果没开启秒杀功能，把这个模块菜单隐藏掉
        $seckillUri = 'seckills';


        if (setting('is_open_seckill') == 0) {

            $nodes = array_filter($nodes, function ($node) use ($seckillUri) {

                return $node['uri'] != $seckillUri;
            });
        }

        return $nodes;
    }
}
