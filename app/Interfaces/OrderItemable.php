<?php


namespace App\Interfaces;


interface OrderItemable {
    public function getItemName();
    public function getItemPrice();
    public function getItemPath();
}
