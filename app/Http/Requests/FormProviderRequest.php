<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class FormProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider'=>'required'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->verifyIfProviderExists()) {
                $validator->errors()->add('provider', trans('cms.cant_repeat'));
            }
        });
    }

    /**
     * @return bool
     */
    private function verifyIfProviderExists(): bool
    {
        $exists = false;
        $setting = Setting::where('name', 'form_providers')->first();
        if ( ! empty($setting))
        {
            foreach ($setting->data as $value)
            {
                if ($value['provider'] == $this->provider) $exists = true;
            }
        }

        return $exists;
    }
}
