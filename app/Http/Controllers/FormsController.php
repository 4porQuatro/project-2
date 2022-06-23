<?php

namespace App\Http\Controllers;

use App\Http\Requests\CmsFormRequest;
use App\Mail\FormSubmitedMail;
use App\Models\Form;
use Illuminate\Support\Facades\Mail;

class FormsController extends Controller
{
    public function store(CmsFormRequest $request)
    {
        $form = Form::findOrFail($request->get('cms_form_id'));
        $fields = $form->fields()->ordered()->get()->pluck('label', 'name');
        $input_types = $form->fields()->ordered()->get()->pluck('type', 'name');
        $data = ['data_submited'=>$this->generateData($input_types), 'form_data'=>$fields, 'input_types'=>$input_types, 'locale'=>app()->getLocale()];

        if(!empty(url()->previous()))
        {
            $data['form_url'] = url()->previous();
        }
        $submission = $form->submissions()->create($data);
        if(!empty($form->email_receivers))
        {
            Mail::send(new FormSubmitedMail($form, $submission));
        }
        if($request->ajax())
        {
            return response('success', 200);
        }
        return redirect()->back()->with('success', true);
    }

    private function generateData($input_types)
    {
        $data = request()->except('_token', 'cms_form_id', 'g-recaptcha-response');

        foreach($data as $key=>$value)
        {
            if (isset($input_types[$key]) && $input_types[$key] == 'doc')
            {
                $data[$key] = $value->store('doc', 'form_uploads');
            }
        }
        return $data;
    }
}
