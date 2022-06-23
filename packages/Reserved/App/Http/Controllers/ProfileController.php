<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CmsFormRequest;
use App\Models\Form;
use App\Models\User;
use App\Rules\SlugRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Packages\Reserved\App\Models\ReservedArea;

class ProfileController extends Controller
{

    public function update(CmsFormRequest $request)
    {
        $form = Form::findOrFail($request->get('cms_form_id'));

        $custumer = auth()->user();

        $input_types = $form->fields()->ordered()->get()->pluck('type', 'name');

        $data = [
            'name'=>$request->get('name') ?? $custumer->name,
            'profile_input_types'=>$input_types,
            'profile_fields'=>$form->fields()->get()->pluck('label', 'name')->toArray(),
            'profile_data'=>$this->generateData($input_types, $custumer->profile_data)
        ];

        $custumer->update($data);

        if($request->ajax())
        {
            return response('success', 200);
        }

        return redirect()->back()->with('success', true);
    }

    private function generateData($input_types, $old_data)
    {
        $data = request()->except('name', 'email', 'password', 'password_confirmation', 'cms_form_id', '_token');

        foreach($data as $key=>$value)
        {
            if (isset($input_types[$key]) && $input_types[$key] == 'doc')
            {
                if(!empty($value))
                {
                    $data[$key] = $value->store('doc', 'form_uploads');
                }
                else
                {
                    $data[$key] = $old_data[$key] ?? null;
                }
            }
        }

        $data = array_merge($old_data, $data);

        return $data;
    }
}
