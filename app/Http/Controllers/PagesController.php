<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Layout;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index($slug=null)
    {
        $page = empty($slug) ? Page::where('is_homepage', 1)->where('pageable_type', null)->whereTranslation('active', true)->firstOrFail()
            : Page::whereTranslation('slug', $slug)->where('pageable_type', null)->firstOrFail();
        $seo = $page->seo;
        $sections = $page->sections()->active()->orderBy('sectionables.priority', 'asc')->get();
        $layout = $page->layout ?? Layout::where('default', 1)->first();
        return view($layout->getPath(), compact('seo','page', 'sections', 'layout'));
    }

    public function show($type, $slug)
    {
        $result = $this->getModel($type)::whereTranslation('slug', $slug)->firstOrFail();
        $seo = $result->seo;
        $sections = $result->sections()->active()->orderBy('sectionables.priority', 'asc')->get();
        $layout = $result->layout ?? Layout::where('default', 1)->first();

        return view($layout->getPath(), compact('result', 'seo', 'sections', 'layout'));
    }

    public function getModel($model_name)
    {
        $models = [
            'article' => Article::class,
            'category'=> Article::class,
            'product' => 'Packages\Store\app\Models\Product'
        ];

        return $models[$model_name];
    }
}
