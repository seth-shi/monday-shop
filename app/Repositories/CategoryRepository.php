<?php

namespace App\Repositories;


use App\Models\Category;

class CategoryRepository
{

    public function getTree()
    {
        return Category::get()->toTree();
    }

    public function getAllWithDepath()
    {
        return Category::defaultOrder()->withDepth()->get();
    }

    public function traverseTreeToArr($prefix = '-')
    {
        $nodes = $this->getTree();

        return $this->traverseTree($nodes, $prefix);
    }

    protected function traverseTree($nodes, $prefix = '-')
    {
        $fix_prefix = $prefix;
        $data = [];

        $traverse = function ($nodes, $prefix = '-') use (&$traverse, $fix_prefix, &$data) {

            foreach ($nodes as $node) {

                $data[$node->id] = $prefix.' '.$node->name;

                $traverse($node->children, $fix_prefix.$prefix);
            }
        };

        $traverse($nodes, $prefix);

        return $data;
    }

}