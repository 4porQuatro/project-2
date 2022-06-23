<?php

namespace Packages\Store\app\Http\Requests\api;

use App\Models\Category;
use App\Models\ExternalReference;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\AttributeOption;
use Packages\Store\app\Models\Product;


class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->method() == 'POST' ? auth()->user()->can('store', Product::class) : auth()->user()->can('update', new Product());
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
        auth()->user()->apiPatchData()->create(['identifier'=>'create_product', 'data'=>$this->all()]);
        return ['title' => 'required', 'categories'=>'required|array', 'optionals'=>'present|array', 'attributes'=>'present|array', 'is_parent'=>'boolean', 'shippment_length'=>'integer', 'shippment_weight'=>'integer', 'shippment_width'=>'integer', 'shippment_height'=>'integer'];
    }

    public function updateRules()
    {
        auth()->user()->apiPatchData()->create(['identifier'=>'update_product', 'data'=>$this->all()]);
        return ['categories'=>'array', 'attributes'=>'array', 'optionals'=>'array', 'parent_identifier'=>'prohibited', 'attribute_family_identifier'=>'prohibited', 'shippment_length'=>'integer', 'shippment_weight'=>'integer', 'shippment_width'=>'integer', 'shippment_height'=>'integer'];
    }

    public function existingCategories()
    {
        return $this->has('categories') ?
            count($this->get('categories')) == Category::where('categorable', Product::class)->whereIn('id', $this->get('categories'))->count() : true;
    }

    public function existingOptionals()
    {
        return $this->has('optionals') ?
            count($this->get('optionals')) == Product::whereIn('id', $this->get('optionals'))->count() : true;
    }

    public function isParent()
    {
        return $this->has('is_parent') && $this->get('is_parent');
    }

    public function existingParentId()
    {
        return $this->has('parent_identifier') && !empty($this->get('parent_identifier'));
    }

    public function productParentExists()
    {
        return Product::where('id', $this->get('parent_identifier'))->exists();
    }

    public function getParent()
    {
        return Product::where('id', $this->get('parent_identifier'))->first();
    }

    public function productCanHaveVariants()
    {
        $product = $this->getParent();

        if(empty($product) || !empty($product->parent_id) || ! $product->has_variants)
            return false;
        return true;

    }

    public function attributeFamily($identifier)
    {
        if(!empty($this->getProduct()))
            return $this->getProduct()->family;

        return AttributeFamily::find($identifier);

    }

    public function allAttributeOptionsSelected()
    {
        return AttributeOption::whereIn('id', $this->get('attributes'))->get();
    }

    public function allAttributeOptionsExists()
    {
        return $this->has('attributes') ? count($this->get('attributes')) == $this->allAttributeOptionsSelected()->count() : true;
    }

    public function allAttributesHasOneOption($identifier)
    {
        $attributes = $this->attributeFamily($identifier)->attributes;
        $all_attribute_options_selected = $this->allAttributeOptionsSelected()->pluck('id')->toArray();
        foreach($attributes as $attribute)
        {
            $attribute_options_ids = $attribute->attributeOptions->pluck('id')->toArray();
            $existing_attribute_options = array_intersect($attribute_options_ids, $all_attribute_options_selected);
            if(count($existing_attribute_options) != 1)
                return false;

        }
        return true;
    }

    private function someAttributesDontExists()
    {
        if($this->has('identifier_attributes') && !empty($this->get('identifier_attributes')) && is_array($this->get('identifier_attributes')))
        {
            foreach($this->get('identifier_attributes') as $att)
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
        if(! $validator->fails())
        {
            $validator->after(function ($validator) {
                if($this->method() == 'POST')
                    $validator = $this->withValidatorPost($validator);
                if($this->method() == 'PUT')
                    $validator = $this->withValidatorPut($validator);
            });
        }
    }

    protected function prepareForValidation()
    {
        if($this->method() == 'POST' && ! $this->existingParentId() && (! $this->has('attribute_family_identifier') || empty($this->get('attribute_family_identifier'))))
        {
            //find attributes
            $attributes_ids = AttributeOption::whereIn('id', $this->get('attributes'))->get()->pluck('attribute_id')->toArray();
            //Check for a family matching exacly the same attributes
            $families = AttributeFamily::whereHas('attributes', function($q) use ($attributes_ids) {
                $q->whereIn('attributes.id', $attributes_ids);
            })->with('attributes')->get();
            $selected_family = null;

            foreach($families as $family)
            {
                $att_fam_ids = array_values($family->attributes->pluck('id')->toArray());
                sort($att_fam_ids);
                $att_received = array_values($attributes_ids);
                sort($att_received);
                if($att_fam_ids ==  $att_received)
                {
                    $selected_family = $family->id;
                }
            }

            //if dont find create it!
            if(empty($selected_family))
            {
                $attribute_family = AttributeFamily::create(['title'=>'Automatically generated']);
                $attribute_family->title = $attribute_family->title.' #'.$attribute_family->id;
                $attribute_family->save();
                $attribute_family->attributes()->attach($attributes_ids);
                $selected_family = $attribute_family->id;
            }

            $this->request->add(['attribute_family_identifier'=>$selected_family]);
        } else if($this->method() == 'POST' &&  $this->existingParentId() && (! $this->has('attribute_family_identifier') || empty($this->get('attribute_family_identifier'))))
        {
            $this->request->add(['attribute_family_identifier'=>$this->getParent()->attribute_family_id]);
        }

    }

    private function withValidatorPost($validator)
    {
        if(! $this->existingCategories())
        {
            $validator->errors()->add('categories', 'Some categories dont exists');
        }
        if(empty($this->attributeFamily($this->get('attribute_family_identifier'))))
        {
            $validator->errors()->add('attribute_family_identifier', 'The given attribute family dont exists');
        }
        if($this->existingParentId() && ! empty($this->attributeFamily($this->get('attribute_family_identifier')))
            && $this->attributeFamily($this->get('attribute_family_identifier'))->id != $this->getParent()->attribute_family_id )
        {
            $validator->errors()->add('attribute_family_identifier', 'The attribute_family_identifier must be the same of the parent');
        }
        if( ! $this->existingParentId() && $this->has('attributes') && ! $this->allAttributeOptionsExists($this->get('attribute_family_identifier')))
        {
            $validator->errors()->add('attributes', 'Some of the attributes dont exists');
        }
        if( ! $this->isParent() && $this->has('attributes') && empty($this->getProduct()) && ! $this->allAttributesHasOneOption($this->get('attribute_family_identifier')) )
        {
            $validator->errors()->add('attributes', 'All attributes for the given family must have at least one option');
        }
        if($this->has('optionals') && ! $this->existingOptionals())
        {
            $validator->errors()->add('optionals', 'Some optionals dont have records');
        }
        if($this->existingParentId() && (! $this->productParentExists() || ! $this->productCanHaveVariants()))
        {
            $validator->errors()->add('parent_id', 'The parent_id dont exists or it cant have childrens');
        }
        return $validator;
    }

    private function withValidatorPut($validator)
    {
        if(empty($this->getProduct()))
        {
            $validator->errors()->add('product', 'The given product dont exists');
        }
        if(! $this->existingCategories())
        {
            $validator->errors()->add('categories', 'Some categories dont exists');
        }
        if($this->has('attributes') && ! $this->allAttributeOptionsExists())
        {
            $validator->errors()->add('attributes', 'Some of the attributes dont exists');
        }
        if($this->has('attributes') && !empty($this->getProduct()) && ! $this->allAttributesHasOneOption($this->getProduct()->attribute_family_id) )
        {
            $validator->errors()->add('attributes', 'All attributes for the given family must have at least one option');
        }
        if($this->has('optionals') && ! $this->existingOptionals())
        {
            $validator->errors()->add('optionals', 'Some optionals dont have records');
        }
    }

    /**
     * @return mixed
     */
    private function getProduct()
    {
        return Product::find($this->route('product'));;
    }
}
