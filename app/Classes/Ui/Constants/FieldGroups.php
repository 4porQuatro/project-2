<?php


namespace App\Classes\Ui\Constants;


use App\Models\Form;

class FieldGroups extends ConstantAbstract
{
    public $routes = [
        'cms.field_groups.index',
        'cms.field_groups.create',
        'cms.field_groups.edit',
    ];

    protected function data()
    {
        return [
            'cms.field_groups.index'=>[
                'title'=>Trans('cms.field_groups_list'),
                'back_link'=>[
                    'link'=>$this->getModelListLink(),
                    'text'=>$this->getModelListText(),
                ]
            ],

            'cms.field_groups.create'=>[
                'title'=>Trans('cms.create_new_field_group'),
                'back_link'=>[
                    'link'=>$this->fieldGroupListLink(),
                    'text'=>Trans('cms.field_groups_list'),
                ]
            ],

            'cms.field_groups.edit'=>[
                'title'=>Trans('cms.field_group_data'),
                'back_link'=>[
                    'link'=>$this->fieldGroupListLink(),
                    'text'=>Trans('cms.field_groups_list'),
                ]
            ]
        ];
    }

    public function getModel()
    {
        return request('model') ?? request('field_group')->field_groupable_type;
    }

    public function getId()
    {
        return request('model_id') ?? request('field_group')->field_groupable_id;
    }

    public function getModelListLink()
    {
        $model = $this->getModel();

        switch ($model)
        {
            case (Form::class):
                return  $this->getFormModelListLink();

                default:
                    return 'default*getModelListLink';
        }
    }

    public function getModelListText()
    {
        $model = $this->getModel();

        switch ($model)
        {
            case (Form::class):
                return Trans('cms.list_forms');

            default:
                return 'default*getModelListLink';
        }
    }

    public function fieldGroupListLink()
    {
        return route('cms.field_groups.index', ['model'=>$this->getModel(), 'model_id'=>$this->getId()]);
    }

    public function getFormModelListLink()
    {
        $form = Form::findOrFail($this->getId());
        $formable_type = $form->formable_type;

        if(empty($formable_type))
        {
            return route('cms.forms.index');
        }

        return route('cms.forms.index', [
            'formable_id'=>$form->formable_id,
            'formable_type'=>$formable_type
        ]);
    }
}
