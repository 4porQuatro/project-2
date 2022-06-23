<?php


namespace App\Classes\Front\Data;


use App\Models\Article;
use App\Models\Page;
use App\Models\Tag;
use Packages\Store\app\Models\Product;

class TagList extends FieldDataAbstract {


    public function setDefaultValue()
    {
        $page_tag = $this->setPageTag();
        $tags = (new Tag());

        if($this->optionMostUsedSelected())
        {
            $tags = $tags->mostUsed();
        } else {
            $tags = $tags->used()->orderBy('created_at', 'desc');
        }
        if(!empty($this->hasLimitSelected()))
        {
            $tags->limit($this->data->data_array[$this->field->name]['limit']);
        }
        return $tags->get()->map(function($tag) use ($page_tag){
            return [
                'name'=>$tag->name,
                'path'=>!empty($page_tag) ? $page_tag.'?tags='.$tag->id : ''
            ];
        });
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }


    public function setPageTag()
    {

        if( isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['page']))
        {
            $page_data = json_decode($this->data->data_array[$this->field->name]['page'], true);
            $class = $page_data['class'];
            $id = $page_data['id'];

            $object = $class::find($id);
            return !empty($object) ? $object->path() : '';
        }
        return  '';
    }

    public function optionMostUsedSelected()
    {

        return isset($this->data->data_array[$this->field->name])
            && isset($this->data->data_array[$this->field->name]['order'] )
            && $this->data->data_array[$this->field->name]['order'] === 'most_used';

    }

    public function optionMostRecentSelected()
    {

        return isset($this->data->data_array[$this->field->name])
            && isset($this->data->data_array[$this->field->name]['order'] )
            && $this->data->data_array[$this->field->name]['order'] === 'most_recent';

    }

    public function hasLimitSelected()
    {

        return isset($this->data->data_array[$this->field->name])
            && isset($this->data->data_array[$this->field->name]['limit'] )
            && $this->data->data_array[$this->field->name]['limit'];

    }

}
