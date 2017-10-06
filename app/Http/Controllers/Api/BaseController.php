<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $statusCode = 200;
    protected $message = '';
    protected $data = [];

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }


    public function response()
    {
        return response()->json([
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }

}
