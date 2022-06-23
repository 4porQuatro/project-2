<?php


namespace App\Classes\Ui\Constants;


class Components extends ConstantAbstract
{
    public $routes = [
        'cms.components.index',
        'cms.components.create',
        'cms.components.edit',
        'cms.components.sections.edit',
    ];

    public function data()
    {
        $data = [
            'cms.components.index'=>[
                'title'=>Trans('cms.components_list'),
            ],

            'cms.components.create'=>[
                'title'=>Trans('cms.new_component'),
                'back_link'=>[
                    'link'=>route('cms.components.index'),
                    'text'=>Trans('cms.components_list')
                ],
            ],

            'cms.components.edit'=>[
                'title'=>Trans('cms.component_data'),
                'back_link'=>[
                    'link'=>route('cms.components.index'),
                    'text'=>Trans('cms.components_list')
                ],
            ],

            'cms.components.sections.edit'=>[
                'title'=>Trans('cms.add_content_sections'),
                'back_link'=>[
                    'link'=>$this->componentFieldsLink(),
                    'text'=>Trans('cms.fields_list'),
                ],
            ]
        ];

        return $data;
    }

    public function componentFieldsLink()
    {
        if(request('component_data'))
        {
            $component_id = request('component_data')->id;
            return route('cms.fields.index', ['model'=>'Component', 'id'=>$component_id]);
        }

        return '';
    }
}
