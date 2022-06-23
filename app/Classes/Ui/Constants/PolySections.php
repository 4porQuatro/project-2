<?php


namespace App\Classes\Ui\Constants;


use App\Models\Article;
use App\Models\Category;
use App\Models\Layout;
use App\Models\ModelSetting;
use App\Models\Page;
use Packages\Orders\App\Models\Checkout;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\Store\app\Models\Product;

class PolySections extends ConstantAbstract
{
   public $routes = [
       'cms.poly.sections.index',
       'cms.poly.sections.create',
   ];

    public function data()
    {
        $data = [
            'cms.poly.sections.index'=>[
                'title'=>Trans('cms.sections_list'),
                'back_link'=>[
                    'link'=>$this->modelListLink(),
                    'text'=>$this->modelListName(),
                ],
            ],

            'cms.poly.sections.create'=>[
                'title'=>Trans('cms.create_new_section'),
                'back_link'=>[
                    'link'=>$this->modelSectionsList(),
                    'text'=>Trans('cms.sections_list'),
                ],
            ]
        ];

        return $data;
    }

    public function getModel()
    {
        return request('model');
    }

    public function getId()
    {
        return request('model_id');
    }

    public function modelListName()
    {
        $model = $this->getModel();
        $id = $this->getId();
        $model_object = $model::findOrFail($id);

        switch ($model){
            case Layout::class:
                return Trans('cms.layouts_list');

            case Article::class:
                return $this->getArticleListName($model_object);

            case ModelSetting::class:
                return Trans('cms.types_list_for').': "'.$model.'"';

            case Page::class:
                return Trans('cms.pages_list');

            case Product::class:
                return Trans('store::cms.products_list');

            case Checkout::class:
                return Trans('order::cms.list_checkout');

            case PaymentMethod::class:
                return Trans('payment_methods::cms.list_payment_methods');

            default:
                return 'default*modelListName';
        }
    }

    public function modelListLink()
    {
        $model = $this->getModel();
        $id = $this->getId();

        $model_object = $model::findOrFail($id);

        switch ($model){
            case Layout::class:
                return route( 'cms.layouts.index');

            case Article::class:
                return $this->getArticleListLink($model_object);

            case ModelSetting::class:
                return route( 'cms.model-settings.index', ['model'=>$model_object->model]);

            case Page::class:
                return route('cms.pages.index');

            case Product::class:
                return route('cms.products.index');

            case Checkout::class:
                return route('cms.checkout.index');

            case PaymentMethod::class:
                return route('cms.payment_methods.index');

            default:
                return 'default*modelListLink';
        }

    }

    public function modelSectionsList()
    {
        $model = $this->getModel();
        $id = $this->getId();

        return route('cms.poly.sections.index', ['model_id'=>$id, 'model'=>$model]);
    }

    public function getArticleListLink($article)
    {
        if(empty($article->articlable))
        {
            $category = $article->categories()->first();
            return route('cms.articles.index', ['cat'=>$category->id]);
        }
        else
        {
            $articlable_type = $article->articlable_type;
            switch ($articlable_type)
            {
                case(Category::class):
                    return route('cms.articlable.edit', ['articlable_type'=>$articlable_type,'articlable_id'=>$article->articlable->id]);

                case(PaymentMethod::class):
                    return route( 'cms.payment_methods.edit', ['payment_method'=>$article->articlable->id]);

                case(ShippingMethod::class):
                    return route('cms.articlable.edit', ['articlable_type'=>$articlable_type,'articlable_id'=>$article->articlable->id]);

                default:
                    return 'default*getArticleListLink';
            }
        }
    }

    public function getArticleListName($article)
    {
        if(empty($article->articlable))
        {
            $category = $article->categories()->first();
            return $category ? $category->name : Trans('cms.articles_list');
        }
        else
        {
            return Trans('cms.details');
        }

    }

}
