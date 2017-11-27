<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
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

    public function notFound()
    {
        return $this->setCode(Response::HTTP_NOT_FOUND)
            ->setMsg('找不到请求的内容')
            ->toJson();
    }

    public function created($msg = '创建成功', array $data = [])
    {
        return $this->setCode(Response::HTTP_CREATED)
            ->setMsg('创建成功')
            ->setData($data)
            ->toJson();
    }

    public function authFail()
    {
        return $this->setCode(Response::HTTP)
            ->setMsg('找不到请求的内容')
            ->toJson();
    }

    public function toJson()
    {
        return response()->json($this->formatResponse());
    }

    public function formatResponse()
    {
        return [
            'code' => $this->errno,
            'msg' => $this->msg,
            'data' => $this->data
        ];
    }

}
