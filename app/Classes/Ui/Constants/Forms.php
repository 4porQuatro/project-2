<?php


namespace App\Classes\Ui\Constants;


use Packages\Reserved\App\Models\ReservedArea;

class Forms extends ConstantAbstract
{
    public $routes = [
        'cms.forms.index',
        'cms.forms.create',
        'cms.forms.edit',
    ];


    protected function data()
    {
        return [
            'cms.forms.index'=>[
                'title'=>Trans('cms.list_forms'),
                'back_link'=>$this->indexBackLink(),
            ],

            'cms.forms.create'=>[
                'title'=>Trans('cms.new_form'),
                'back_link'=>[
                    'link'=>$this->createEditBackLink(),
                    'text'=>Trans('cms.list_forms')
                ]
            ],

            'cms.forms.edit'=>[
                'title'=>Trans('cms.form_data'),
                'back_link'=>[
                    'link'=>$this->createEditBackLink(),
                    'text'=>Trans('cms.list_forms')
                ]
            ]
        ];
    }

    public function getId()
    {
        return request('formable_id');
    }

    public function getModelType()
    {
        return request('formable_type');
    }

    public function indexBackLink()
    {
        $model_type = $this->getModelType();

        if(empty($model_type))
        {
            return null;
        }

        switch ($model_type)
        {
            case (ReservedArea::class):
                return [
                    'link'=>route('cms.reserved_area.show', ['reserved_area'=>$this->getId()]),
                    'text'=>Trans('reserved::cms.reserved_area')
                ];

            default:
                return [
                    'link'=>'default*indexBackLink',
                    'text'=>'default*indexBackLink'
                ];
        }
    }

    public function createEditBackLink()
    {
        $model_type = $this->getModelType();

        if(empty($model_type))
        {
            return route('cms.forms.index');
        }

        return route('cms.forms.index', [
            'formable_type'=>$model_type,
            'formable_id'=>$this->getId()
        ]);
    }
}
