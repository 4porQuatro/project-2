<?php


namespace App\Classes\Ui\Constants;


class Categorables extends ConstantAbstract
{
    public $routes = [
        'cms.categorables.index',
        'cms.categorables.edit',
    ];

    public function data()
    {
        $data = [
            'cms.categorables.index'=>[
                'title'=>$this->indexTitle(),
                'back_link'=>[
                    'link'=>$this->categoriesListLink(),
                    'text'=>$this->categoriesListName(),
                ],
            ],

            'cms.categorables.edit'=>[
                'title'=>$this->editTitle(),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle(),
                ],
            ]
        ];

        return $data;
    }

    public function getCategory()
    {
        return request('category');
    }

    public function indexTitle()
    {
        $category = $this->getCategory();

        return Trans('cms.list_items_for_the_category').': '.$category->name;
    }

    public function indexLink()
    {
        $category = $this->getCategory();

        return route('cms.categorables.index', ['category'=>$category->id, 'categorable'=>$category->categorable]);
    }

    public function categoriesListName()
    {
        $category = $this->getCategory();

        return Trans('cms.categories_list_for').': '. $category->categorable::getReadableName(true);
    }

    public function categoriesListLink()
    {
        $category = $this->getCategory();

        return route('cms.categories.index', ['categorable'=>$category->categorable]);
    }

    public function editTitle()
    {
        $category = $this->getCategory();

        return Trans('cms.add_items_to_category').$category->name;
    }
}
