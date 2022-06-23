<?php

namespace App\Http\Requests;

use App\Models\Field;
use App\Rules\OnlyCharsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FieldRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isMethod('patch')  ? $this->user()->can('update', $this->route('field')) : $this->user()->can('store', Field::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->isMethod('patch') ? $this->updateRules() : $this->storeRules();
    }

    public function storeRules()
    {
        $field = new Field();

        $field->fieldable_type = $this->getModelClass($this->route('model'));
        $field->fieldable_id = $this->route('id');
        $field->id = 0;
        return ['name'=>['required', new OnlyCharsRule(), $this->uniqueName($field)], 'label'=>'required', 'type'=>'required'];
    }

    public function updateRules()
    {
        $field = $this->route('field');
        if($field->editable)
        {
            return ['name'=>['required', new OnlyCharsRule(), $this->uniqueName($field)], 'label'=>'required', 'type'=>'required'];
        } else {
            return ['label'=>'required'];
        }
    }

    public function uniqueName($field)
    {
        return Rule::unique('fields')->ignore($field->id)->where(function($q) use ($field) {
            $q->where('fieldable_type', $field->fieldable_type);
            $q->where('fieldable_id', $field->fieldable_id);
        });
    }

    /**
     * @param $model
     * @return string
     */
    private function getModelClass($model): string
    {
        $model_class = 'App\Models\\' . $model;

        return $model_class;
    }

    public function generateOptionsArray()
    {
        $options = [];
        $this->options = $this->options ?? [];
        foreach ($this->options as $key=>$option)
        {
            if(is_array($option))
            {
                $options[$option[0]] = $option[1];
            }
            else
            {
                $slug = Str::slug($option).'-'.$key;

                $options[$slug] = $option;
            }
        }

        return $options;
    }
}
