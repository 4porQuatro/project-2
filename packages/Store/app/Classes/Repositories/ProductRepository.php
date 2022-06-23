<?php


namespace Packages\Store\app\Classes\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Packages\Store\app\Models\Product;

class ProductRepository {
    private $query;
    private $attributes;


    public function __construct(Builder $query, array $attributes)
    {
        $this->query = $query;
        $this->attributes = $attributes;
    }

    public function filter()
    {
        $this->filterByTerm();
        $this->filterPromoted();
        $this->filterHighlighted();
        $this->filterByCategory();
        $this->filterByAttributes();
        $this->filterByIntervalPrices();
        $this->order();
        return $this->query;
    }

    public function filterByTerm()
    {
        if(!isset($this->attributes['search_term']))
            return;
        $search_term ='%'.$this->attributes['search_term'].'%';
        $this->query = $this->query->whereHas('translations', function($q) use ($search_term){
            $q->where('title', 'LIKE', $search_term);
        });
    }

    public function filterByCategory()
    {
        if(! isset($this->attributes['categories']) || ! is_array($this->attributes['categories']))
            return;

        foreach($this->attributes['categories'] as $cat)
        {
            $this->query = $this->query->whereHas('categories', function($q) use ($cat){
                $q->where('categories.id', $cat);
            });
        }
    }

    public function filterByAttributes()
    {
        if(! isset($this->attributes['att']) || ! is_array($this->attributes['att']))
            return;
        foreach($this->attributes['att'] as $key =>$value)
        {
            $filter = ! is_array($value) ? json_decode($value, true) : $value;

            $this->query = $this->query->whereHas('attributeOptions', function($q) use ($filter){
               $q->whereIn('attribute_options.id', $filter);
            });
        }
    }

    public function filterByIntervalPrices(){
        if(! isset($this->attributes['smallest_price']) || !isset($this->attributes['biggest_price']))
            return;

        $smallest_price = empty($this->attributes['smallest_price']) ? 0 : $this->attributes['smallest_price'];
        $biggest_price = empty($this->attributes['biggest_price']) ? 1000000000 : $this->attributes['biggest_price'];
        $this->query->where(function($q) use ($smallest_price, $biggest_price) {
            $q->whereBetween('price', [$smallest_price, $biggest_price]);
            $q->orWhereBetween('promoted_price', [$smallest_price, $biggest_price]);
        });
    }

    public function filterPromoted()
    {
        if(! isset($this->attributes['promoted']))
            return;

        $this->query = $this->query->promoted();
    }

    public function filterHighlighted()
    {
        if(! isset($this->attributes['highlighted']))
            return;

        $this->query = $this->query->highlighted();
    }

    public function order()
    {
        if(isset($this->attributes['order_field']) && isset($this->attributes['order_direction']) && !empty($this->attributes['order_field']) && !empty($this->attributes['order_direction']))
        {
            if(in_array($this->attributes['order_field'], (new Product())->translatedAttributes))
            {
                $this->query = $this->query->orderByTranslation($this->attributes['order_field'], $this->attributes['order_direction']);
            } else {
                $this->query = $this->query->orderBy($this->attributes['order_field'], $this->attributes['order_direction']);
            }
        }
        else {
            $this->query = $this->query->ordered();
        }
    }
}
