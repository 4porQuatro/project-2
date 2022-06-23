<?php


namespace Packages\PaymentsMethods\Providers;


interface PaymentDataTransform {
    public function getData($data_received, $method, $total);
}
