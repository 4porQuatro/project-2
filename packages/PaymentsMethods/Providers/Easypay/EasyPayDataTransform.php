<?php


namespace Packages\PaymentsMethods\Providers\Easypay;


use Packages\PaymentsMethods\Providers\PaymentDataTransform;

class EasyPayDataTransform implements PaymentDataTransform {

    public $data_received;

    public function getData($data_received, $method, $total)
    {
        $this->data_received = json_decode($data_received);
        if($this->data_received->method->type == 'cc')
            return $this->transformCC();
        if($this->data_received->method->type == 'mb')
            return $this->transformMB($total);
        if($this->data_received->method->type == 'mbw')
            return $this->transformMBW();
    }

    public function transformCC()
    {
        return [
            'method'=>'cc',
            'redirect'=>true,
            'data'=>[
                'url'=> $this->data_received->method->url
            ],
        ];
    }

    public function transformMB($total)
    {
        return [
            'method'=>'mb',
            'redirect'=>false,
            'data'=>[
                'entity'=>$this->data_received->method->entity,
                'reference'=> $this->data_received->method->reference,
                'value'=>$total,
            ]
        ];
    }

    public function transformMBW()
    {
        return [
            'method'=>'mbw',
            'redirect'=>false,
            'data'=>[],
        ];
    }

}
