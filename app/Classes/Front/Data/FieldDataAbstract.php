<?php


namespace App\Classes\Front\Data;


use App\Models\Field;

abstract class FieldDataAbstract {

    protected $data;
    protected $field;

    public function setData(ComponentData $component_data, Field $field)
    {
        $this->data = $component_data;
        $this->field = $field;
        $component_data->result->{$field->name} = $this->setObject();
    }

    public function setObject()
    {
        $obj = new \stdClass();
        $obj->default = '';
        $obj->default = $this->setDefaultValue();
        $obj->alternatives = $this->setAlternativesValue();
        return $obj;
    }

    public abstract function setDefaultValue();


    public abstract function setAlternativesValue() :\stdClass;

}
