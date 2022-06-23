<?php


namespace App\Classes\Ui\Constants;


use App\Models\Component;

class Terms extends ConstantAbstract
{
    public $routes = [
        'cms.terms.index',
        'cms.terms.create',
        'cms.terms.edit',
    ];

    public function data()
    {
        $data = [
            'cms.terms.index'=>[
                'title'=>Trans('cms.list_terms'),
                'back_link'=>[
                    'link'=>$this->modelListLink(),
                    'text'=>$this->modelListName(),
                ],
            ],

            'cms.terms.create'=>[
                'title'=>Trans('cms.new_term'),
                'back_link'=>[
                    'link'=>$this->termsIndex(),
                    'text'=>Trans('cms.list_terms'),
                ],
            ],

            'cms.terms.edit'=>[
                'title'=>Trans('cms.edit_term'),
                'back_link'=>[
                    'link'=>$this->termsIndex(),
                    'text'=>Trans('cms.list_terms'),
                ],
            ]
        ];

        return $data;
    }

    public function getModel()
    {
        if(request('termable_type'))
        {
            return request('termable_type');
        }

        return get_class(request('term')->termable);
    }

    public function getId()
    {
        if(request('termable_id'))
        {
            return request('termable_id');
        }

        return request('term')->termable->id;
    }

    public function modelListName()
    {
        $model = self::getModel();

        switch ($model)
        {
            case (Component::class):
                return Trans('cms.components_list');

            default:
                return 'default*modelListName';
        }
    }

    public function modelListLink()
    {
        $model = self::getModel();

        switch ($model)
        {
            case (Component::class):
                return route('cms.components.index');

            default:
                return 'default*modelListLink';
        }
    }

    public function termsIndex()
    {
        $model = $this->getModel();
        $id = $this->getId();

        return route('cms.terms.index', ['termable_id'=>$id, 'termable_type'=>$model]);
    }
}
