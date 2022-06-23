<?php


namespace App\Classes\Front\Data;


use App\Models\Field;

class Integer extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ? $this->data->data_array[$this->field->name] : '';
    }

    public function setAlternativesValue() :\stdClass
    {
        $obj = new \stdClass();
        $obj->integer = isset($this->data->data_array[$this->field->name]) ? intval($this->data->data_array[$this->field->name]) : '';
        $obj->string = isset($this->data->data_array[$this->field->name]) ? strval($this->data->data_array[$this->field->name]) : '';
        return $obj;
    }
}
