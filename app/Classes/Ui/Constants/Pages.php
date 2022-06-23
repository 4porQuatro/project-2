<?php


namespace App\Classes\Ui\Constants;


use Packages\Reserved\App\Models\ReservedArea;

class Pages extends ConstantAbstract
{
    public $routes = [
        'cms.pages.index',
        'cms.pages.create',
        'cms.pages.edit',
    ];

    protected function data()
    {
        return [
            'cms.pages.index'=>[
                'title'=>Trans('cms.pages_list'),
                'back_link'=>$this->generateIndexBackLink(),
            ],

            'cms.pages.create'=>[
                'title'=>Trans('cms.create_new_page'),
                'back_link'=>[
                    'link'=>$this->pagesListLink(),
                    'text'=>Trans('cms.pages_list')
                ]
            ],

            'cms.pages.edit'=>[
                'title'=>Trans('cms.page_data'),
                'back_link'=>[
                    'link'=>$this->pagesListLink(),
                    'text'=>Trans('cms.pages_list')
                ]
            ]
        ];
    }

    public function generateIndexBackLink()
    {
        $pageable_type = request('pageable_type');

        if(empty($pageable_type))
        {
            return null;
        }

        $pageable_id = request('pageable_id');

        switch ($pageable_type)
        {
            case (ReservedArea::class):
                return [
                    'link'=>route('cms.reserved_area.show', ['reserved_area'=>$pageable_id]),
                    'text'=>Trans('reserved::cms.reserved_area')
                ];

            default:
                return [
                    'link'=>'default*indexBackLink',
                    'text'=>'default*indexBackLink'
                ];
        }

    }

    public function pagesListLink()
    {
        $pageable_type = request('pageable_type');

        if(empty($pageable_type))
        {
            return route('cms.pages.index');
        }

        $pageable_id = request('pageable_id');

        return route('cms.pages.index', [
            'pageable_type'=>$pageable_type,
            'pageable_id'=>$pageable_id
        ]);
    }
}
