<?php

namespace App\Http\Controllers\Api;

use App\Services\ErrorServe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    protected $code = 200;
    protected $msg = '';
    protected $data = [];

    public function setCode($code)
    {
        $this->code = $code;

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
        return $this->setCode(ErrorServe::HTTP_NOT_FOUND)
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
        return $this->setCode(401)
            ->toJson();
    }

    public function toJson()
    {
        return response()->json($this->formatResponse());
    }

    public function formatResponse()
    {
        return [
            'code' => $this->code,
            'msg' => ErrorServe::getErrorMsg($this->code) ?? $this->msg,
            'data' => $this->data
        ];
    }

}
