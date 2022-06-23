<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CmsFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function update(CmsFormRequest $request)
    {
        $user = auth()->user();

        if(!Hash::check($request->password, $user->password))
        {
            return  $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->back()->withErrors([
                    'password' =>  [trans('reserved::cms.wrong_current_password')],
                ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        if($request->ajax())
        {
            return response('success', 200);
        }

        return redirect()->back()->with('success', true);
    }
}
