<?php

namespace Packages\Store\app\Classes\Front\Data;

use App\Classes\Front\Data\FieldDataAbstract;
use Packages\Store\app\Models\Attribute;

class AttributeListData extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return Attribute::whereIn('id', $this->getAttributes())->with('attributeOptions')->get();
    }

    public function setAlternativesValue(): \stdClass
    {
        $obj =  new \stdClass();
        return $obj;

    }

    public function getAttributes()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['attributes']) ? $this->data->data_array[$this->field->name]['attributes'] :[];
    }
}
