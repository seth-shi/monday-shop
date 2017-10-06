<?php

namespace App\Transformers;


class UserTransformer extends Transformer
{

    public function transformCollection($items)
    {

        return array_map([$this, 'transform'], $items);
    }

    public function transform($item)
    {
        return [
            'username' => $item['username'],
            'nickname' => $item['nickname'],
            'email'    => $item['email'],
            'avatar'   => $item['avatar']
        ];
    }

}