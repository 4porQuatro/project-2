<?php


namespace App\Classes\Front\Data;


use App\Models\Component;
use Packages\Documents\App\Classes\Front\Data\DocumentsData;
use Packages\Store\app\Classes\Front\Data\AttributeListData;
use Packages\Store\app\Classes\Front\Data\ProductsData;
use Packages\ImageHotspots\App\Classes\Front\Data\HotspotImageData;

class ComponentData {

    public $data_array;
    public $result;
    public $component;

    public function __construct(Component $component, $data_array)
    {
        $this->result = new \stdClass();
        $this->data_array = $data_array;
        $this->component = $component;
    }

    public function getData()
    {
        foreach($this->component->fields as $field)
        {
            $this->getClassField($field->type)->setData($this, $field);
        }
        return $this->result;
    }

    public function getTerms()
    {
        return $this->component->getTerms();
    }

    private function getClassField($type)
    {
        $opt = [
            'text'=>new Text(),
            'textarea-single'=>new Text(),
            'textearea-editor'=>new Text(),
            'integer'=> new Integer,
            'menu'=> new MenuData,
            'articles-list'=>new ArticleData(),
            'image'=>new Image(),
            'category-list'=>new CategoryData(),
            'checkbox'=>new Checkbox(),
            'doc'=>new Document(),
            'form'=>new Form(),
            'video'=>new Video(),
            'texts-list'=>new TextsList(),
            'titles-texts-list'=>new TextsList(),
            'select-single'=>new SelectSingle(),
            'select-multiple'=>new SelectMultiple(),
            'internal_link'=> new InternalLink(),
            'tags-list'=> new TagList(),
        ];

        if(env('APP_STORE'))
        {
            $opt = array_merge($opt, [
                'products-list'=>new ProductsData(),
                'attributes-list'=>new AttributeListData()
            ]);
        }

        if(env('APP_DOCUMENTS'))
        {
            $opt = array_merge($opt, [
                'documents-list'=>new DocumentsData()
            ]);
        }

        if(env('APP_IMAGE_HOTSPOTS'))
        {
            $opt = array_merge($opt, [
                'image-hotspots'=>new HotspotImageData()
            ]);
        }

        return $opt[$type];
    }
}
