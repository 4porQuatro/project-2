<?php


namespace App\Classes\Ui\Constants;


class AttributeOptions extends ConstantAbstract
{
    public $routes = [
        'cms.attribute-options.index',
        'cms.attribute-options.create',
        'cms.attribute-options.edit',
    ];

    public function data()
    {
        return [
            'cms.attribute-options.index'=>[
                'title'=>$this->indexTitle(),
                'back_link'=>[
                    'link'=>route('cms.attributes.index'),
                    'text'=>Trans('store::cms.attributes_list')
                ]
            ],

            'cms.attribute-options.create'=>[
                'title'=>$this->createTitle(),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle()
                ]
            ],

            'cms.attribute-options.edit'=>[
                'title'=>$this->editTitle(),
                'back_link'=>[
                    'link'=>$this->indexLink(),
                    'text'=>$this->indexTitle()
                ]
            ],
        ];
    }

    public function getAttribute()
    {
        return request('attribute');
    }

    public function indexTitle()
    {
        return Trans('store::cms.options_for_attribute').': '.$this->getAttribute()->title;
    }

    public function indexLink()
    {
        return route('cms.attribute-options.index', ['attribute'=>$this->getAttribute()->id]);
    }

    public function createTitle()
    {
        return Trans('store::cms.create_new_attribute_option').': '.$this->getAttribute()->title;
    }

    public function editTitle()
    {
        return Trans('store::cms.edit_attribute_option').': '.$this->getAttribute()->title;
    }
}
