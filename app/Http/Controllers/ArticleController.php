<?php

namespace App\Http\Controllers;

use App\Classes\Front\QueryBuilder;
use App\Models\Article;
use Illuminate\Http\Request;
use Packages\Store\app\Models\Product;

class ArticleController extends Controller
{
    public function get()
    {
        $articles = Article::active()->with(['translations', 'categories.translations'])->filter(request()->except('_token'));
        if(request()->has('items_per_page'))
        {
            return $articles->paginate(request()->get('items_per_page'));
        }
        return ['data'=>$articles->get()];
    }
}
