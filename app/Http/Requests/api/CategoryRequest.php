<?php

namespace App\Http\Requests\api;

use App\Models\Category;
use App\Models\ExternalReference;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() == 'POST' ? auth()->user()->can('store', Category::class) : auth()->user()->can('update', Category::class);
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ( ! in_array($this->type, ['articles', 'products']))
            {
                $validator->errors()->add('type', 'The given data is invalid');
            }
            if ($this->method() == 'PUT' && ! $this->existingCategory($this->route('category')))
            {
                $validator->errors()->add('identifier', 'The category for this identifier dont exists');
            }
            if(!empty($this->parent_identifier) && ! $this->existingCategory($this->parent_identifier))
            {
                $validator->errors()->add('parent_identifier', 'The parent category doenst exists');
            }
        });
    }

    public function existingCategory($id)
    {
        return Category::where('id', $id)->exists();
    }

    private function storeRules()
    {
        return [ 'name'=>'required'];
    }

    private function updateRules()
    {
        return [];
    }
}
