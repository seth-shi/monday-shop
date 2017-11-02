<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

trait ApiTrait
{
    protected $errno = 200;
    protected $msg = '';
    protected $data = [];

    public function setCode($errno)
    {
        $this->errno = $errno;

        return $this;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function formatResponse()
    {
        return [
            'code' => $this->errno,
            'msg' => $this->msg,
            'data' => $this->data
        ];
    }

    public function toJson()
    {
        return $this->formatResponse();
    }
}
