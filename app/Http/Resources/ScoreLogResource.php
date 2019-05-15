<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ScoreLogResource extends Resource
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
            'description' => $this->description,
            'score' => $this->score,
            'created_at' => (string)$this->created_at
        ];
    }
}
