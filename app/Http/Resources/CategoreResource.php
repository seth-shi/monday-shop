<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CategoreResource extends Resource
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
            'id' => $this->id,
            'name' => (string)$this->title,
            'description' => (string)$this->description,
            'icon' => (string)$this->icon,
            'thumb' => assertUrl((string)$this->thumb),
        ];
    }
}
