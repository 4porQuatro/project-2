<?php


namespace Packages\ImageHotspots\App\Classes\Front\Data;


use App\Classes\Front\Data\FieldDataAbstract;
use Illuminate\Support\Facades\Storage;
use Packages\ImageHotspots\App\Models\HotspotImage;

class HotspotImageData extends FieldDataAbstract
{

    public function setDefaultValue()
    {
        $obj = new \stdClass();
        $obj->image = isset($this->data->data_array[$this->field->name]) ? $this->generateArray() : [];
        $obj->hotspots = isset($this->data->data_array[$this->field->name][0]['hotspot_image_id']) ? $this->getHotspots() : [];
        return $obj;
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
            $array = [
                'path'=>Storage::url($image['path']),
                'alt_text'=>$image['alt_text']
            ];
        }
        return $array;
    }

    public function getHotspots()
    {
        $hotspot_image_id = $this->data->data_array[$this->field->name][0]['hotspot_image_id'];
        $hotspot_image = HotspotImage::find($hotspot_image_id);
        if(empty($hotspot_image))
        {
            return [];
        }

        return $hotspot_image->hotspots()->ordered()->get();
    }
}
