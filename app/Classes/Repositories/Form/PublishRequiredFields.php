<?php


namespace App\Classes\Repositories\Form;


use App\Interfaces\Formable;

class PublishRequiredFields {

    private $formable;
    public $form;

    public function __construct($form)
    {
        $this->formable = $form->formable;
        $this->form = $form;
    }

    public function create()
    {
        $this->updateFormSettings();
        foreach ($this->form->formable->formRequiredFields()[$this->form->type] as $inputs)
        {
            $data = ['name' => $inputs['name'], 'type' => $inputs['type'], 'rules' => $inputs['rules'], 'editable' => $inputs['editable']];
            $field = $this->form->fields()->create($data);

            foreach (config('translatable.locales') as $locale)
            {
                $field->translateOrNew($locale)->label = $inputs['label'];

            }
            $field->save();
        }
    }

    private function updateFormSettings()
    {
        $this->form->update($this->form->formable->formSettingsByType()[$this->form->type]);
    }

}
