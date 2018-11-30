<?php


namespace App\Admin\Extensions;


use Illuminate\Contracts\Support\Renderable;

class Div implements Renderable
{

    protected $id;
    protected $width = '100%';
    protected $height = '300px';

    /**
     * Div constructor.
     *
     * @param        $id
     * @param string $width
     * @param string $height
     */
    public function __construct($id, $width = null, $height = null)
    {
        $this->id = $id;

        if (! is_null($width)) {
            $this->width = $width;
        }

        if (! is_null($height)) {
            $this->height = $height;
        }
    }


    public function render()
    {
        return <<<div
<div id="{$this->id}" style="width: {$this->width}; height: {$this->height}"></div>
div;

    }
}
