<?php

namespace App\Http\Requests;

use App\Classes\Rules\RuleSelector;
use App\Models\Form;
use App\Rules\GoogleRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class CmsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->get('cms_form_id'))
        {
          return true;
        } else {
            throw new \Exception('O formulário deverá conter o campo relacionado com o identificador do formulário (cms_form_id)');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $form = Form::findOrFail($this->get('cms_form_id'));

        $rules_selector = new RuleSelector();
        foreach($form->fields as $field)
        {
            $field_rules = $rules_selector->getFromArray($field->rules);
            if($field->type == 'doc')
            {
                $field_rules[] = 'max:2097152';

            }
            $rules[$field->name] = $field_rules;

        }
        if($form->apply_recaptcha)
        {
           $rules['g-recaptcha-response'] = ['required', new GoogleRecaptcha()];
        }

        return $rules;
    }
}
