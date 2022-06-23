<?php

namespace App\Classes\Mutators;

class Price {

    private float $price;
    private float $tax_included;
    private float $current_rate;

    public function __construct($price, $tax_included)
    {
        $this->price = $price;
        $this->tax_included = $tax_included;
        $this->current_rate = 1;
    }

    public function get()
    {
        return $this->price;
    }

    public function getPriceWithoutTaxes()
    {
        $this->setPriceWithoutTax();
        return $this->price;
    }

    public function setPriceWithoutTax()
    {
        $this->price = $this->price/(1+$this->tax_included);
        return $this;
    }

    public function setTaxes(float $tax_to_add)
    {
        $this->setPriceWithoutTax();
        $this->price = $this->price*(1+$tax_to_add);
        $this->tax_included = $tax_to_add;
    }

    public function setToRate(float $rate)
    {
        $this->price = $this->price*$rate/$this->current_rate;
        $this->current_rate = $rate;
    }

}
