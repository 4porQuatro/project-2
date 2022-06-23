<?php


namespace App\Classes\Front\Data;

use App\Models\Category;

class CategoryData extends FieldDataAbstract {

    public function setDefaultValue()
    {
        $categories = $this->getCategories();
        $limit = $this->getLimit();

        $articles = Category::whereIn('parent_id', $categories)->ordered();

        if($limit)
        {
            $articles = $articles->limit($limit);
        }

        return $articles->get();
    }

    public function setAlternativesValue(): \stdClass
    {
        $categories = $this->getCategories();
        $obj =  new \stdClass();
        $obj->tree = Category::whereIn('id', $categories)->with('childrens')->ordered()->get();

        return $obj;
    }

    public function getCategories()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['categories']) ? $this->data->data_array[$this->field->name]['categories'] :[];
    }

    public function getLimit()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['limit']) ? $this->data->data_array[$this->field->name]['limit'] : null;
    }
}
