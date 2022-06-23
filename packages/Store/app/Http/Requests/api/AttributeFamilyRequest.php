<?php

namespace Packages\Store\app\Http\Requests\api;

use App\Models\ExternalReference;
use Illuminate\Foundation\Http\FormRequest;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\AttributeOption;

class AttributeFamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() == 'POST' ? auth()->user()->can('store', AttributeFamily::class) : auth()->user()->can('update', new AttributeFamily());
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
        auth()->user()->apiPatchData()->create(['identifier'=>'create_attribute_family', 'data'=>$this->all()]);
        return ['title' => 'required', 'attribute_identifiers'=>'array'];
    }

    public function updateRules()
    {
        auth()->user()->apiPatchData()->create(['identifier'=>'update_attribute_family', 'data'=>$this->all()]);
        return ['title' => 'required', 'attribute_identifiers'=>'array'];
    }

    public function existingReference()
    {
        return AttributeFamily::find($this->route('attribute_family'));
    }

    private function someAttributesDontExists()
    {
        if($this->has('attribute_identifiers') && !empty($this->get('attribute_identifiers')) && is_array($this->get('attribute_identifiers')))
        {
            foreach($this->get('attribute_identifiers') as $att)
            {
                if( ! Attribute::where('id', $att)->exists())
                {
                    return true;
                }
            }
        }
        return false;
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
            if(empty($this->existingReference()) && $this->method() == 'PUT')
            {
                $validator->errors()->add('attribute_family', 'The given attribute family dont exists');
            }
            if($this->someAttributesDontExists())
            {
                $validator->errors()->add('attribute_identifiers', 'Some identifier attributes dont exists');
            }
        });
    }
}
