<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Classes\Traits\LoginRedirectTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CmsFormRequest;
use App\Models\Form;
use App\Models\User;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    use LoginRedirectTrait;

    public function store(CmsFormRequest $request)
    {
        $form = Form::findOrFail($request->get('cms_form_id'));

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'profile_input_types'=>'[]'
        ]);

        $input_types = $form->fields()->ordered()->get()->pluck('type', 'name');

        $user->profile_fields = $form->fields()->get()->pluck('label', 'name')->toArray();
        $user->profile_data = $this->generateData($input_types);
        $user->profile_input_types = $input_types;
        $user->reserved_area_id = $form->formable->id;

        $user->save();

        Auth::guard()->login($user);

        return redirect()->to($this->getRedirectPage($request->route()->getPrefix()));
    }


    private function generateData($input_types)
    {
        $data = request()->except('name', 'email', 'password', 'password_confirmation', 'cms_form_id', '_token');

        foreach($data as $key=>$value)
        {
            if (isset($input_types[$key]) && $input_types[$key] == 'doc' && !empty($value))
            {
                $data[$key] = $value->store('doc', 'form_uploads');
            }
        }
        return $data;
    }
}
