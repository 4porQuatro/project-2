<?php


namespace App\Classes\Repositories\Article;


use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

class ArticleRepository {

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
        $this->filterByCategory();
        $this->filterByTag();
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

        $cat = $this->attributes['categories'];

        $this->query = $this->query->whereIn('articles.id', function($query) use ($cat){
            $query->from('categorables')->select('categorables.categorable_id')->whereIn('categorables.category_id', $cat);
        });
    }

    public function filterPromoted()
    {
        if(! isset($this->attributes['promoted']))
            return;

        $this->query = $this->query->promoted();
    }

    public function order()
    {
        if(isset($this->attributes['order_field']) && isset($this->attributes['order_direction']) && !empty($this->attributes['order_field']) && !empty($this->attributes['order_direction']))
        {
            if(in_array($this->attributes['order_field'], (new Article())->translatedAttributes))
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

    private function filterByTag()
    {
        if(! isset($this->attributes['tags']) || ! is_array($this->attributes['tags']))
            return;

        foreach($this->attributes['tags'] as $cat)
        {
            $this->query = $this->query->whereHas('tags', function($q) use ($cat){

                $q->where('tags.id', $cat);

            });
        }
    }
}
