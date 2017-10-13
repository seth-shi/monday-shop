<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $errno = 200;
    protected $msg = '';
    protected $data = [];

    public function setErrno($errno)
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

        return $data;
    }

    public function formatResponse()
    {
        return [
            'errno' => $this->errno,
            'msg' => $this->msg,
            'data' => $this->data
        ];
    }

    public function response()
    {
        return $this->formatResponse();
    }
}
