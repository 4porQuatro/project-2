<?php


namespace Packages\PaymentsMethods\Providers;


interface PaymentInterface {
    public function generatePayment(Order $order, Customer $customer, $method);
    public function avaliableMethods();
    public function transformDataClass();
}
