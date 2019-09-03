<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponTemplateController extends Controller
{
    public function index()
    {
        return view('coupons.templates');
    }
}
