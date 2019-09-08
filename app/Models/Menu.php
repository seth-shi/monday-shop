<?php

namespace App\Models;

use App\Enums\SettingKeyEnum;
use Encore\Admin\Auth\Database\Menu as AdminMenu;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string|null $uri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $children
 * @property-read \App\Models\Menu $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUri($value)
 * @mixin \Eloquent
 */
class Menu extends AdminMenu
{
    public function allNodes() : array
    {
        $nodes = parent::allNodes();

        // 如果没开启秒杀功能，把这个模块菜单隐藏掉
        $seckillUri = 'seckills';

        $setting = new SettingKeyEnum(SettingKeyEnum::IS_OPEN_SECKILL);
        if (setting($setting) == 0) {

            $nodes = array_filter($nodes, function ($node) use ($seckillUri) {

                return $node['uri'] != $seckillUri;
            });
        }

        return $nodes;
    }
}
