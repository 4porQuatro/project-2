<?php


namespace Packages\Store\app\Classes\Front\Data;

use App\Classes\Front\Data\FieldDataAbstract;
use App\Models\Article;
use App\Models\Category;
use Packages\Store\app\Models\Product;

class ProductsData extends FieldDataAbstract {

    public function setDefaultValue()
    {

        $categories = $this->getCategories();
        $attribute_families = $this->getAttributeFamilies();
        $limit = $this->getLimit();
        $promoted = $this->getPromoted();
        $highlighted = $this->getHighlighted();

        $products = Product::primary();

        if($categories)
        {
            $products = $products->whereHas('categories', function ($q) use ($categories){
                $q->whereIn('categories.id', $categories);
            });
        }

        if($attribute_families)
        {
            $products = $products->whereIn('attribute_family_id', $attribute_families);
        }

        if($limit)
        {
           $products = $products->limit($limit);
        }

        if($promoted)
        {
            $products = $products->promoted();
        }

        if($highlighted)
        {
            $products = $products->highlighted();
        }

        return $products->active()->ordered()->with('translations')->get();
    }

    public function setAlternativesValue(): \stdClass
    {
        $obj =  new \stdClass();
        $obj->selected_categories = $this->getCategories();
        $obj->selected_categories_obj = Category::whereIn('id', $obj->selected_categories)->get();

        return $obj;
    }

    public function getCategories()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['categories']) ? $this->data->data_array[$this->field->name]['categories'] :[];
    }

    public function getAttributeFamilies()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['attribute_families']) ? $this->data->data_array[$this->field->name]['attribute_families'] :[];
    }

    public function getLimit()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['limit']) ? $this->data->data_array[$this->field->name]['limit'] : null;
    }

    public function getPromoted()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['promoted']) ? $this->data->data_array[$this->field->name]['promoted'] : null;
    }

    public function getHighlighted()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['highlighted']) ? $this->data->data_array[$this->field->name]['highlighted'] : null;
    }
}
