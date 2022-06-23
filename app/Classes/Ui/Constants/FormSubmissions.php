<?php


namespace App\Classes\Ui\Constants;


class FormSubmissions extends ConstantAbstract
{
    public $routes = [
        'cms.forms.submissions.index',
        'cms.forms.submissions.show',
    ];

    protected function data()
    {
        return [
            'cms.forms.submissions.index'=>[
                'title'=>$this->getIndexTitle(),
                'back_link'=>[
                    'link'=>$this->getIndexBackLink(),
                    'text'=>Trans('cms.list_forms')
                ]
            ],

            'cms.forms.submissions.show'=>[
                'title'=>$this->getShowTitle(),
                'back_link'=>[
                    'link'=>$this->listLink(),
                    'text'=>Trans('cms.form_submissions')
                ]
            ],
        ];
    }

    public function getForm()
    {
        return request('form');
    }

    public function getIndexTitle()
    {
        $form = $this->getForm();

        return Trans('cms.list_answears_for').' :'.$form->name;
    }

    public function getShowTitle()
    {
        $form = $this->getForm();

        return Trans('cms.answear_for').' :'.$form->name;
    }

    public function listLink()
    {
        $form = $this->getForm();

        return route('cms.forms.submissions.index', ['form'=>$form->id]);
    }

    public function getIndexBackLink()
    {
        $form = $this->getForm();
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
