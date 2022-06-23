<?php


namespace App\Classes\Ui\Constants;


class Customers extends ConstantAbstract
{
    public $routes = [
        'cms.customers.show'
    ];

    public function data()
    {
        return [
            'cms.customers.show'=>[
                'title'=>$this->getTitle(),
                'back_link'=>[
                    'link'=>$this->getBackLink(),
                    'text'=>Trans('reserved::cms.reserved_area'),
                ]
            ]
        ];
    }

    public function getCustomer()
    {
        return request('customer');
    }

    public function getTitle()
    {
        $customer = $this->getCustomer();

        return Trans('reserved::cms.reserved_area').': '.$customer->reservedArea->name;
    }

    public function getBackLink()
    {
        $customer = $this->getCustomer();

        return route('cms.reserved_area.show', ['reserved_area'=>$customer->reservedArea->id]);
    }
}
