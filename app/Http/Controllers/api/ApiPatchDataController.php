<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ApiPatchData;
use Illuminate\Http\Request;

class ApiPatchDataController extends Controller
{
    public function store(Request $request, $type)
    {
        auth()->user()->apiPatchData()->create(['identifier'=>$type, 'data'=>$request->all()]);
    }
}
