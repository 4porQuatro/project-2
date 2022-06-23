<?php


namespace App\Classes\Ui\Constants;


use App\Models\Category;

class Articles extends ConstantAbstract
{
    public $routes = [
        'cms.articles.index',
        'cms.articles.create',
        'cms.articles.edit',
    ];

    public function data()
    {
        $data = [
            'cms.articles.index'=>[
                'title'=>$this->indexName(),
            ],

            'cms.articles.create'=>[
                'title'=>Trans('cms.new_article'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexName(),
                ],
            ],

            'cms.articles.edit'=>[
                'title'=>Trans('cms.article_data'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexName(),
                ],
            ]
        ];

        return $data;
    }

    public function indexName()
    {
        $cat = request('cat');
        $category = Category::where('id', $cat)->first();

        return $category ? $category->name : Trans('cms.articles_list');
    }

    public function indexLink()
    {
        $cat = request('cat');

        return route('cms.articles.index', ['cat'=>$cat]);
    }
}
