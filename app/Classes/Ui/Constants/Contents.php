<?php


namespace App\Classes\Ui\Constants;


use App\Models\Section;
use Illuminate\Support\Facades\URL;

class Contents extends ConstantAbstract
{
    public $routes = [
        'cms.content.edit'
    ];

    public function data()
    {
        $data = [
            'cms.content.edit'=>[
                'title'=>$this->title(),
                'back_link'=>[
                    'link'=>$this->sectionListLink(),
                    'text'=>Trans('cms.sections_list'),
                ],
            ]
        ];

        return $data;
    }

    public function title()
    {
        $section = Section::findOrFail(request('id'));

        return Trans('cms.section_data').': '.$section->name;
    }

    public function sectionListLink()
    {
        return URL::previous() == request()->fullUrl() ? route('cms.sections.index') : URL::previous();
    }
}
