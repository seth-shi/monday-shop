<?php


namespace App\Admin\Extensions;

use Illuminate\Support\Collection;

class ProductAttribute
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function render() : string
    {
        return $this->collection
                    ->groupBy('attribute')
                    ->reduce(function ($last, $curr) {

                        // 取出 key
                        $attribute = $curr->first()['attribute'];

                        return $last . $attribute . ':' . $this->span($curr);
                    });
    }

    protected function span(Collection $collection)
    {
        $span = '<span style="border: 1px solid #ddd; padding: 1px; margin-left: 5px;">';

        return $span . $collection->implode('value', '</span>' . $span) . '</span><br>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
