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
            'email' => (string)$this->email,
            'avatar' => (string)$this->avatar,
            'github_name' => (string)$this->github_name,
            'qq_name' => (string)$this->qq_name,
            'weibo_name' => (string)$this->weibo_name,

            'score_all' => (int)$this->score_all,
            'score_now' => (int)$this->score_now,

            'login_days' => (int)$this->login_days,
            'last_login_date' => (string)$this->last_login_date,

            'is_init_name' => (bool)$this->is_init_name,
            'is_init_email' => (bool)$this->is_init_email,
            'is_init_password' => (bool)$this->is_init_password,
        ];
    }
}
