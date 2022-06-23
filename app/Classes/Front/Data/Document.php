<?php


namespace App\Classes\Front\Data;


use App\Models\Component;
use App\Models\Field;
use Illuminate\Support\Facades\Storage;

class Document extends FieldDataAbstract {

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
        foreach($this->data->data_array[$this->field->name] as $doc)
        {
            $array[] = [
                'path'=>Storage::url($doc['path']),
                'alt_text'=>$doc['alt_text'],
                'size'=>$this->formatSizeUnits(Storage::size($doc['path']))
            ];
        }
        return $array;
    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
