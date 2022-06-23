<?php

namespace App\Http\Requests;

use App\Models\Page;
use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getMethod() == 'POST' ? auth()->user()->can('store', Page::class) : auth()->user()->can('update', $this->page);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->getMethod() == 'POST')
        {
            return ['name' => 'required', 'slug' => ['nullable', new SlugRule(), 'unique:page_translations']];
        } elseif ($this->getMethod() == 'PATCH')
        {
            return ['name' => 'required', 'slug' => ['required', new SlugRule(), Rule::unique('page_translations')->where(function ($q) {
                return $q->where('page_id', '<>', $this->page->id);
            })]

            ];
        }
    }
}
