<?php


namespace App\Classes\Ui\Constants;


use App\Models\Category;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\shipping_methods\App\Models\ShippingMethod;

class Articlabes extends ConstantAbstract
{
    public $routes = [
        'cms.articlable.edit'
    ];

    protected function data()
    {
        $data = [
            'cms.articlable.edit'=>[
                'title'=>Trans('cms.details'),
                'back_link'=>[
                    'link'=>$this->getBackLink(),
                    'text'=>$this->getBackText(),
                ]
            ]
        ];

        return $data;
    }

    public function getModel()
    {
        return request('articlable_type');
    }

    public function getId()
    {
        return request('articlable_id');
    }

    public function getBackLink()
    {
        $model = $this->getModel();
        $model_object = $model::findOrFail($this->getId());

        switch ($model)
        {
            case (Category::class):
                return route('cms.categories.index', ['categorable'=>$model_object->categorable]);

            case(PaymentMethod::class):
                return route('cms.payment_methods.edit', ['payment_method'=>$this->getId()]);

            case(ShippingMethod::class):
                return route('cms.shipping_methods.index');

            default:
                return 'default*getBackLink';
        }
    }

    public function getBackText()
    {
        $model = $this->getModel();
        $model_object = $model::findOrFail($this->getId());

        switch ($model)
        {
            case (Category::class):
                $categorable = $model_object->categorable;
                return Trans('cms.categories_list_for').': '. $categorable::getReadableName(true);

            case(PaymentMethod::class):
                return Trans('payment_methods::cms.edit_payment_method');

            case(ShippingMethod::class):
                return Trans('shipping_methods::cms.list');

            default:
                return 'default*getBackText';
        }
    }
}
