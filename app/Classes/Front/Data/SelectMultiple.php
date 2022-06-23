<?php


namespace App\Classes\Front\Data;


use App\Models\Component;
use App\Models\Field;

class SelectMultiple extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ? $this->data->data_array[$this->field->name] : [];
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }
}
