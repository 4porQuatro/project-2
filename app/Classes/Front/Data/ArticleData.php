<?php


namespace App\Classes\Front\Data;


use App\Models\Article;

class ArticleData extends FieldDataAbstract {

    public function setDefaultValue()
    {
        $articles = new Article;

        if($this->getPromoted())
        {
            $articles = $articles->promoted();
        }
        if($this->getLimit())
        {
            $articles = $articles->limit($this->getLimit());
        }

        $articles = $articles->whereIn('articles.id', fn ($q) => $q->from('categorables')->select('categorables.categorable_id')->whereIn('categorables.category_id', $this->getCategories()));

        return $articles->active()->ordered()->get();
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }

    public function getCategories()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['categories']) ? $this->data->data_array[$this->field->name]['categories'] :[];
    }

    public function getLimit()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['limit']) ? $this->data->data_array[$this->field->name]['limit'] : null;
    }

    public function getPromoted()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['promoted']) ? $this->data->data_array[$this->field->name]['promoted'] : null;
    }
}
