<?php


namespace App\Classes\Ui\Constants;


class Categories extends ConstantAbstract
{
    public $routes = [
        'cms.categories.index',
        'cms.categories.create',
        'cms.categories.edit',
    ];

    public function data()
    {
        $data = [
            'cms.categories.index'=>[
                'title'=>$this->indexName(),
            ],

            'cms.categories.create'=>[
                'title'=>Trans('cms.new_category'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexName(),
                ],
            ],

            'cms.categories.edit'=>[
                'title'=>Trans('cms.category_data'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexName(),
                ],
            ],
        ];

        return $data;
    }

    public function indexName()
    {
        $categorable = request()->get('categorable');
        return Trans('cms.categories_list_for').': '. $categorable::getReadableName(true);
    }

    public function indexLink()
    {
        $categorable = request()->get('categorable');
        return route('cms.categories.index', ['categorable'=>$categorable]);
    }
}
