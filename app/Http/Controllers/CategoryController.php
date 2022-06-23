<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show($id)
    {
        return Category::with('article.sections')->where('id', $id)->first();
    }
    public function getChildrens(Category $category)
    {
        return ['data'=>$category->childrens()->with('translations')->ordered()->get()];
    }

    public function getAllChildrens(Category $category)
    {
        $categories = $category->getAllChildrens();
        if(request()->has('level'))
        {
            $level = request()->get('level');
            $categories = $categories->filter(function($item) use ($level) {
                return $item->level == $level;
            });
        }
        return ['data'=>$categories];
    }
}
