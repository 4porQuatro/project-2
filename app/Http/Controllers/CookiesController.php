<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookiesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cookie_time' => 'required',
            'cookie_val' => 'required',
            'cookie_name' => 'required',
        ]);

        $time = $request->cookie_time;
        $value = $request->cookie_val;
        $name = $request->cookie_name;

        return response('Cookie setted')->withCookie(cookie($name, $value, $time));
    }
}
