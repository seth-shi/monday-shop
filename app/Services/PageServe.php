<?php

namespace App\Services;

use Illuminate\Http\Request;

class PageServe
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getPageParameters($limit = 10)
    {
        $page = $this->request->input('page', 1);
        $limit = $this->request->input('limit', $limit);
        $offset = ($page - 1) * $limit;

        return [$limit, $offset, $page];
    }

    public function input($key, $default = null)
    {
        return $this->request->input($key, $default);
    }
}
