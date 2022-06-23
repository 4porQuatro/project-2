<?php


namespace App\Classes\Front\Data;

use App\Models\Form as FormData;


class Form extends FieldDataAbstract {

    public $form;

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ? $this->getData() : [];
    }

    public function setAlternativesValue(): \stdClass
    {
        $obj = new \stdClass();

        if(!empty($this->form) && $this->form->hasFieldGroups())
        {
            $obj->field_groups = $this->form->getFieldGroupsWithFields();
        }

        return $obj;
    }


    private function getData()
    {
        $this->form = FormData::where('id', $this->data->data_array[$this->field->name])->with(['fields'=>function($q){
            $q->ordered();
        }])->first();

        return $this->form;
    }
}
