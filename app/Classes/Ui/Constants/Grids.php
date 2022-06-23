<?php


namespace App\Classes\Ui\Constants;


class Grids extends ConstantAbstract
{
    public $routes = [
        'cms.layout-grids.index',
        'cms.layout-grids.create',
        'cms.layout-grids.edit',
    ];

    public function data()
    {
        $data = [
            'cms.layout-grids.index' => [
                'title'=>$this->indexTitle(),
                'back_link'=>[
                    'link'=>route('cms.layouts.index'),
                    'text'=>Trans('cms.layouts_list'),
                ],
            ],

            'cms.layout-grids.create' => [
                'title'=>Trans('cms.create_new_grid'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle(),
                ],
            ],

            'cms.layout-grids.edit' => [
                'title'=>Trans('cms.grid_data'),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle(),
                ],
            ]
        ];

        return $data;
    }

    public function getLayout()
    {
        return request('layout');
    }

    public function indexTitle()
    {
        $layout = $this->getLayout();

        return Trans('cms.grids_list_for_layout').': '.$layout->name;
    }

    public function indexLink()
    {
        $layout = $this->getLayout();

        return route('cms.layout-grids.index', ['layout'=>$layout->id]);
    }
}
