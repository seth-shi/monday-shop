<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\OwnResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnController extends Controller
{
    public function me()
    {
        $me = auth()->user();

        return responseJson(200, 'success', new OwnResource($me));
    }
}
