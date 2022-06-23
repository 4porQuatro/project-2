<?php


namespace App\Classes\Ui\Constants;


use App\Models\Form;
use Packages\Orders\App\Models\Checkout;
use Packages\Reserved\App\Models\ReservedArea;

class Fields extends ConstantAbstract
{
    public $routes = [
        'cms.fields.index',
        'cms.fields.create',
        'cms.fields.edit',
    ];

    public function data()
    {
        $data = [
            'cms.fields.index'=>[
                'title'=>Trans('cms.fields_list'),
                'back_link'=>[
                    'link'=>$this->modelListLink(),
                    'text'=>$this->modelListName(),
                ],
            ],

            'cms.fields.create'=>[
                'title'=>Trans('cms.create_new_field'),
                'back_link'=>[
                    'link'=>$this->fieldsIndex(),
                    'text'=>Trans('cms.fields_list'),
                ],
            ],

            'cms.fields.edit'=>[
                'title'=>Trans('cms.edit_field'),
                'back_link'=>[
                    'link'=>$this->fieldsIndex(),
                    'text'=>Trans('cms.fields_list'),
                ],
            ]
        ];

        return $data;
    }

    public function getModel()
    {
        if(request('model'))
        {
            return request('model');
        }

        $class_name = explode('\\', get_class(request('field')->fieldable));

        return $class_name[count($class_name) - 1];
    }

    public function getId()
    {
        if(request('id'))
        {
            return request('id');
        }

        return request('field')->fieldable->id;
    }

    public function modelListName()
    {
        $model = $this->getModel();

        switch ($model)
        {
            case ('Component'):
                return Trans('cms.components_list');

            case ('Form'):
                return $this->getFormModelListName();

            default:
                return 'default*fields*';
        }
    }

    public function modelListLink()
    {
        $model = self::getModel();

        switch ($model){
            case('Component'):
                return route('cms.components.index');

            case ('Form'):
                return $this->getFormModelListLink();

            default:
                return 'default*modelListLink';
        }
    }

    public function fieldsIndex()
    {
        $model = $this->getModel();
        $id = $this->getId();

        return route('cms.fields.index', ['model'=>$model, 'id'=>$id]);
    }

    public function getFormModelListLink()
    {
        $form = Form::findOrFail($this->getId());
        $formable_type = $form->formable_type;

        if(empty($formable_type))
        {
            return route('cms.forms.index');
        }

        if($formable_type == Checkout::class)
        {
            return route('cms.checkout.index');
        }

        return route('cms.forms.index', [
            'formable_id'=>$form->formable_id,
            'formable_type'=>$formable_type
        ]);
    }

    public function getFormModelListName()
    {
        $form = Form::findOrFail($this->getId());
        $formable_type = $form->formable_type;

        if($formable_type == Checkout::class)
        {
            return Trans('order::cms.list_checkout');
        }

        return Trans('cms.list_forms');
    }

}
