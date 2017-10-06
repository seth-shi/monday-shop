<?php


namespace App\Transformers;

abstract class Transformer
{

    public function transformCollection($items)
    {
        return array_map([$this, 'tansform'], $items);
    }

    public abstract function transform($item);

}