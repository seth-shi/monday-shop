<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => (string)$this->uuid,
            'name' => (string)$this->name,
            'title' => (string)$this->title,
            'price' => (double)$this->price,
            'original_price' => (double)$this->original_price,
            'thumb' => $this->thumb,
            'sale_count' => (int)$this->sale_count,
            'count' => (int)$this->count,
            'view_count' => (int)$this->view_count,
            'created_at' => (string)$this->created_at,

            'content' => $this->whenLoaded('detail', function () {

                return (string)optional($this->detail)->content;
            }),
            'pictures' => $this->whenLoaded('detail', function () {

                return $this->assertPictures($this->pictures);
            }),
        ];
    }

    protected function assertPictures($pictures)
    {
        return collect($pictures)->map(function ($uri) {

            return assertUrl($uri);
        });
    }
}
