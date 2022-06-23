<?php

namespace Packages\Store\app\Http\Requests\api;

use App\Models\ExternalReference;
use Illuminate\Foundation\Http\FormRequest;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeOption;

class AttributeOptionRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() == 'POST' ? auth()->user()->can('store', Attribute::class) : auth()->user()->can('update', new Attribute());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->method() == 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules()
    {
        auth()->user()->apiPatchData()->create(['identifier' => 'create_attribute_option', 'data' => $this->all()]);

        return ['title' => 'required', 'attribute_identifier' => 'required'];
    }

    private function updateRules()
    {
        auth()->user()->apiPatchData()->create(['identifier' => 'edit_attribute_option', 'data' => $this->all()]);
        return ['title' => 'required'];

    }

    private function existingAttributeReference()
    {
        return Attribute::find($this->get('attribute_identifier'));
    }

    private function existingReference()
    {
        return AttributeOption::find($this->route('attribute_option'));
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->existingAttributeReference()) && $this->method() == 'POST')
            {
                $validator->errors()->add('attribute_identifier', 'The given attribute identifier dont exists');
            }
            if ($this->method() == 'PUT' &&empty($this->existingReference()))
            {
                $validator->errors()->add('attribute_option', 'The given attribute option dont exists');
            }
        });
    }
}
