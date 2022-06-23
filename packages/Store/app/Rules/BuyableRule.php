<?php

namespace Packages\Store\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Packages\Store\app\Models\Product;

class BuyableRule implements Rule
{
    public $product;
    public $quantity;

    public $message_key = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
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
        if(empty($this->product))
        {
            $this->message_key = 'product_not_found';
            return false;
        }

        if(!$this->product->canBeBought())
        {
            $this->message_key = 'product_cant_be_bought';
            return false;
        }

        if($this->product->stock < $this->quantity)
        {
            $this->message_key = 'low_stock';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $messages = [
            'product_not_found'=>'Produto não encontrado',
            'product_cant_be_bought'=>'Produto não pode ser comprado',
            'low_stock'=>'Não existe stock suficiente'
        ];

        return $messages[$this->message_key];
    }
}
