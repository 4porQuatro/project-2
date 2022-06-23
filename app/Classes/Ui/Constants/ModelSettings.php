<?php


namespace App\Classes\Ui\Constants;


class ModelSettings extends ConstantAbstract
{
    public $routes = [
        'cms.model-settings.index',
        'cms.model-settings.create',
        'cms.model-settings.edit',
    ];

    public function data()
    {
        $data = [
            'cms.model-settings.index'=>[
                'title'=>$this->indexTitle(),
            ],

            'cms.model-settings.create'=>[
                'title'=>Trans('cms.new_type'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle(),
                ],
            ],

            'cms.model-settings.edit'=>[
                'title'=>Trans('cms.type_data'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle(),
                ],
            ]
        ];

        return $data;
    }

    public function getModel()
    {
        return request('model');
    }

    public function indexTitle()
    {
        $model = $this->getModel();

        return Trans('cms.types_list_for').': "'.$model.'"';
    }

    public function indexLink()
    {
        $model = $this->getModel();

        return route( 'cms.model-settings.index', ['model'=>$model]);
    }
}
