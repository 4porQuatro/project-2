<?php

namespace Packages\Store\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Packages\Store\app\Models\Product;

class UniqueProductVariant implements Rule
{
    public $product;
    public $attirbute_options;
    public $variant;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Product $product, $attribute_options, $variant = null)
    {
        $this->product = $product;
        $this->attirbute_options = array_filter($attribute_options);
        $this->variant = $variant;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exist_variant = $this->product->variations()->where(function ($q){
            foreach ($this->attirbute_options as $attribute_option_id)
            {
                $q->whereHas('attributeOptions', function ($sub_q) use ($attribute_option_id){
                    $sub_q->where('attribute_option_id', $attribute_option_id);
                });
            }
        });

        if($this->variant)
        {
            $exist_variant = $exist_variant->where('id', '!=', $this->variant->id);
        }

        $exist_variant = $exist_variant->exists();

        return !$exist_variant;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('store::cms.variant_already_exists_error');
    }
}
