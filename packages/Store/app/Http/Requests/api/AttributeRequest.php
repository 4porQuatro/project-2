<?php

namespace Packages\Store\app\Http\Requests\api;

use App\Models\ExternalReference;
use Illuminate\Foundation\Http\FormRequest;
use Packages\Store\app\Models\Attribute;

class AttributeRequest extends FormRequest
{
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

    public function storeRules()
    {
        auth()->user()->apiPatchData()->create(['identifier'=>'create_attribute', 'data'=>$this->all()]);
        return ['title'=>'required'];
    }

    public function updateRules()
    {
        auth()->user()->apiPatchData()->create(['identifier'=>'edit_attribute', 'data'=>$this->all()]);
        return ['title'=>'required'];
    }

    private function existingAttribute()
    {
        return Attribute::find($this->route('attribute'));
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
            if ($this->method() == 'PUT' && empty($this->existingAttribute()))
            {
                $validator->errors()->add('attribute', 'The attribute dont exists');
            }
        });
    }
}
