<?php


namespace App\Classes\Slug;


use Illuminate\Support\Str;

class CreateSlug
{
    public $model;
    public $string;
    public $column;

    public function __construct($model_name, $string, $column = 'slug')
    {
        $this->model = $model_name;
        $this->string = $string;
        $this->column = $column;
    }

    public function create()
    {
        $slug = Str::slug($this->string);

        $latestSlug = env('DB_CONNECTION') != 'sqlite' ?
            $this->model::whereRaw($this->column." RLIKE '^{$slug}(-[0-9]*)?$'")->latest('id')->value($this->column) :
            $this->model::whereRaw($this->column." LIKE '^{$slug}(-[0-9]*)?$'")->latest('id')->value($this->column)
        ;

        if($latestSlug)
        {
            $pieces = explode('-', $latestSlug);
            $number = intval(end($pieces))+1;
            $slug = $slug . '-' .$number;
        }

        return $slug;
    }
}
