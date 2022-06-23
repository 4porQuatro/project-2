<?php

namespace App\Http\Requests;

use App\Classes\Repositories\Form\PublishRequiredFields;
use App\Models\Form;
use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isMethod('patch') ? $this->user()->can('update', $this->route('form')) : $this->user()->can('store', Form::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->isMethod('post') && $this->has('formable_type'))
        {
            return ['name' => 'required', 'type' => 'required'];
        }

        return ['name' => 'required'];


    }

    public function save()
    {
        return $this->isMethod('post') ? $this->savePost() : $this->saveUpdate();
    }


    public function saveUpdate()
    {
        $data = $this->only('name');
        $data['apply_recaptcha'] = $this->apply_recaptcha ?? 0;
        $data['email_receivers'] = ! empty($this->email_receivers) ? explode(',', $this->get('email_receivers')) : [];

        return $this->route('form')->update($data);
    }

    public function savePost()
    {
        $data = $this->only('name', 'type', 'formable_type', 'formable_id');
        $data['email_receivers'] = ! empty($this->email_receivers) ? explode(',', $this->get('email_receivers')) : [];
        $data['apply_recaptcha'] = $this->apply_recaptcha ?? 0;

        $form = Form::create($data);

        return $this->saveFormable($form);

    }

    public function saveFormable($form)
    {
        if ($this->has('formable_type') && method_exists($form->formable, 'formSettingsByType'))
        {
            (new PublishRequiredFields($form))->create();
        }
        return $form;
    }


}
