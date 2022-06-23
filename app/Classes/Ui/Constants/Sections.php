<?php


namespace App\Classes\Ui\Constants;


use Illuminate\Support\Facades\URL;

class Sections extends ConstantAbstract
{
    public $routes = [
        'cms.sections.index',
        'cms.sections.create',
        'cms.sections.edit',
        'cms.special-sections.index',
    ];

    public function data()
    {
        $data = [
            'cms.sections.index'=>[
                'title'=>Trans('cms.sections_list'),
            ],

            'cms.sections.create'=>[
                'title'=>Trans('cms.create_new_section'),
                'back_link'=>[
                    'link'=>$this->sectionListLink(),
                    'text'=>Trans('cms.sections_list'),
                ],
            ],

            'cms.sections.edit'=>[
                'title'=>Trans('cms.edit_geral_section_data'),
                'back_link'=>[
                    'link'=>$this->sectionListLink(),
                    'text'=>Trans('cms.sections_list'),
                ],
            ],

            'cms.special-sections.index'=>[
                'title'=>Trans('cms.global_sections_list'),
            ]
        ];

        return $data;
    }

    public function sectionListLink()
    {
        return URL::previous() == request()->fullUrl() ? route('cms.sections.index') : URL::previous();
    }
}
