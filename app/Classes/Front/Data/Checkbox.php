<?php


namespace App\Classes\Front\Data;


use App\Models\Component;
use App\Models\Field;

class Checkbox extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ? $this->data->data_array[$this->field->name] == true : false;
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }
}
