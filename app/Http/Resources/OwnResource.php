<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OwnResource extends Resource
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
            'username' => $this->name,
            'sex' => $this->sex,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'github_name' => $this->github_name,
            'qq_name' => $this->qq_name,
            'weibo_name' => $this->weibo_name,

            'score_all' => $this->score_all,
            'score_now' => $this->score_now,

            'login_days' => $this->login_days,
            'last_login_date' => $this->last_login_date,

            'is_init_name' => $this->is_init_name,
            'is_init_email' => $this->is_init_email,
            'is_init_password' => $this->is_init_password,

            'login_count' => $this->login_count,
        ];
    }
}
