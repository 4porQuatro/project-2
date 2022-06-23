<?php


namespace App\Classes\Front\Data;


use App\Models\Menu;

class MenuData extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ?

            Menu::with(['items'=>function($q){
                $q->with('childrens');
               return $q->withoutParent()->active();
            }])->find($this->data->data_array[$this->field->name]) :

            new Menu();
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }
}
