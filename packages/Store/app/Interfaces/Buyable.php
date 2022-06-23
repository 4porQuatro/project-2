<?php


namespace Packages\Store\app\Interfaces;


interface Buyable
{
    /**
     * Check if the model can be bought
     *
     * @return boolean
     */
    public function canBeBought(): bool;

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    public function getBuyablePrice();
}
