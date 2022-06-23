<?php


namespace App\Classes\Front\Data;


class InternalLink extends FieldDataAbstract {

    public function setDefaultValue()
    {
        if(isset($this->data->data_array[$this->field->name])){
            $data = json_decode($this->data->data_array[$this->field->name], true);
            $class = $data['class'];
            $id = $data['id'];

            $object = $class::find($id);

            return !empty($object) ? $object->path() : '';
        }

        return '';

        //$id = $this->data->data_array[];
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }
}
