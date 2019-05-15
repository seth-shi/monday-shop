<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\OwnResource;
use App\Http\Resources\ScoreLogResource;
use App\Models\User;
use App\Services\PageServe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnController extends Controller
{
    public function me()
    {
        $me = auth()->user();

        return responseJson(200, 'success', new OwnResource($me));
    }

    public function scoreLogs(PageServe $serve)
    {
        list($limit, $offset) = $serve->getPageParameters();
        /**
         * @var $me User
         */
        $me = auth()->user();

        $query = $me->scoreLogs();

        $count = $query->count();
        $scoreLogs = $me->scoreLogs()
                        ->latest()
                        ->offset($offset)
                        ->limit($limit)
                        ->get();


        return responseJson(200, 'success', ScoreLogResource::collection($scoreLogs), compact('count'));
    }
}
