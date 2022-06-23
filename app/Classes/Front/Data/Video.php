<?php


namespace App\Classes\Front\Data;


use App\Models\Component;
use App\Models\Field;
use Illuminate\Support\Facades\Storage;

class Video extends FieldDataAbstract {

    public function setDefaultValue()
    {
        return isset($this->data->data_array[$this->field->name]) ? $this->generateArray() : [];
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }

    public function generateArray()
    {
        $array = [];
        foreach($this->data->data_array[$this->field->name] as $image)
        {
            $array[] = [
                'path'=>Storage::url($image['path']),
                'alt_text'=>$image['alt_text']
            ];
        }
        return $array;
    }
}
